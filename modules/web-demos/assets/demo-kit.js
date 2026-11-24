/* ============================================================
   SKYWEB DEMO KIT — shared functional layer (v1)
   window.DK :: order flow, persistent cart, toasts, reveal …
   Additive only. Safe on any demo page.
   ============================================================ */
(function () {
  'use strict';

  var body = document.body;

  var CFG = {
    demo: body.getAttribute('data-dk-demo') || 'demo',
    accent: body.getAttribute('data-dk-accent') || '',
    phone: (body.getAttribute('data-dk-phone') || '994503936998').replace(/\D/g, ''),
    currency: body.getAttribute('data-dk-currency') || 'AZN',
    lang: (document.documentElement.lang || 'az').toLowerCase().slice(0, 2)
  };
  if (['az', 'en', 'ru', 'tr'].indexOf(CFG.lang) === -1) CFG.lang = 'az';
  if (CFG.accent) document.documentElement.style.setProperty('--dk-accent', CFG.accent);

  /* ── UI strings (4 languages) ─────────────────────────── */
  var T = {
    az: {
      order: 'Sifariş', orderEyebrow: 'SÜRƏTLİ SİFARİŞ', orderSub: 'Məlumatları doldurun — sifarişiniz WhatsApp ilə birbaşa göndəriləcək.',
      name: 'Ad, soyad', namePh: 'Məsələn: Aysel Məmmədova',
      phone: 'Telefon', phonePh: '0XX XXX XX XX',
      address: 'Ünvan / şəhər', addressPh: 'Bakı, Nizami küç. 25',
      note: 'Qeyd (istəyə bağlı)', notePh: 'Rəng, ölçü, xüsusi istək...',
      time: 'Vaxt', date: 'Tarix', qty: 'Say',
      submit: 'WhatsApp ilə göndər', cancel: 'Ləğv et', close: 'Bağla',
      req: 'Bu sahə mütləqdir', badPhone: 'Telefon nömrəsi düzgün deyil',
      emptyCart: 'Səbətiniz boşdur', added: 'Səbətə əlavə edildi', removed: 'Səbətdən çıxarıldı',
      total: 'Cəmi', copied: 'Kopyalandı', copyFail: 'Kopyalamaq alınmadı',
      sent: 'Sifariş hazırdır — WhatsApp açılır', saving: 'Yadda saxlanıldı',
      freeShip: 'Pulsuz çatdırılmaya', freeShipDone: 'Çatdırılma pulsuzdur 🎉',
      wa: 'WhatsApp ilə yaz', top: 'Yuxarı', call: 'Zəng et',
      demoNote: 'Skyweb demo', select: 'Seçin'
    },
    en: {
      order: 'Order', orderEyebrow: 'QUICK ORDER', orderSub: 'Fill in the details — your order is sent straight to WhatsApp.',
      name: 'Full name', namePh: 'e.g. Aysel Mammadova',
      phone: 'Phone', phonePh: '0XX XXX XX XX',
      address: 'Address / city', addressPh: 'Baku, 25 Nizami street',
      note: 'Note (optional)', notePh: 'Colour, size, special request...',
      time: 'Time', date: 'Date', qty: 'Quantity',
      submit: 'Send via WhatsApp', cancel: 'Cancel', close: 'Close',
      req: 'This field is required', badPhone: 'Phone number is invalid',
      emptyCart: 'Your cart is empty', added: 'Added to cart', removed: 'Removed from cart',
      total: 'Total', copied: 'Copied', copyFail: 'Could not copy',
      sent: 'Order ready — opening WhatsApp', saving: 'Saved',
      freeShip: 'to free delivery', freeShipDone: 'Delivery is free 🎉',
      wa: 'Chat on WhatsApp', top: 'Top', call: 'Call',
      demoNote: 'Skyweb demo', select: 'Select'
    },
    ru: {
      order: 'Заказ', orderEyebrow: 'БЫСТРЫЙ ЗАКАЗ', orderSub: 'Заполните данные — заказ сразу уйдёт в WhatsApp.',
      name: 'Имя и фамилия', namePh: 'Например: Айсель Мамедова',
      phone: 'Телефон', phonePh: '0XX XXX XX XX',
      address: 'Адрес / город', addressPh: 'Баку, ул. Низами 25',
      note: 'Комментарий (необязательно)', notePh: 'Цвет, размер, пожелание...',
      time: 'Время', date: 'Дата', qty: 'Кол-во',
      submit: 'Отправить в WhatsApp', cancel: 'Отмена', close: 'Закрыть',
      req: 'Обязательное поле', badPhone: 'Неверный номер телефона',
      emptyCart: 'Корзина пуста', added: 'Добавлено в корзину', removed: 'Удалено из корзины',
      total: 'Итого', copied: 'Скопировано', copyFail: 'Не удалось скопировать',
      sent: 'Заказ готов — открываем WhatsApp', saving: 'Сохранено',
      freeShip: 'до бесплатной доставки', freeShipDone: 'Доставка бесплатная 🎉',
      wa: 'Написать в WhatsApp', top: 'Вверх', call: 'Позвонить',
      demoNote: 'Демо Skyweb', select: 'Выберите'
    },
    tr: {
      order: 'Sipariş', orderEyebrow: 'HIZLI SİPARİŞ', orderSub: 'Bilgileri doldurun — sipariş doğrudan WhatsApp\'a gider.',
      name: 'Ad soyad', namePh: 'Örn: Aysel Memmedova',
      phone: 'Telefon', phonePh: '0XX XXX XX XX',
      address: 'Adres / şehir', addressPh: 'Bakü, Nizami cad. 25',
      note: 'Not (isteğe bağlı)', notePh: 'Renk, beden, özel istek...',
      time: 'Saat', date: 'Tarih', qty: 'Adet',
      submit: 'WhatsApp ile gönder', cancel: 'İptal', close: 'Kapat',
      req: 'Bu alan zorunludur', badPhone: 'Telefon numarası geçersiz',
      emptyCart: 'Sepetiniz boş', added: 'Sepete eklendi', removed: 'Sepetten çıkarıldı',
      total: 'Toplam', copied: 'Kopyalandı', copyFail: 'Kopyalanamadı',
      sent: 'Sipariş hazır — WhatsApp açılıyor', saving: 'Kaydedildi',
      freeShip: 'ücretsiz teslimata', freeShipDone: 'Teslimat ücretsiz 🎉',
      wa: 'WhatsApp\'tan yaz', top: 'Yukarı', call: 'Ara',
      demoNote: 'Skyweb demo', select: 'Seçin'
    }
  };
  var t = T[CFG.lang] || T.az;

  /* ── Helpers ──────────────────────────────────────────── */
  function money(n) {
    n = Number(n) || 0;
    var s = (Math.round(n * 100) / 100).toString().replace('.', ',');
    return s + ' ' + CFG.currency;
  }
  function el(tag, cls, html) {
    var n = document.createElement(tag);
    if (cls) n.className = cls;
    if (html != null) n.innerHTML = html;
    return n;
  }
  function esc(s) {
    return String(s == null ? '' : s)
      .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
  }
  function store(key, val) {
    try {
      if (val === undefined) {
        var raw = localStorage.getItem('dk.' + CFG.demo + '.' + key);
        return raw ? JSON.parse(raw) : null;
      }
      localStorage.setItem('dk.' + CFG.demo + '.' + key, JSON.stringify(val));
      return val;
    } catch (e) { return null; }
  }
  function wa(text) {
    var url = 'https://wa.me/' + CFG.phone + '?text=' + encodeURIComponent(text);
    var w = window.open(url, '_blank', 'noopener');
    if (!w) window.location.href = url;
  }
  function digits(v) { return String(v || '').replace(/\D/g, ''); }
  function normPhone(v) {
    var d = digits(v);
    if (d.length === 13 && d.indexOf('994') === 0) d = d.slice(3);
    if (d.length === 10 && d.charAt(0) === '0') d = d.slice(1);
    return d;
  }
  function validPhone(v) {
    var d = normPhone(v);
    return d.length === 9 && /^[5-9]/.test(d);
  }
  function fmtPhone(v) {
    var d = normPhone(v).slice(0, 9);
    if (!d) return '';
    var out = d.slice(0, 3);
    if (d.length > 3) out += ' ' + d.slice(3, 6);
    if (d.length > 6) out += ' ' + d.slice(6, 8);
    if (d.length > 8) out += ' ' + d.slice(8, 9);
    return out;
  }

  /* ── Toasts ───────────────────────────────────────────── */
  var toastWrap = null;
  function toast(msg, type) {
    if (!toastWrap) {
      toastWrap = el('div', 'dk-toasts');
      toastWrap.setAttribute('role', 'status');
      toastWrap.setAttribute('aria-live', 'polite');
      body.appendChild(toastWrap);
    }
    var ic = type === 'err' ? '⚠️' : type === 'info' ? 'ℹ️' : '✅';
    var node = el('div', 'dk-toast dk-toast--' + (type || 'ok'),
      '<span class="dk-toast__ic">' + ic + '</span><span>' + esc(msg) + '</span>');
    toastWrap.appendChild(node);
    requestAnimationFrame(function () { node.classList.add('dk-show'); });
    setTimeout(function () {
      node.classList.remove('dk-show');
      setTimeout(function () { node.remove(); }, 300);
    }, 2600);
  }

  /* ── Bottom sheet ─────────────────────────────────────── */
  var activeSheet = null;

  function sheet(opts) {
    return new Promise(function (resolve) {
      closeSheet();

      var overlay = el('div', 'dk-sheet-overlay');
      var panel = el('div', 'dk-sheet');
      panel.setAttribute('role', 'dialog');
      panel.setAttribute('aria-modal', 'true');
      panel.setAttribute('aria-label', opts.title || t.order);

      var head = el('div', 'dk-sheet__head');
      head.innerHTML =
        '<span class="dk-sheet__eyebrow">' + esc(opts.eyebrow || t.orderEyebrow) + '</span>' +
        '<h3 class="dk-sheet__title">' + esc(opts.title || t.order) + '</h3>' +
        (opts.sub ? '<p class="dk-sheet__sub">' + esc(opts.sub) + '</p>' : '');
      var x = el('button', 'dk-sheet__x', '✕');
      x.type = 'button';
      x.setAttribute('aria-label', t.close);
      x.addEventListener('click', function () { cancel(); });
      head.appendChild(x);

      var bodyEl = el('div', 'dk-sheet__body');
      var form = el('form');
      form.noValidate = true;
      var inputs = {};

      (opts.fields || []).forEach(function (f) {
        var wrap = el('div', 'dk-field');
        wrap.dataset.name = f.name;
        var req = f.required ? ' <b>*</b>' : '';
        var id = 'dkf-' + f.name + '-' + Math.random().toString(36).slice(2, 7);

        var ctrl;
        if (f.type === 'textarea') {
          ctrl = el('textarea', 'dk-textarea');
          ctrl.rows = f.rows || 3;
          if (f.value != null) ctrl.value = f.value;
        } else if (f.type === 'select') {
          ctrl = el('select', 'dk-select');
          var opt0 = el('option', null, f.placeholder || t.select);
          opt0.value = '';
          opt0.disabled = true;
          if (!f.value) opt0.selected = true;
          ctrl.appendChild(opt0);
          (f.options || []).forEach(function (o) {
            var val = typeof o === 'string' ? o : o.value;
            var lab = typeof o === 'string' ? o : o.label;
            var op = el('option', null, esc(lab));
            op.value = val;
            if (String(f.value) === String(val)) op.selected = true;
            ctrl.appendChild(op);
          });
        } else {
          ctrl = el('input', 'dk-input');
          ctrl.type = f.type || 'text';
          if (f.placeholder) ctrl.placeholder = f.placeholder;
          if (f.value != null) ctrl.value = f.value;
          if (f.min != null) ctrl.min = f.min;
          if (f.max != null) ctrl.max = f.max;
          if (f.step != null) ctrl.step = f.step;
          if (f.type === 'tel') {
            ctrl.inputMode = 'tel';
            ctrl.autocomplete = 'tel';
          }
          if (f.type === 'number') ctrl.inputMode = 'numeric';
        }
        ctrl.id = id;
        ctrl.name = f.name;
        if (f.required) ctrl.required = true;

        var label = el('label', 'dk-label', esc(f.label) + req);
        label.setAttribute('for', id);

        wrap.appendChild(label);
        wrap.appendChild(ctrl);
        if (f.hint) wrap.appendChild(el('span', 'dk-hint', esc(f.hint)));
        var err = el('span', 'dk-err', esc(f.errMsg || t.req));
        wrap.appendChild(err);

        if (f.type === 'tel') {
          ctrl.addEventListener('input', function () {
            var pos = ctrl.selectionStart;
            var before = ctrl.value.length;
            ctrl.value = fmtPhone(ctrl.value);
            var after = ctrl.value.length;
            try { ctrl.setSelectionRange(pos + (after - before), pos + (after - before)); } catch (e) {}
          });
        }

        form.appendChild(wrap);
        inputs[f.name] = { ctrl: ctrl, wrap: wrap, def: f };
      });

      function validate() {
        var firstBad = null;
        var ok = true;
        Object.keys(inputs).forEach(function (k) {
          var is = inputs[k];
          var f = is.def;
          var v = (is.ctrl.value || '').trim();
          var bad = false;
          is.wrap.classList.remove('dk-invalid');

          if (f.required && (!v || (f.type === 'select' && !v))) bad = true;
          else if (v && f.type === 'tel' && !validPhone(v)) {
            bad = true;
            is.wrap.querySelector('.dk-err').textContent = t.badPhone;
          }
          if (bad) {
            is.wrap.classList.add('dk-invalid');
            ok = false;
            if (!firstBad) firstBad = is.ctrl;
          }
        });
        if (firstBad) {
          firstBad.focus({ preventScroll: true });
          panel.classList.add('dk-shake');
          setTimeout(function () { panel.classList.remove('dk-shake'); }, 420);
        }
        return ok;
      }

      var foot = el('div', 'dk-sheet__foot');
      var cancelBtn = el('button', 'dk-btn dk-btn--ghost', esc(t.cancel));
      cancelBtn.type = 'button';
      cancelBtn.addEventListener('click', function () { cancel(); });
      var submitBtn = el('button', 'dk-btn dk-btn--primary',
        (opts.submitIcon ? opts.submitIcon + ' ' : '') + esc(opts.submitText || t.submit));
      submitBtn.type = 'submit';
      foot.appendChild(cancelBtn);
      foot.appendChild(submitBtn);

      form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!validate()) return;
        var data = {};
        Object.keys(inputs).forEach(function (k) { data[k] = (inputs[k].ctrl.value || '').trim(); });
        closeSheet();
        resolve(data);
      });

      bodyEl.appendChild(form);
      panel.appendChild(head);
      panel.appendChild(bodyEl);
      panel.appendChild(foot);
      overlay.appendChild(panel);
      body.appendChild(overlay);
      body.style.overflow = 'hidden';
      requestAnimationFrame(function () { overlay.classList.add('dk-open'); });
      activeSheet = overlay;

      setTimeout(function () {
        var first = form.querySelector('.dk-input, .dk-textarea, .dk-select');
        if (first && window.innerWidth > 820) first.focus({ preventScroll: true });
      }, 320);

      function cancel() {
        closeSheet();
        resolve(null);
      }
    });
  }

  function closeSheet() {
    if (!activeSheet) return;
    var node = activeSheet;
    node.classList.remove('dk-open');
    activeSheet = null;
    body.style.overflow = '';
    setTimeout(function () { node.remove(); }, 340);
  }

  /* ── Order flow ───────────────────────────────────────── */
  function order(opts) {
    opts = opts || {};
    var items = opts.items || null;
    var lines = [];
    var total = 0;
    if (items && items.length) {
      items.forEach(function (i) {
        var q = i.qty || 1;
        total += (Number(i.price) || 0) * q;
      });
    }
    if (opts.lines) lines = opts.lines.slice();

    var fields = [
      { name: 'name', label: t.name, placeholder: t.namePh, required: true, errMsg: t.req },
      { name: 'phone', label: t.phone, type: 'tel', placeholder: t.phonePh, required: true, errMsg: t.req }
    ];
    if (opts.address !== false) {
      fields.push({ name: 'address', label: t.address, placeholder: t.addressPh, required: !!opts.addressRequired });
    }
    if (opts.withDate) {
      fields.push({ name: 'date', label: t.date, type: 'date', min: new Date().toISOString().slice(0, 10), required: true });
    }
    if (opts.withTime) {
      fields.push({ name: 'time', label: t.time, type: 'select', required: true, options: opts.slots || [] });
    }
    fields.push({ name: 'note', label: t.note, type: 'textarea', rows: 2, placeholder: t.notePh });

    var title = opts.title || (items && items.length ? t.order : t.order);
    var sub = opts.sub || t.orderSub;

    return sheet({ title: title, eyebrow: opts.eyebrow, sub: sub, fields: fields, submitText: t.submit, submitIcon: '💬' })
      .then(function (data) {
        if (!data) return null;

        var msg = [];
        msg.push('Salam, "' + (opts.brand || document.title.split('—')[0].trim()) + '" saytından sifariş:');
        msg.push('');
        if (opts.summary) msg.push(opts.summary);
        if (items && items.length) {
          items.forEach(function (i, idx) {
            var q = i.qty || 1;
            var line = (idx + 1) + '. ' + i.title + ' × ' + q;
            if (i.meta) line += ' (' + i.meta + ')';
            line += ' = ' + money((Number(i.price) || 0) * q);
            msg.push(line);
          });
          msg.push('');
          if (opts.discountAmount) {
            msg.push('Cəmi: ' + money(total));
            msg.push((opts.discountLabel || 'Endirim') + ': −' + money(opts.discountAmount));
            msg.push('Yekun: ' + money(Math.max(0, total - opts.discountAmount)));
          } else {
            msg.push('Cəmi: ' + money(total));
          }
        }
        if (lines.length) { msg.push(''); msg = msg.concat(lines); }
        msg.push('');
        msg.push('Ad: ' + data.name);
        msg.push('Telefon: +994 ' + fmtPhone(data.phone));
        if (data.address) msg.push('Ünvan: ' + data.address);
        if (data.date) msg.push('Tarix: ' + data.date);
        if (data.time) msg.push('Vaxt: ' + data.time);
        if (data.note) msg.push('Qeyd: ' + data.note);

        var hist = store('orders') || [];
        hist.push({ at: Date.now(), items: items, total: total, data: data });
        store('orders', hist.slice(-20));

        toast(t.sent);
        setTimeout(function () { wa(msg.join('\n')); }, 350);
        return data;
      });
  }

  /* ── Persistent cart ──────────────────────────────────── */
  function Cart(key, onChange) {
    this.key = key || 'cart';
    this.items = store(this.key) || [];
    this.onChange = onChange || function () {};
    var self = this;
    function bump() {
      store(self.key, self.items);
      self.onChange(self.items.slice());
      syncBadges(self.items);
    }
    this.bump = bump;
    syncBadges(this.items);
  }
  Cart.prototype.add = function (item, qty) {
    qty = qty || 1;
    var found = null;
    for (var i = 0; i < this.items.length; i++) {
      if (String(this.items[i].id) === String(item.id) && (this.items[i].meta || '') === (item.meta || '')) {
        found = this.items[i];
        break;
      }
    }
    if (found) found.qty += qty;
    else this.items.push({ id: item.id, title: item.title, price: Number(item.price) || 0, img: item.img || '', meta: item.meta || '', qty: qty });
    this.bump();
    return this;
  };
  Cart.prototype.setQty = function (id, meta, qty) {
    for (var i = 0; i < this.items.length; i++) {
      if (String(this.items[i].id) === String(id) && (this.items[i].meta || '') === (meta || '')) {
        if (qty <= 0) this.items.splice(i, 1);
        else this.items[i].qty = qty;
        break;
      }
    }
    this.bump();
    return this;
  };
  Cart.prototype.remove = function (id, meta) {
    for (var i = 0; i < this.items.length; i++) {
      if (String(this.items[i].id) === String(id) && (this.items[i].meta || '') === (meta || '')) {
        this.items.splice(i, 1);
        break;
      }
    }
    this.bump();
    return this;
  };
  Cart.prototype.clear = function () { this.items = []; this.bump(); return this; };
  Cart.prototype.count = function () {
    return this.items.reduce(function (s, i) { return s + i.qty; }, 0);
  };
  Cart.prototype.total = function () {
    return this.items.reduce(function (s, i) { return s + i.price * i.qty; }, 0);
  };

  function syncBadges(items) {
    var n = (items || []).reduce(function (s, i) { return s + i.qty; }, 0);
    document.querySelectorAll('[data-dk-count]').forEach(function (b) {
      b.textContent = n;
      b.classList.toggle('dk-on', n > 0);
    });
    document.dispatchEvent(new CustomEvent('dk:cart', { detail: { count: n } }));
  }

  /* ── Reveal on scroll ─────────────────────────────────── */
  function reveal() {
    var nodes = document.querySelectorAll('[data-dk-reveal], .dk-reveal');
    if (!('IntersectionObserver' in window)) {
      nodes.forEach(function (n) { n.classList.add('dk-in'); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        var n = e.target;
        var delay = parseInt(n.getAttribute('data-dk-delay') || '0', 10);
        setTimeout(function () { n.classList.add('dk-in'); }, delay);
        io.unobserve(n);
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.06 });
    nodes.forEach(function (n) {
      if (!n.classList.contains('dk-reveal')) n.classList.add('dk-reveal');
      io.observe(n);
    });
  }

  /* ── Misc behaviours ──────────────────────────────────── */
  function scrollProgress() {
    var bar = el('div', 'dk-progress-bar');
    body.appendChild(bar);
    function upd() {
      var h = document.documentElement.scrollHeight - window.innerHeight;
      bar.style.width = (h > 0 ? (window.scrollY / h) * 100 : 0) + '%';
    }
    window.addEventListener('scroll', upd, { passive: true });
    window.addEventListener('resize', upd);
    upd();
  }

  function imageFade() {
    document.querySelectorAll('img').forEach(function (img) {
      if (!img.classList.contains('dk-img')) {
        if (img.complete && img.naturalWidth) return;
        img.classList.add('dk-img');
        img.addEventListener('load', function () { img.classList.add('dk-loaded'); });
        img.addEventListener('error', function () { img.classList.add('dk-loaded'); });
      }
    });
  }

  function ripple() {
    document.addEventListener('pointerdown', function (e) {
      var btn = e.target.closest('.dk-btn');
      if (!btn) return;
      var r = btn.getBoundingClientRect();
      var size = Math.max(r.width, r.height);
      var span = el('span', 'dk-ripple');
      span.style.width = span.style.height = size + 'px';
      span.style.left = (e.clientX - r.left - size / 2) + 'px';
      span.style.top = (e.clientY - r.top - size / 2) + 'px';
      btn.appendChild(span);
      setTimeout(function () { span.remove(); }, 600);
    }, { passive: true });
  }

  function bindOrderTriggers() {
    document.addEventListener('click', function (e) {
      var trg = e.target.closest('[data-dk-order]');
      if (!trg) return;
      e.preventDefault();
      var items = null;
      var raw = trg.getAttribute('data-dk-items');
      if (raw) {
        try { items = JSON.parse(raw); } catch (err) { items = null; }
      }
      if (!items) {
        var title = trg.getAttribute('data-dk-title');
        if (title) {
          items = [{ title: title, price: Number(trg.getAttribute('data-dk-price')) || 0, qty: 1 }];
        }
      }
      order({
        title: trg.getAttribute('data-dk-sheet-title') || t.order,
        items: items,
        withTime: trg.hasAttribute('data-dk-time'),
        withDate: trg.hasAttribute('data-dk-date')
      });
    });
  }

  function stickyBar(opts) {
    opts = opts || {};
    if (!document.querySelector('.dk-stickybar') && body && body.hasAttribute('data-dk-sticky')) {
      var bar = el('div', 'dk-stickybar');
      var waBtn = el('a', 'dk-btn dk-btn--wa', '💬 ' + esc(t.wa));
      waBtn.href = 'https://wa.me/' + CFG.phone;
      waBtn.target = '_blank';
      waBtn.rel = 'noopener';
      var primary = el('button', 'dk-btn dk-btn--primary', esc(body.getAttribute('data-dk-sticky-label') || t.order));
      primary.type = 'button';
      primary.addEventListener('click', function () {
        var fn = body.getAttribute('data-dk-action');
        if (fn && typeof window[fn] === 'function') { window[fn](); return; }
        var sel = body.getAttribute('data-dk-primary');
        var node = null;
        if (sel) { try { node = document.querySelector(sel); } catch (e) { node = null; } }
        if (node && node !== primary) { node.click(); return; }
        order({});
      });
      bar.appendChild(waBtn);
      bar.appendChild(primary);
      body.appendChild(bar);
    }
    if (!document.querySelector('.dk-stickybar')) return;
    body.classList.add('dk-has-sticky');
  }

  function countdowns() {
    document.querySelectorAll('[data-dk-countdown]').forEach(function (node) {
      var target = parseInt(node.getAttribute('data-dk-countdown'), 10);
      var end = isNaN(target) ? Date.parse(node.getAttribute('data-dk-countdown')) : Date.now() + target * 1000;
      if (!end) return;
      function tick() {
        var left = Math.max(0, Math.floor((end - Date.now()) / 1000));
        var h = String(Math.floor(left / 3600)).padStart(2, '0');
        var m = String(Math.floor((left % 3600) / 60)).padStart(2, '0');
        var s = String(left % 60).padStart(2, '0');
        node.textContent = h + ':' + m + ':' + s;
        if (left === 0) clearInterval(id);
      }
      var id = setInterval(tick, 1000);
      tick();
    });
  }

  function init() {
    scrollProgress();
    reveal();
    imageFade();
    ripple();
    bindOrderTriggers();
    stickyBar();
    countdowns();
    syncBadges((store('cart') || []));

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeSheet();
    });

    window.addEventListener('scroll', function () {
      var top = document.querySelector('.dk-fab--top');
      if (top) top.classList.toggle('dk-on', window.scrollY > 600);
      var sb = document.querySelector('.dk-stickybar');
      if (sb) sb.classList.toggle('dk-on', window.scrollY > 240);
    }, { passive: true });
  }

  /* ── Public API ───────────────────────────────────────── */
  window.DK = {
    cfg: CFG,
    t: t,
    pick: function (az, en, ru, tr) {
      var m = { az: az, en: en, ru: ru, tr: tr };
      return m[CFG.lang] || az;
    },
    money: money,
    toast: toast,
    sheet: sheet,
    order: order,
    cart: function (key, onChange) { return new Cart(key, onChange); },
    syncBadges: syncBadges,
    reveal: reveal,
    imageFade: imageFade,
    wa: wa,
    store: store,
    esc: esc,
    validPhone: validPhone,
    fmtPhone: fmtPhone,
    closeSheet: closeSheet,
    countdowns: countdowns,
    icon: function (name) {
      var map = {
        wa: '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12.04 2C6.6 2 2.2 6.4 2.2 11.84c0 1.94.56 3.75 1.53 5.28L2 22l5.02-1.7a9.8 9.8 0 0 0 5.02 1.38c5.44 0 9.84-4.4 9.84-9.84S17.48 2 12.04 2Zm5.72 13.9c-.24.67-1.4 1.3-1.93 1.35-.53.05-1.02.24-3.4-.7-2.9-1.14-4.7-4.1-4.85-4.3-.14-.2-1.14-1.5-1.14-2.87 0-1.36.72-2.03 1-2.3.24-.25.53-.31.72-.31h.5c.16 0 .38-.06.6.45.24.56.8 1.95.87 2.1.07.14.11.3.02.48-.1.2-.15.32-.29.5-.15.17-.3.38-.44.5-.14.15-.3.3-.13.6.17.29.75 1.24 1.62 2 1.11 1 2.04 1.31 2.33 1.45.29.15.46.12.63-.07.17-.2.73-.85.93-1.14.2-.29.4-.24.66-.15.27.1 1.69.8 1.98.94.29.15.48.22.55.34.07.13.07.75-.17 1.42Z"/></svg>',
        cart: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1.5"/><circle cx="19" cy="21" r="1.5"/><path d="M2 3h3l2.6 12.4a2 2 0 0 0 2 1.6h8.7a2 2 0 0 0 2-1.6L22 7H6"/></svg>',
        up: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>'
      };
      return map[name] || '';
    }
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
