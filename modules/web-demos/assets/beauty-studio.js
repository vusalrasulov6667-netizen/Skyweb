/**
 * Sky Beauty — Virtual Stil Studiyası mühərriki (brauzerdə, offline).
 * ------------------------------------------------------------------
 * MediaPipe Tasks Vision:
 *   • ImageSegmenter (selfie_multiclass) → saç / üz dərisi maskası
 *   • FaceLandmarker → dodaq, göz, qaş, yanaq nöqtələri
 *   • HandLandmarker → barmaq ucları (dırnaq)
 *
 * Şəkil heç bir serverə göndərilmir — hər şey canvas-da hesablanır.
 *
 * İstifadə:
 *   BeautyStudio.configure({ base: '...assets/ai/', onStatus: fn });
 *   const res = await BeautyStudio.process(canvasOrImg, {
 *     mode: 'hair' | 'gloss' | 'makeup' | 'brow' | 'nails' | 'sample',
 *     color: { hex, h, s, l },
 *     opts: { ... }
 *   });
 *   if (res.ok) stage.appendChild(res.canvas);
 */
(function () {
  'use strict';

  var BASE = '';
  var onStatus = function () {};
  var visionPromise = null;
  var segmenterPromise = null;
  var facePromise = null;
  var handPromise = null;

  var MAX_W = 900;

  function setStatus(text) {
    try { onStatus(text || ''); } catch (e) {}
  }

  function loadVision() {
    if (visionPromise) return visionPromise;
    visionPromise = import(BASE + 'vision_bundle.mjs').then(function (v) {
      return v.FilesetResolver.forVisionTasks(BASE + 'wasm').then(function (fileset) {
        return { lib: v, fileset: fileset };
      });
    }).catch(function (e) { visionPromise = null; throw e; });
    return visionPromise;
  }

  function getSegmenter() {
    if (segmenterPromise) return segmenterPromise;
    segmenterPromise = loadVision().then(function (ctx) {
      return ctx.lib.ImageSegmenter.createFromOptions(ctx.fileset, {
        baseOptions: { modelAssetPath: BASE + 'models/selfie_multiclass_256x256.tflite', delegate: 'CPU' },
        runningMode: 'IMAGE',
        outputCategoryMask: true,
        outputConfidenceMasks: false
      });
    }).catch(function (e) { segmenterPromise = null; throw e; });
    return segmenterPromise;
  }

  function getFace() {
    if (facePromise) return facePromise;
    facePromise = loadVision().then(function (ctx) {
      return ctx.lib.FaceLandmarker.createFromOptions(ctx.fileset, {
        baseOptions: { modelAssetPath: BASE + 'models/face_landmarker.task', delegate: 'CPU' },
        runningMode: 'IMAGE',
        numFaces: 1
      });
    }).catch(function (e) { facePromise = null; throw e; });
    return facePromise;
  }

  function getHand() {
    if (handPromise) return handPromise;
    handPromise = loadVision().then(function (ctx) {
      return ctx.lib.HandLandmarker.createFromOptions(ctx.fileset, {
        baseOptions: { modelAssetPath: BASE + 'models/hand_landmarker.task', delegate: 'CPU' },
        runningMode: 'IMAGE',
        numHands: 2
      });
    }).catch(function (e) { handPromise = null; throw e; });
    return handPromise;
  }

  /* ───────────────────────── köməkçilər ───────────────────────── */

  function makeCanvas(w, h) {
    var c = document.createElement('canvas');
    c.width = Math.max(1, Math.round(w));
    c.height = Math.max(1, Math.round(h));
    return c;
  }

  function drawSource(source) {
    var sw = source.naturalWidth || source.videoWidth || source.width;
    var sh = source.naturalHeight || source.videoHeight || source.height;
    var w = Math.min(MAX_W, sw);
    var h = Math.round(sh * w / sw);
    var c = makeCanvas(w, h);
    c.getContext('2d').drawImage(source, 0, 0, w, h);
    return c;
  }

  function hexToRgb(hex) {
    var n = parseInt(String(hex || '#C79A5B').replace('#', ''), 16);
    return [(n >> 16) & 255, (n >> 8) & 255, n & 255];
  }

  function hslToRgb(h, s, l) {
    if (s === 0) return [l, l, l];
    var f = function (p, q, t) {
      if (t < 0) t += 1;
      if (t > 1) t -= 1;
      if (t < 1 / 6) return p + (q - p) * 6 * t;
      if (t < 1 / 2) return q;
      if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6;
      return p;
    };
    var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
    var p = 2 * l - q;
    return [f(p, q, h + 1 / 3), f(p, q, h), f(p, q, h - 1 / 3)];
  }

  /** Segmentasiya maskasından ağ/səffaf maska canvas-ı. */
  function maskCanvas(categoryMask, classId, blur) {
    var mw = categoryMask.width, mh = categoryMask.height;
    var cats = categoryMask.getAsUint8Array();
    var m = makeCanvas(mw, mh);
    var mctx = m.getContext('2d');
    var img = mctx.createImageData(mw, mh);
    var count = 0;
    for (var i = 0; i < cats.length; i++) {
      var on = cats[i] === classId;
      if (on) count++;
      img.data[i * 4] = 255;
      img.data[i * 4 + 1] = 255;
      img.data[i * 4 + 2] = 255;
      img.data[i * 4 + 3] = on ? 255 : 0;
    }
    mctx.putImageData(img, 0, 0);
    return { canvas: m, ratio: cats.length ? count / cats.length : 0, count: count };
  }

  function scaleMask(mask, w, h, blur) {
    var out = makeCanvas(w, h);
    var c = out.getContext('2d');
    c.imageSmoothingEnabled = true;
    if (blur) c.filter = 'blur(' + blur + 'px)';
    c.drawImage(mask, 0, 0, w, h);
    c.filter = 'none';
    return out;
  }

  function segment(source) {
    return getSegmenter().then(function (seg) {
      return new Promise(function (resolve, reject) {
        seg.segment(source, function (res) {
          try {
            var hair = maskCanvas(res.categoryMask, 1, 0);
            var skin = maskCanvas(res.categoryMask, 3, 0);
            resolve({ hair: hair, skin: skin, close: function () { res.close(); } });
          } catch (e) {
            try { res.close(); } catch (e2) {}
            reject(e);
          }
        });
      });
    });
  }

  /* ───────────────────────── saç rəngi ───────────────────────── */

  function paintHair(src, masks, color, opts) {
    var W = src.width, H = src.height;
    var hairMask = scaleMask(masks.hair.canvas, W, H, 2);
    var out = makeCanvas(W, H);
    var ctx = out.getContext('2d');
    ctx.drawImage(src, 0, 0);

    var img = ctx.getImageData(0, 0, W, H);
    var md = hairMask.getContext('2d').getImageData(0, 0, W, H).data;
    var px = img.data;

    var th = (typeof color.h === 'number' ? color.h : 30) / 360;
    var ts = typeof color.s === 'number' ? color.s : 0.45;
    var tl = typeof color.l === 'number' ? color.l : 0.45;
    var strength = Math.max(0.3, Math.min(1, (opts && opts.strength) || 0.9));
    var balayage = !!(opts && opts.balayage);

    // saçın orta işıqlığı — parlaqlıq strukturunu qorumaq üçün
    var sumL = 0, cnt = 0;
    for (var i = 0; i < px.length; i += 4) {
      if (md[i + 3] < 40) continue;
      sumL += (Math.max(px[i], px[i + 1], px[i + 2]) + Math.min(px[i], px[i + 1], px[i + 2])) / 510;
      cnt++;
    }
    if (cnt < W * H * 0.004) return { ok: false, error: 'no_hair' };
    var avgL = sumL / cnt;

    for (var y = 0; y < H; y++) {
      var grad = balayage ? 0.5 + 0.5 * (y / H) : 1;
      for (var x = 0; x < W; x++) {
        var k = (y * W + x) * 4;
        var a = md[k + 3] / 255;
        if (a < 0.05) continue;

        var r = px[k] / 255, g = px[k + 1] / 255, b = px[k + 2] / 255;
        var mx = Math.max(r, g, b), mn = Math.min(r, g, b);
        var h = 0, s = 0, l = (mx + mn) / 2;
        if (mx !== mn) {
          var d = mx - mn;
          s = l > 0.5 ? d / (2 - mx - mn) : d / (mx + mn);
          if (mx === r) h = (g - b) / d + (g < b ? 6 : 0);
          else if (mx === g) h = (b - r) / d + 2;
          else h = (r - g) / d + 4;
          h /= 6;
        }

        var amt = a * strength * grad;
        var ns = s + (ts - s) * amt;
        var nl = Math.max(0, Math.min(1, tl + (l - avgL) * 1.05));
        var nl2 = l + (nl - l) * amt;
        var rgb = hslToRgb(th, ns, nl2);
        px[k] = Math.round(rgb[0] * 255);
        px[k + 1] = Math.round(rgb[1] * 255);
        px[k + 2] = Math.round(rgb[2] * 255);
      }
    }
    ctx.putImageData(img, 0, 0);
    return { ok: true, canvas: out };
  }

  /* ───────────────────────── keratin / parlaqlıq ─────────────── */

  function glossHair(src, masks, opts) {
    var W = src.width, H = src.height;
    var hairMask = scaleMask(masks.hair.canvas, W, H, 2);
    if (masks.hair.ratio < 0.004) return { ok: false, error: 'no_hair' };

    var sheen = Math.max(0.1, Math.min(1, (opts && opts.sheen) || 0.6));
    var out = makeCanvas(W, H);
    var ctx = out.getContext('2d');
    ctx.drawImage(src, 0, 0);

    // yumşaltma: saç sahəsində yüngül blur
    var soft = makeCanvas(W, H);
    var sctx = soft.getContext('2d');
    sctx.filter = 'blur(1.4px)';
    sctx.drawImage(src, 0, 0);
    sctx.filter = 'none';
    sctx.globalCompositeOperation = 'destination-in';
    sctx.drawImage(hairMask, 0, 0);
    sctx.globalCompositeOperation = 'source-over';

    ctx.globalAlpha = 0.75;
    ctx.drawImage(soft, 0, 0);
    ctx.globalAlpha = 1;

    // parlaqlıq zolağı
    var sheenC = makeCanvas(W, H);
    var sh = sheenC.getContext('2d');
    var grad = sh.createLinearGradient(W * 0.2, 0, W * 0.8, H);
    grad.addColorStop(0, 'rgba(255,255,255,0)');
    grad.addColorStop(0.35, 'rgba(255,255,255,' + (0.55 * sheen).toFixed(2) + ')');
    grad.addColorStop(0.5, 'rgba(255,255,255,' + (0.85 * sheen).toFixed(2) + ')');
    grad.addColorStop(0.65, 'rgba(255,255,255,' + (0.4 * sheen).toFixed(2) + ')');
    grad.addColorStop(1, 'rgba(255,255,255,0)');
    sh.fillStyle = grad;
    sh.fillRect(0, 0, W, H);
    sh.globalCompositeOperation = 'destination-in';
    sh.drawImage(hairMask, 0, 0);

    ctx.globalCompositeOperation = 'soft-light';
    ctx.globalAlpha = 0.9;
    ctx.drawImage(sheenC, 0, 0);
    ctx.globalCompositeOperation = 'source-over';
    ctx.globalAlpha = 1;

    return { ok: true, canvas: out };
  }

  /* ───────────────────────── üz / makiyaj ────────────────────── */

  var LIPS = [61, 146, 91, 181, 84, 17, 314, 405, 321, 375, 291, 409, 270, 269, 267, 0, 37, 39, 40, 185];
  var EYE_L_UP = [33, 246, 161, 160, 159, 158, 157, 173, 133];
  var EYE_R_UP = [362, 398, 384, 385, 386, 387, 388, 466, 263];
  var BROW_L = [70, 63, 105, 66, 107, 55, 65, 52, 53, 46];
  var BROW_R = [300, 293, 334, 296, 336, 285, 295, 282, 283, 276];

  function pts(landmarks, idx, W, H) {
    return idx.map(function (i) {
      var p = landmarks[i];
      return { x: p.x * W, y: p.y * H };
    });
  }

  function polyPath(ctx, points) {
    ctx.beginPath();
    ctx.moveTo(points[0].x, points[0].y);
    for (var i = 1; i < points.length; i++) ctx.lineTo(points[i].x, points[i].y);
    ctx.closePath();
  }

  /** Zolağı əyrinin normali boyunca (yuxarı) qalınlaşdırır — göz kölgəsi üçün. */
  function bandPath(ctx, points, thickness) {
    var upper = points.map(function (q, i) {
      var a = points[Math.max(0, i - 1)];
      var b = points[Math.min(points.length - 1, i + 1)];
      var tx = b.x - a.x, ty = b.y - a.y;
      var l = Math.sqrt(tx * tx + ty * ty) || 1;
      var nx = ty / l, ny = -tx / l;
      if (ny > 0) { nx = -nx; ny = -ny; } // canvas-da yuxarı = mənfi y
      return { x: q.x + nx * thickness, y: q.y + ny * thickness };
    });
    polyPath(ctx, points.concat(upper.reverse()));
  }

  function paintFace(src, masks, landmarks, style) {
    var W = src.width, H = src.height;
    var opts = style.opts || {};
    var hex = (style.color && style.color.hex) || '#C4586B';
    var rgb = hexToRgb(hex);
    var col = function (a) { return 'rgba(' + rgb[0] + ',' + rgb[1] + ',' + rgb[2] + ',' + a + ')'; };

    var out = makeCanvas(W, H);
    var ctx = out.getContext('2d');
    ctx.drawImage(src, 0, 0);

    // dodaq
    if (opts.lips) {
      var lip = makeCanvas(W, H);
      var lc = lip.getContext('2d');
      lc.filter = 'blur(3px)';
      lc.fillStyle = col(0.95);
      polyPath(lc, pts(landmarks, LIPS, W, H));
      lc.fill();
      lc.filter = 'none';
      ctx.globalCompositeOperation = 'multiply';
      ctx.globalAlpha = Math.min(0.85, opts.lips);
      ctx.drawImage(lip, 0, 0);
      ctx.globalCompositeOperation = 'soft-light';
      ctx.globalAlpha = Math.min(0.5, opts.lips * 0.5);
      ctx.drawImage(lip, 0, 0);
      ctx.globalCompositeOperation = 'source-over';
      ctx.globalAlpha = 1;
    }

    // göz kölgəsi — kirpik xəttinin birbaşa üstündə, əyri boyunca
    if (opts.eyes) {
      var eye = makeCanvas(W, H);
      var ec = eye.getContext('2d');
      ec.filter = 'blur(' + Math.max(2, W * 0.005) + 'px)';
      ec.fillStyle = col(0.85);
      var eyeBand = Math.max(4, W * 0.022);
      [EYE_L_UP, EYE_R_UP].forEach(function (idx) {
        bandPath(ec, pts(landmarks, idx, W, H), eyeBand);
        ec.fill();
      });
      ec.filter = 'none';
      ctx.globalCompositeOperation = 'multiply';
      ctx.globalAlpha = Math.min(0.7, opts.eyes);
      ctx.drawImage(eye, 0, 0);
      ctx.globalCompositeOperation = 'source-over';
      ctx.globalAlpha = 1;
    }

    // yanaq allığı
    if (opts.blush) {
      var bl = makeCanvas(W, H);
      var bc = bl.getContext('2d');
      [205, 425].forEach(function (i) {
        var p = landmarks[i];
        var cx = p.x * W, cy = p.y * H;
        var rad = Math.max(18, W * 0.09);
        var g = bc.createRadialGradient(cx, cy, 0, cx, cy, rad);
        g.addColorStop(0, col(0.55));
        g.addColorStop(1, col(0));
        bc.fillStyle = g;
        bc.beginPath();
        bc.arc(cx, cy, rad, 0, Math.PI * 2);
        bc.fill();
      });
      ctx.globalCompositeOperation = 'soft-light';
      ctx.globalAlpha = Math.min(0.9, opts.blush);
      ctx.drawImage(bl, 0, 0);
      ctx.globalCompositeOperation = 'source-over';
      ctx.globalAlpha = 1;
    }

    // eyeliner
    if (opts.liner) {
      ctx.strokeStyle = 'rgba(24,18,22,0.9)';
      ctx.lineCap = 'round';
      ctx.lineJoin = 'round';
      ctx.lineWidth = Math.max(1.6, W * 0.0035);
      ctx.globalAlpha = Math.min(0.95, opts.liner);
      [EYE_L_UP, EYE_R_UP].forEach(function (idx) {
        var p = pts(landmarks, idx, W, H);
        ctx.beginPath();
        ctx.moveTo(p[0].x, p[0].y);
        for (var i = 1; i < p.length; i++) ctx.lineTo(p[i].x, p[i].y);
        ctx.stroke();
        // qanad XARİCİ küncdən (p[0] = 33 / 362) çıxır, daxili küncdən deyil
        var outer = p[0], next = p[1];
        var dx = outer.x - next.x, dy = outer.y - next.y;
        var len = Math.sqrt(dx * dx + dy * dy) || 1;
        dx /= len; dy /= len;
        var wing = W * 0.038;
        ctx.beginPath();
        ctx.moveTo(outer.x - dx * wing * 0.3, outer.y - dy * wing * 0.3);
        ctx.lineTo(outer.x + dx * wing, outer.y + dy * wing - W * 0.012);
        ctx.stroke();
      });
      ctx.globalAlpha = 1;
    }

    // şüşə dəri — üz dərisini işıqlandır
    if (opts.glow && masks.skin && masks.skin.ratio > 0.005) {
      var skinMask = scaleMask(masks.skin.canvas, W, H, 4);
      var gl = makeCanvas(W, H);
      var gc = gl.getContext('2d');
      gc.fillStyle = 'rgba(255,246,238,0.85)';
      gc.fillRect(0, 0, W, H);
      gc.globalCompositeOperation = 'destination-in';
      gc.drawImage(skinMask, 0, 0);
      ctx.globalCompositeOperation = 'soft-light';
      ctx.globalAlpha = Math.min(0.75, opts.glow);
      ctx.drawImage(gl, 0, 0);
      ctx.globalCompositeOperation = 'source-over';
      ctx.globalAlpha = 1;
    }

    return { ok: true, canvas: out };
  }

  function paintBrows(src, landmarks, style) {
    var W = src.width, H = src.height;
    var opts = style.opts || {};
    var rgb = hexToRgb((style.color && style.color.hex) || '#6B4A34');
    var out = makeCanvas(W, H);
    var ctx = out.getContext('2d');
    ctx.drawImage(src, 0, 0);

    var layer = makeCanvas(W, H);
    var lc = layer.getContext('2d');
    lc.filter = 'blur(1.5px)';
    lc.fillStyle = 'rgba(' + rgb[0] + ',' + rgb[1] + ',' + rgb[2] + ',0.95)';

    // Qaş konturu landmarkların özüdür (70→46 / 300→276): aşağı sıra 0..4,
    // yuxarı sıra 5..9. Köhnə kod konturu olduğundan aşağı "qatlayırdı" —
    // indi rəng birbaşa qaşın üzərinə çəkilir.
    var shape = opts.shape || 'natural';
    [BROW_L, BROW_R].forEach(function (idx) {
      var p = pts(landmarks, idx, W, H);
      if (shape === 'straight' || shape === 'arch') {
        var dy = shape === 'straight' ? W * 0.006 : -W * 0.006;
        p = p.map(function (q, i) {
          if (i < 5) return q;
          var w = Math.max(0, 1 - Math.abs(i - 7) / 3);
          return { x: q.x, y: q.y + dy * w };
        });
      }
      polyPath(lc, p);
      lc.fill();
    });
    lc.filter = 'none';

    ctx.globalCompositeOperation = 'multiply';
    ctx.globalAlpha = Math.min(0.85, opts.strength || 0.7);
    ctx.drawImage(layer, 0, 0);
    ctx.globalCompositeOperation = 'source-over';
    ctx.globalAlpha = 1;

    return { ok: true, canvas: out };
  }

  /* ───────────────────────── dırnaqlar ───────────────────────── */

  function samplePixel(data, W, H, x, y) {
    x = Math.round(x); y = Math.round(y);
    if (x < 0 || y < 0 || x >= W || y >= H) return null;
    var k = (y * W + x) * 4;
    return [data[k], data[k + 1], data[k + 2]];
  }

  /**
   * Dırnaq lövhəsinin şəkildəki faktiki yerini tapmağa kömək edən yüngül heuristika.
   * Dəri rəngini distal falanxın proximal hissəsindən götürüb, uc hissədə ondan
   * fərqlənən piksellərin ağırlıqlı mərkəzini qaytarır. Landmark oxu ilə foto
   * üst-üstə düşmədikdə (əyilmiş barmaq, yan görünüş) lövhəni düzgün yerə çəkir.
   */
  function nailHint(data, W, H, bx, by, dx, dy, tx, ty, len) {
    if (!data) return null;
    var nx = -dy, ny = dx;
    var skin = [];
    for (var t = 0.12; t <= 0.38; t += 0.05) {
      for (var o = -0.18; o <= 0.18; o += 0.06) {
        var q = samplePixel(data, W, H, bx + dx * len * t + nx * len * o, by + dy * len * t + ny * len * o);
        if (q) skin.push(q);
      }
    }
    if (skin.length < 6) return null;
    skin.sort(function (a, b) { return (a[0] + a[1] + a[2]) - (b[0] + b[1] + b[2]); });
    var ref = skin[Math.floor(skin.length / 2)];
    var sx = 0, sy = 0, sw = 0, cnt = 0;
    var aMin = Infinity, aMax = -Infinity, sMin = Infinity, sMax = -Infinity;
    for (var t2 = 0.55; t2 <= 1.02; t2 += 0.03) {
      for (var o2 = -0.26; o2 <= 0.26; o2 += 0.03) {
        var px = bx + dx * len * t2 + nx * len * o2;
        var py = by + dy * len * t2 + ny * len * o2;
        var c = samplePixel(data, W, H, px, py);
        if (!c) continue;
        if (c[0] > 246 && c[1] > 246 && c[2] > 246) continue; // ağ fon
        var dist = Math.abs(c[0] - ref[0]) + Math.abs(c[1] - ref[1]) + Math.abs(c[2] - ref[2]);
        if (dist < 85) continue;
        sx += px * dist; sy += py * dist; sw += dist; cnt++;
        var pa = (dx * (px - tx) + dy * (py - ty)) / len;
        var ps = (nx * (px - tx) + ny * (py - ty)) / len;
        if (pa < aMin) aMin = pa;
        if (pa > aMax) aMax = pa;
        if (ps < sMin) sMin = ps;
        if (ps > sMax) sMax = ps;
      }
    }
    if (cnt < 15 || sw <= 0) return null;
    var cx = sx / sw, cy = sy / sw;
    return {
      along: (dx * (cx - tx) + dy * (cy - ty)) / len,
      side:  (nx * (cx - tx) + ny * (cy - ty)) / len,
      // Faktiki lövhənin uc/kənar yayılması — rəng boşluq qoymadan bütün lövhəni örtsün.
      alongMin: aMin, alongMax: aMax,
      sideMin: sMin, sideMax: sMax
    };
  }

  function shade(rgb, f) {
    return rgb.map(function (v) {
      return Math.max(0, Math.min(255, Math.round(f >= 0 ? v + (255 - v) * f : v * (1 + f))));
    });
  }
  function rgba(c, a) { return 'rgba(' + c[0] + ',' + c[1] + ',' + c[2] + ',' + a + ')'; }
  function clamp(v, a, b) { return Math.max(a, Math.min(b, v)); }

  /**
   * Əlin tam görünmədiyi yaxın dırnaq fotoşəkillərində və ya iki əldə MediaPipe
   * bəzən landmark qaytarmır. Bu halda köhnə oje rəngini birbaşa piksel səviyyəsində
   * tapıb seçilən rəngə çeviririk — nümunə modelə heç vaxt keçmirik.
   * Üz fotoşəkillərində yanlış işləməmək üçün yalnız çoxlu (≥3) kiçik, doymuş
   * lövhə formaları axtarırıq və üz tapıldıqda üz sahəsini istisna edirik.
   */
  function copySource(src) {
    var c = makeCanvas(src.width, src.height);
    c.getContext('2d').drawImage(src, 0, 0);
    return c;
  }

  /** Doymuş köhnə oje rəngi (qırmızı / bordo / narıncı-qırmızı)? */
  function isOldPolish(data, k) {
    var r = data[k], g = data[k + 1], b = data[k + 2];
    var mx = Math.max(r, g, b), mn = Math.min(r, g, b), d = mx - mn;
    // Tünd saçın köhnə oje sayılmaması üçün rəng kifayət qədər açıq və doymuş olmalıdır.
    // Üst hədd 255-ə qaldırıldı: parlaq narıncı-qırmızı ojelərdə R kanalı 255 olur.
    if (mx < 95 || d < 52) return false;
    var h = 0;
    if (mx === r) h = ((g - b) / d + (g < b ? 6 : 0)) * 60;
    else if (mx === g) h = ((b - r) / d + 2) * 60;
    else h = ((r - g) / d + 4) * 60;
    var s = d / mx;
    // Qırmızı, bordo və narıncı-qırmızı (h ≤ 32°) oje: yaşıl fon, tünd saç və
    // dəri yanlış rənglənməsin. Dəri tonlarında g r-nin 0.66-sından yüksək olur.
    return (h >= 325 || h <= 32) && s >= 0.38 && r > 105 && g < r * 0.66 && b < r * 0.76;
  }

  function findOldNailPixels(data, W, H) {
    var labels = new Int32Array(W * H);
    for (var z = 0; z < labels.length; z++) labels[z] = -1;
    var stack = [];
    var blobs = [];

    for (var i = 0; i < W * H; i++) {
      if (labels[i] !== -1 || !isOldPolish(data, i * 4)) continue;

      var id = blobs.length;
      var head = 0;
      stack.length = 0;
      stack.push(i);
      labels[i] = id;
      var count = 0, sx = 0, sy = 0;
      var minx = W, miny = H, maxx = 0, maxy = 0;

      while (head < stack.length) {
        var p = stack[head++];
        var x = p % W, y = (p - x) / W;
        count++; sx += x; sy += y;
        if (x < minx) minx = x;
        if (x > maxx) maxx = x;
        if (y < miny) miny = y;
        if (y > maxy) maxy = y;
        // Qonşunu yalnız özü də köhnə rəngdirsə əlavə et — əks halda bütün
        // şəkil tək bir lövhəyə birləşir və heç bir dırnaq tapılmır.
        if (x > 0 && labels[p - 1] === -1 && isOldPolish(data, (p - 1) * 4)) { labels[p - 1] = id; stack.push(p - 1); }
        if (x < W - 1 && labels[p + 1] === -1 && isOldPolish(data, (p + 1) * 4)) { labels[p + 1] = id; stack.push(p + 1); }
        if (y > 0 && labels[p - W] === -1 && isOldPolish(data, (p - W) * 4)) { labels[p - W] = id; stack.push(p - W); }
        if (y < H - 1 && labels[p + W] === -1 && isOldPolish(data, (p + W) * 4)) { labels[p + W] = id; stack.push(p + W); }
      }

      var bw = maxx - minx + 1, bh = maxy - miny + 1;
      var fill = count / (bw * bh);
      var ar = bw / bh;
      // Dırnaq lövhələri şəklin kiçik hissəsini tutur; bütün ekranı və ya fonu
      // əhatə edən nəhəng lövhələr isə köhnə oje sayılmır.
      var ok = count >= 25 && count <= W * H * 0.12 && bw >= 4 && bh >= 4 &&
        bw <= W * 0.62 && bh <= H * 0.62 && fill >= 0.12 &&
        ar >= 0.22 && ar <= 4.5;
      blobs.push({ ok: ok, n: count, cx: sx / count, cy: sy / count,
        x1: minx, y1: miny, x2: maxx, y2: maxy });
    }
    return { labels: labels, blobs: blobs };
  }

  function recolorOldNails(src, style, lms, handsFound) {
    var W = src.width, H = src.height;
    var srcData;
    try { srcData = src.getContext('2d').getImageData(0, 0, W, H).data; }
    catch (e) { return Promise.resolve(null); }

    var found = findOldNailPixels(srcData, W, H);
    var blobs = found.blobs, labels = found.labels;
    if (!blobs.length) return Promise.resolve(null);

    return getFace().then(function (face) {
      var box = null;
      try {
        var r = face.detect(src);
        var lm = (r.faceLandmarks && r.faceLandmarks[0]) || null;
        if (lm && lm.length) {
          var fx1 = W, fy1 = H, fx2 = 0, fy2 = 0;
          lm.forEach(function (p) {
            var x = p.x * W, y = p.y * H;
            if (x < fx1) fx1 = x;
            if (x > fx2) fx2 = x;
            if (y < fy1) fy1 = y;
            if (y > fy2) fy2 = y;
          });
          var padX = (fx2 - fx1) * 0.06, padY = (fy2 - fy1) * 0.06;
          box = { x1: fx1 - padX, y1: fy1 - padY, x2: fx2 + padX, y2: fy2 + padY };
        }
      } catch (e) { box = null; }

      var keep = 0;
      blobs.forEach(function (b) {
        if (!b.ok) return;
        // Əl tapılmadıqda yalnız dırnaq ölçüsündə lövhələri qəbul et — üzdəki
        // dodaq boyası və kiçik qırmızı ləkələr rənglənməsin.
        var bw = b.x2 - b.x1 + 1, bh = b.y2 - b.y1 + 1;
        if (!handsFound && (b.n < 120 || bw < 9 || bh < 9)) return;
        if (box && b.cx >= box.x1 && b.cx <= box.x2 && b.cy >= box.y1 && b.cy <= box.y2) return;
        b.use = true;
        keep++;
      });
      // Əl yoxdursa, tək dodaq/ləkə yanlış deteksiya sayılmasın — ən azı 3 lövhə tələb et.
      if (!handsFound && keep < 3) return null;
      if (!keep) return null;

      var out = copySource(src);
      var ctx = out.getContext('2d');
      var img = ctx.getImageData(0, 0, W, H);
      var d = img.data;
      // Maska yalnız köhnə oje lövhələrini (1 px antialias genişlətməsi ilə) göstərir.
      // Landmark üzərində çəkilən stil detalları bu maskadan kənara çıxa bilməz —
      // əks halda dırnaq əvəzinə dəri üzərində ləkələr görünür.
      var mask = makeCanvas(W, H);
      var mctx = mask.getContext('2d');
      var mimg = mctx.createImageData(W, H);
      var md = mimg.data;
      var rgb = hexToRgb((style.color && style.color.hex) || '#D0A88F');

      for (var y = 0; y < H; y++) {
        for (var x = 0; x < W; x++) {
          var i = y * W + x;
          var id = labels[i];
          var use = false;
          if (id >= 0 && blobs[id] && blobs[id].use) use = true;
          // Antialias kənarlarını da örtmək üçün 1 px genişlətmə.
          if (!use) {
            if (x > 0 && labels[i - 1] >= 0 && blobs[labels[i - 1]] && blobs[labels[i - 1]].use) use = true;
            else if (x < W - 1 && labels[i + 1] >= 0 && blobs[labels[i + 1]] && blobs[labels[i + 1]].use) use = true;
            else if (y > 0 && labels[i - W] >= 0 && blobs[labels[i - W]] && blobs[labels[i - W]].use) use = true;
            else if (y < H - 1 && labels[i + W] >= 0 && blobs[labels[i + W]] && blobs[labels[i + W]].use) use = true;
          }
          if (!use) continue;
          var k = i * 4;
          md[k] = 255; md[k + 1] = 255; md[k + 2] = 255; md[k + 3] = 255;
          var lum = (d[k] * 0.299 + d[k + 1] * 0.587 + d[k + 2] * 0.114) / 255;
          var f = 0.90 + 0.20 * lum; // seçilən rəngə yaxın, yalnız yüngül kölgə saxlanır
          d[k] = clamp(Math.round(rgb[0] * f), 0, 255);
          d[k + 1] = clamp(Math.round(rgb[1] * f), 0, 255);
          d[k + 2] = clamp(Math.round(rgb[2] * f), 0, 255);
        }
      }
      ctx.putImageData(img, 0, 0);
      mctx.putImageData(mimg, 0, 0);
      return { canvas: out, count: keep, mask: mask };
    }).catch(function () { return null; });
  }

  function paintNails(src, hands, style) {
    var W = src.width, H = src.height;
    if (!hands || !hands.length) return { ok: false, error: 'no_hand' };

    var opts = style.opts || {};
    var hex = (style.color && style.color.hex) || '#D0A88F';
    var rgb = hexToRgb(hex);
    var out = makeCanvas(W, H);
    var ctx = out.getContext('2d');
    ctx.drawImage(src, 0, 0);
    var pixels = null, gotPixels = false;

    // DIP→TIP = distal falanx. Qeyd: köhnə kod lövhəni bütün falanxa yayırdı
    // (0.66 × uzunluq) — buna görə rəng dırnağın üstünə deyil, dəriyə düşürdü.
    var DIPS = [3, 7, 11, 15, 19];
    var TIPS = [4, 8, 12, 16, 20];
    var PIPS = [2, 6, 10, 14, 18];

    hands.forEach(function (lm) {
      if (!lm || lm.length < 21) return;
      if (!gotPixels) {
        try { pixels = src.getContext('2d').getImageData(0, 0, W, H).data; } catch (e) { pixels = null; }
        gotPixels = true;
      }
      TIPS.forEach(function (tipIdx, n) {
        var tip = lm[tipIdx], dip = lm[DIPS[n]], pip = lm[PIPS[n]];
        if (!tip || !dip) return;
        var tx = tip.x * W, ty = tip.y * H;
        var bx = dip.x * W, by = dip.y * H;
        var dx = tx - bx, dy = ty - by;
        var phalanx = Math.sqrt(dx * dx + dy * dy);
        if (phalanx < 2) return;
        dx /= phalanx; dy /= phalanx;
        var nx = -dy, ny = dx;
        var thumb = n === 0;

        // Lövhə falanxın ucunda yerləşir. Default ölçü faktiki dırnağı tam örtəcək qədər genişdir.
        var nailLen = phalanx * (thumb ? 0.48 : 0.44);
        var nailW = nailLen * (thumb ? 0.82 : 0.76);
        var centerT = 1 - (nailLen / phalanx) * 0.5; // ≈0.78 / başbarmaq ≈0.76
        var cx = bx + dx * phalanx * centerT;
        var cy = by + dy * phalanx * centerT;

        // Faktiki rəngli lövhəni şəkildən tapırıq: mərkəzi ona, ölçünü isə
        // lövhənin uc və kənar yayılmasına görə tənzimləyirik — boşluq qalmır.
        var hint = nailHint(pixels, W, H, bx, by, dx, dy, tx, ty, phalanx);
        if (hint) {
          var along = clamp(hint.along, -0.42, -0.02) * phalanx;
          var side = clamp(hint.side, -0.24, 0.24) * phalanx;
          cx = tx + dx * along + nx * side;
          cy = ty + dy * along + ny * side;
          var spanL = hint.alongMax - hint.alongMin;
          var spanW = hint.sideMax - hint.sideMin;
          if (isFinite(spanL) && spanL > 0.08) {
            nailLen = clamp(spanL * 1.18, 0.22, 0.52) * phalanx;
          }
          if (isFinite(spanW) && spanW > 0.08) {
            nailW = clamp(spanW * 1.20, 0.18, 0.48) * phalanx;
          }
        } else if (pip) {
          // Heuristika işləmədikdə əyilmə korreksiyası (PIP→DIP vs DIP→TIP).
          var vx = bx - pip.x * W, vy = by - pip.y * H;
          var vl = Math.sqrt(vx * vx + vy * vy) || 1;
          vx /= vl; vy /= vl;
          cx += (dx - vx) * phalanx * 0.16;
          cy += (dy - vy) * phalanx * 0.16;
        }

        // Lokal +Y = barmaq ucu istiqaməti (fransız ucu düzgün tərəfə düşür).
        var ang = Math.atan2(dy, dx) - Math.PI / 2;
        var hw = nailW / 2, hl = nailLen / 2;
        var r = nailW * 0.44;

        ctx.save();
        ctx.translate(cx, cy);
        ctx.rotate(ang);
        ctx.beginPath();
        ctx.moveTo(-hw + r, -hl);
        ctx.lineTo(hw - r, -hl);
        ctx.quadraticCurveTo(hw, -hl, hw, -hl + r);
        ctx.lineTo(hw, hl - r);
        ctx.quadraticCurveTo(hw, hl, hw - r, hl);
        ctx.lineTo(-hw + r, hl);
        ctx.quadraticCurveTo(-hw, hl, -hw, hl - r);
        ctx.lineTo(-hw, -hl + r);
        ctx.quadraticCurveTo(-hw, -hl, -hw + r, -hl);
        ctx.closePath();

        // Qalın qara kontur yerinə çox incə kölgə — karikatur görünüş aradan qalxır.
        ctx.save();
        ctx.translate(0, Math.max(0.5, nailW * 0.035));
        ctx.globalAlpha = 0.16;
        ctx.fillStyle = 'rgba(70,42,44,1)';
        ctx.fill();
        ctx.restore();

        // Gel-lak: tam örtücü rəng — köhnə oje/əvvəlki ton heç yerdə görünmür.
        // Kütikulada tündləşmə və uçda yumşaq işıq yalnız ton dərinliyi verir, şəffaflıq yox.
        var g = ctx.createLinearGradient(0, -hl, 0, hl);
        g.addColorStop(0, rgba(shade(rgb, -0.10), 1));
        g.addColorStop(0.35, rgba(rgb, 1));
        g.addColorStop(0.82, rgba(rgb, 1));
        g.addColorStop(1, rgba(shade(rgb, 0.05), 1));
        ctx.fillStyle = g;
        ctx.fill();

        if (opts.design === 'chrome') {
          var cg = ctx.createLinearGradient(-hw, 0, hw, 0);
          cg.addColorStop(0, 'rgba(120,126,134,0.55)');
          cg.addColorStop(0.28, 'rgba(255,255,255,0.62)');
          cg.addColorStop(0.52, rgba(shade(rgb, 0.18), 0.55));
          cg.addColorStop(0.78, 'rgba(238,240,242,0.50)');
          cg.addColorStop(1, 'rgba(96,102,110,0.55)');
          ctx.fillStyle = cg;
          ctx.fill();
        }

        // Fransız ucu — sərt ağ zolaq yox, krem-rəngli yumşaq keçid.
        if (opts.design === 'french') {
          var fg = ctx.createLinearGradient(0, hl - nailLen * 0.32, 0, hl);
          fg.addColorStop(0, 'rgba(247,242,234,0)');
          fg.addColorStop(0.35, 'rgba(247,242,234,0.72)');
          fg.addColorStop(1, 'rgba(247,242,234,0.86)');
          ctx.fillStyle = fg;
          ctx.beginPath();
          ctx.moveTo(-hw + r, hl - nailLen * 0.32);
          ctx.lineTo(hw - r, hl - nailLen * 0.32);
          ctx.quadraticCurveTo(hw, hl, hw - r, hl);
          ctx.lineTo(-hw + r, hl);
          ctx.quadraticCurveTo(-hw, hl, -hw + r, hl - nailLen * 0.32);
          ctx.closePath();
          ctx.fill();
        }

        if (opts.design === 'art') {
          ctx.globalAlpha = 0.72;
          ctx.fillStyle = '#f4ebe2';
          ctx.beginPath();
          ctx.arc(0, -hl * 0.2, Math.max(0.8, nailW * 0.07), 0, Math.PI * 2);
          ctx.fill();
          ctx.fillStyle = '#b99a56';
          ctx.beginPath();
          ctx.arc(nailW * 0.2, hl * 0.2, Math.max(0.7, nailW * 0.055), 0, Math.PI * 2);
          ctx.fill();
          ctx.globalAlpha = 1;
        }

        // İncə işıq zolağı — lak parlaqlığı (böyük ağ ellipse deyil).
        ctx.save();
        ctx.filter = 'blur(' + Math.max(0.4, nailW * 0.03) + 'px)';
        ctx.globalAlpha = 0.30;
        ctx.fillStyle = '#ffffff';
        ctx.beginPath();
        ctx.ellipse(-hw * 0.24, -hl * 0.05, nailW * 0.10, nailLen * 0.26, -0.22, 0, Math.PI * 2);
        ctx.fill();
        ctx.restore();

        ctx.restore();
      });
    });

    return { ok: true, canvas: out };
  }

  /**
   * Öz fotoşəkilində əl bəzən düzgün tapılmır (dırnaq yaxın çəkilmiş, barmaqlar
   * əyilmiş və ya şəkil 90° dönük). Əvvəlcə birbaşa deteksiya, sonra dönük və
   * kiçildilmiş varyantlar sınanır. Tapılan nöqtələr orijinal ölçüyə qaytarılır.
   */
  function detectHandRobust(hand, src) {
    var W = src.width, H = src.height;
    var direct = hand.detect(src);
    if (direct && direct.landmarks && direct.landmarks.length) return direct.landmarks;

    var angles = [90, 180, 270];
    for (var i = 0; i < angles.length; i++) {
      var found = detectWith(angles[i], 1) || detectWith(angles[i], 0.78);
      if (found && found.length) return found;
    }
    var shrunk = detectWith(0, 0.78);
    return shrunk && shrunk.length ? shrunk : [];

    function detectWith(deg, scale) {
      var swapped = deg === 90 || deg === 270;
      var cw = swapped ? H : W, ch = swapped ? W : H;
      var c = makeCanvas(cw, ch);
      var cx = c.getContext('2d');
      cx.fillStyle = '#ffffff';
      cx.fillRect(0, 0, cw, ch);
      cx.save();
      cx.translate(cw / 2, ch / 2);
      cx.rotate(deg * Math.PI / 180);
      cx.scale(scale, scale);
      cx.drawImage(src, -W / 2, -H / 2);
      cx.restore();

      var r;
      try { r = hand.detect(c); } catch (e) { return null; }
      if (!r || !r.landmarks || !r.landmarks.length) return null;

      var rad = -deg * Math.PI / 180;
      var cos = Math.cos(rad), sin = Math.sin(rad);
      // Bütün tapılan əlləri (numHands: 2) orijinal koordinatlara qaytarırıq —
      // əks halda dönük şəkildə iki əl varsa, ikincisi rəngsiz qalırdı.
      return r.landmarks.map(function (lm) {
        return lm.map(function (p) {
          var x = (p.x * cw - cw / 2) / scale;
          var y = (p.y * ch - ch / 2) / scale;
          return {
            x: (x * cos - y * sin + W / 2) / W,
            y: (x * sin + y * cos + H / 2) / H
          };
        });
      });
    }
  }

  /* ───────────────────────── əsas API ────────────────────────── */

  function process(source, style) {
    style = style || {};
    var mode = style.mode || 'sample';
    if (mode === 'sample') return Promise.resolve({ ok: false, error: 'sample' });

    var src;
    try { src = drawSource(source); } catch (e) { return Promise.resolve({ ok: false, error: 'bad_image' }); }

    if (mode === 'hair' || mode === 'gloss' || (mode === 'makeup' && style.opts && style.opts.glow)) {
      setStatus('segment');
      return segment(src).then(function (masks) {
        var res;
        if (mode === 'gloss') res = glossHair(src, masks, style.opts);
        else if (mode === 'makeup') {
          // glow üçün həm üz nöqtələri, həm maska lazımdır
          return getFace().then(function (face) {
            var r = face.detect(src);
            var lms = (r.faceLandmarks && r.faceLandmarks[0]) || null;
            if (!lms) return { ok: false, error: 'no_face' };
            return paintFace(src, masks, lms, style);
          }).then(function (r) { masks.close(); return r; });
        } else {
          res = paintHair(src, masks, style.color || {}, style.opts || {});
        }
        masks.close();
        return res;
      });
    }

    if (mode === 'makeup') {
      setStatus('face');
      return getFace().then(function (face) {
        var r = face.detect(src);
        var lms = (r.faceLandmarks && r.faceLandmarks[0]) || null;
        if (!lms) return { ok: false, error: 'no_face' };
        return paintFace(src, null, lms, style);
      });
    }

    if (mode === 'brow') {
      setStatus('face');
      return getFace().then(function (face) {
        var r = face.detect(src);
        var lms = (r.faceLandmarks && r.faceLandmarks[0]) || null;
        if (!lms) return { ok: false, error: 'no_face' };
        return paintBrows(src, lms, style);
      });
    }

    if (mode === 'nails') {
      setStatus('hand');
      return getHand().then(function (hand) {
        var hands = detectHandRobust(hand, src);
        var handsFound = !!(hands && hands.length);

        // 1) Köhnə oje piksellərini birbaşa seçilən rəngə çevir. Bu, landmark
        //    olsun-olmasın (bir və ya iki əl) dırnağı tam örtür — boşluq və köhnə
        //    ton qalmır. Nümunə modelə heç vaxt keçilmir.
        return recolorOldNails(src, style, hands, handsFound).then(function (recolor) {
          var base = recolor && recolor.canvas ? recolor.canvas : src;

          // 2) Yalnız stil detalları (fransız / xrom / nail-art) landmark üzərində çəkilir.
          //    Solid stillərdə paintNails() ümumiyyətlə çağırılmır: MediaPipe landmarkları
          //    səhv düşdükdə lövhələr dırnağın əvəzinə dəri üzərində ləkə kimi görünürdü.
          //    Detallar da yalnız köhnə oje maskasının içində saxlanılır.
          var design = (style.opts && style.opts.design) || 'solid';
          var hasDetail = design === 'french' || design === 'chrome' || design === 'art';
          if (hasDetail && handsFound && recolor && recolor.mask) {
            var painted = paintNails(base, hands, style);
            if (painted && painted.ok) {
              var W = base.width, H = base.height;
              var detail = makeCanvas(W, H);
              var dctx = detail.getContext('2d');
              dctx.drawImage(painted.canvas, 0, 0);
              dctx.globalCompositeOperation = 'destination-in';
              dctx.drawImage(recolor.mask, 0, 0);
              dctx.globalCompositeOperation = 'source-over';
              var final = makeCanvas(W, H);
              var fctx = final.getContext('2d');
              fctx.drawImage(base, 0, 0);
              fctx.drawImage(detail, 0, 0);
              return { ok: true, canvas: final };
            }
          }

          // 3) Landmark yoxdursa və ya detal tələb olunmursa, köhnə lövhələri qaytar.
          if (recolor && recolor.canvas) return { ok: true, canvas: recolor.canvas };

          return { ok: false, error: 'no_hand' };
        });
      });
    }

    return Promise.resolve({ ok: false, error: 'unknown_mode' });
  }

  window.BeautyStudio = {
    configure: function (cfg) {
      cfg = cfg || {};
      if (cfg.base) {
        // Nisbi yol olsa da `import()` üçün mütləq URL-ə çevir
        try { BASE = new URL(cfg.base, document.baseURI).href; } catch (e) { BASE = cfg.base; }
        if (BASE.charAt(BASE.length - 1) !== '/') BASE += '/';
      }
      if (cfg.onStatus) onStatus = cfg.onStatus;
    },
    process: process,
    /** Modeli əvvəlcədən yükləyir (ilk klik gecikməsin). */
    warm: function (mode) {
      if (mode === 'nails') return getHand().then(function () { return true; });
      if (mode === 'makeup' || mode === 'brow') return getFace().then(function () { return true; });
      return getSegmenter().then(function () { return true; });
    }
  };
})();
