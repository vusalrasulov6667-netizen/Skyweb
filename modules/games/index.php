<?php
/**
 * SKYWEB.AZ — Oyun Sifariş Paneli
 * Biznes üçün Mini Oyun Sifarişi
 */
require_once __DIR__ . '/../../config/config.php';
ob_start(static function (string $html): string { return sky_translate_document_html($html); });
?>
<!DOCTYPE html>
<html lang="<?= current_lang() ?>" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="description" content="<?= e(__('games_panel_desc', 'Skyweb.az — Biznesiniz üçün Viktorina, Tapmaca, İdman kimi interaktiv mini oyunlar sifariş edin.')) ?>">
  <title><?= e(__('games_panel_title', 'Oyun Sifariş Paneli')) ?> — <?= SITE_NAME ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/sky.css?v=<?= time() ?>">
  <?= render_i18n_script() ?>
  <script src="<?= SITE_URL ?>/assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <style>
    .games-page { padding-top: 90px; min-height: 100vh; }
    .games-back-link { color:var(--text-muted);text-decoration:none;font-size:0.85rem;display:flex;align-items:center;gap:0.4rem;white-space:nowrap;flex-shrink:0; }
    .games-back-link:hover { color: var(--neon-green); }
    @media (max-width: 520px) { .games-back-link { font-size:0.78rem; } }

    /* Breadcrumb */
    .breadcrumb { display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:var(--text-muted);margin-bottom:2rem; }
    .breadcrumb a { color:var(--neon-cyan);text-decoration:none; }
    .breadcrumb a:hover { text-decoration:underline; }

    /* Hero */
    .games-hero {
      background: linear-gradient(135deg, rgba(16,185,129,0.08) 0%, rgba(99,102,241,0.06) 100%);
      border: 1px solid rgba(16,185,129,0.2); border-radius: var(--radius-xl);
      padding: 3rem 2.5rem; margin-bottom: 3rem; position: relative; overflow: hidden;
      display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;
    }
    .games-hero > * { min-width: 0; }
    .games-hero::before {
      content:''; position:absolute; top:-40px; right:-40px;
      width:300px; height:300px; border-radius:50%;
      background: radial-gradient(circle, rgba(16,185,129,0.1) 0%, transparent 70%);
    }
    .games-hero-badge {
      display:inline-flex;align-items:center;gap:0.5rem;
      background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.3);
      color:#6ee7b7;border-radius:999px;padding:0.3rem 1rem;
      font-size:0.78rem;font-weight:600;margin-bottom:0.75rem;
    }
    .games-hero-title { font-size:clamp(1.6rem,4vw,2.6rem);font-weight:800;line-height:1.2;margin-bottom:0.75rem; overflow-wrap:anywhere; }
    .games-hero-desc { color:var(--text-muted);font-size:0.95rem;line-height:1.7;max-width:500px; }
    .games-hero-right { display:flex;flex-direction:column;gap:1rem;flex-shrink:0; }
    @media (max-width: 900px) {
      .games-hero { padding: 2rem 1.5rem; gap: 1.5rem; }
      .games-hero-right { width: 100%; flex-direction: row; flex-wrap: wrap; }
      .games-hero-right .hero-stat { flex: 1 1 140px; }
    }
    @media (max-width: 600px) {
      .games-hero { padding: 1.5rem 1.1rem; margin-bottom: 2rem; }
      .games-hero-right { flex-direction: column; }
    }
    .hero-stat { text-align:center; }
    .hero-stat-val { font-size:2rem;font-weight:900;color:var(--neon-green); }
    .hero-stat-label { font-size:0.75rem;color:var(--text-muted);font-weight:500; }

    /* Game Cards Grid */
    .games-grid {
      display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
      gap:1.5rem;margin-bottom:3rem;
    }
    .game-card {
      background:var(--sky-card);border:1px solid var(--sky-border);
      border-radius:var(--radius-lg);overflow:hidden;
      transition:var(--transition);position:relative;
    }
    .game-card:hover { border-color:var(--sky-border-glow);transform:translateY(-5px);box-shadow:0 25px 50px -20px rgba(16,185,129,0.15); }
    .game-card-preview {
      height:180px;display:flex;align-items:center;justify-content:center;
      font-size:5rem;position:relative;overflow:hidden;
    }
    .game-card-preview::after {
      content:'';position:absolute;inset:0;
      background:linear-gradient(to bottom, transparent 40%, var(--sky-card) 100%);
    }
    .game-badge {
      position:absolute;top:0.75rem;left:0.75rem;z-index:2;
      padding:0.2rem 0.7rem;border-radius:999px;font-size:0.7rem;font-weight:700;
    }
    .badge-new { background:rgba(16,185,129,0.9);color:#fff; }
    .badge-popular { background:rgba(99,102,241,0.9);color:#fff; }

    .game-card-body { padding:1.25rem 1.5rem 1.5rem;display:flex;flex-direction:column; }
    .game-name { font-size:1.1rem;font-weight:800;margin-bottom:0.4rem; }
    .game-desc { font-size:0.84rem;color:var(--text-muted);line-height:1.6;margin-bottom:1rem; }
    .game-features { display:flex;flex-wrap:wrap;gap:0.4rem;margin:0 0 1.25rem; }
    .game-feat-tag {
      padding:0.2rem 0.6rem;border-radius:6px;font-size:0.72rem;font-weight:600;
      background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:var(--text-muted);
    }
    .game-demo-btn {
      width:100%;margin-top:auto;padding:0.7rem 1.4rem;border-radius:var(--radius-sm);
      background:linear-gradient(135deg,var(--neon-green),#0d9488);
      color:#fff;font-size:0.85rem;font-weight:700;
      border:none;cursor:pointer;transition:var(--transition);
    }
    .game-demo-btn:hover { box-shadow:0 0 20px rgba(16,185,129,0.4);transform:translateY(-2px); }

    /* Playable brand quiz */
    .quiz-overlay {
      position:fixed;inset:0;z-index:10000;padding:1rem;
      background:rgba(3,7,18,0.86);backdrop-filter:blur(8px);
      display:flex;align-items:center;justify-content:center;
      opacity:0;visibility:hidden;transition:opacity 0.25s ease,visibility 0.25s ease;
    }
    .quiz-overlay.open { opacity:1;visibility:visible; }
    .quiz-box {
      width:100%;max-width:560px;max-height:92vh;overflow-y:auto;
      background:#0d1127;border:1px solid var(--sky-border);
      border-radius:var(--radius-xl);padding:2rem;
      box-shadow:0 30px 80px -30px rgba(16,185,129,0.35);
      position:relative;transform:translateY(16px);transition:transform 0.25s ease;
    }
    .quiz-overlay.open .quiz-box { transform:translateY(0); }
    .quiz-close {
      position:absolute;top:0.9rem;right:0.9rem;width:34px;height:34px;
      display:flex;align-items:center;justify-content:center;cursor:pointer;
      background:rgba(255,255,255,0.06);border:1px solid var(--sky-border);
      border-radius:8px;color:var(--text-muted);font-size:1rem;transition:var(--transition);
    }
    .quiz-close:hover { background:rgba(244,63,94,0.15);color:var(--neon-rose); }

    /* Modern quiz identity — shared by the card preview and the game modal */
    .game-quiz-mark {
      position:relative;z-index:2;width:66px;height:66px;border-radius:19px;
      display:flex;align-items:center;justify-content:center;
      background:linear-gradient(135deg,#38bdf8 0%,#818cf8 52%,#10b981 100%);
      box-shadow:0 16px 34px -12px rgba(56,189,248,0.75),inset 0 1px 0 rgba(255,255,255,0.45);
      transform:rotate(-6deg);transition:transform 0.3s ease;
    }
    .game-card:hover .game-quiz-mark { transform:rotate(0deg) scale(1.05); }
    .game-quiz-mark svg { width:38px;height:38px; }
    .quiz-brand { display:flex;align-items:center;gap:0.9rem;padding-right:2.5rem;margin-bottom:1.25rem; }
    .quiz-brand-mark {
      flex:0 0 48px;width:48px;height:48px;border-radius:14px;
      display:flex;align-items:center;justify-content:center;
      background:linear-gradient(135deg,#38bdf8 0%,#818cf8 52%,#10b981 100%);
      box-shadow:0 10px 26px -10px rgba(56,189,248,0.8),inset 0 1px 0 rgba(255,255,255,0.45);
    }
    .quiz-brand-mark svg { width:28px;height:28px; }
    .quiz-brand-copy { display:flex;flex-direction:column;gap:0.15rem;min-width:0; }
    .quiz-brand-name {
      font-family:'Outfit',var(--font-main);font-size:1.05rem;font-weight:800;
      background:linear-gradient(90deg,var(--neon-cyan),var(--neon-green));
      -webkit-background-clip:text;background-clip:text;color:transparent;
    }
    .quiz-brand-sub { font-size:0.72rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--text-muted); }
    .quiz-topic {
      display:inline-flex;align-items:center;gap:0.4rem;
      padding:0.3rem 0.7rem;margin-bottom:0.9rem;
      border:1px solid rgba(56,189,248,0.35);border-radius:999px;
      background:rgba(56,189,248,0.08);color:var(--neon-cyan);
      font-size:0.74rem;font-weight:700;letter-spacing:0.3px;
    }
    .quiz-topic::before { content:'';width:6px;height:6px;border-radius:50%;background:var(--neon-green);box-shadow:0 0 8px var(--neon-green); }
    .quiz-counter { font-size:0.82rem;color:var(--text-muted);margin:0 0 0.9rem; }
    .quiz-progress { height:6px;border-radius:999px;background:rgba(255,255,255,0.08);overflow:hidden;margin-bottom:1.5rem; }
    .quiz-progress-bar { height:100%;width:20%;border-radius:999px;background:linear-gradient(90deg,var(--neon-green),var(--neon-cyan));transition:width 0.3s ease; }
    .quiz-question { font-size:1.15rem;font-weight:700;line-height:1.5;margin-bottom:1.25rem; }
    .quiz-options { display:grid;gap:0.6rem; }
    .quiz-option {
      width:100%;text-align:left;padding:0.85rem 1rem;cursor:pointer;
      background:rgba(255,255,255,0.04);border:1px solid var(--sky-border);
      border-radius:var(--radius-sm);color:var(--text-primary);
      font-size:0.9rem;font-family:var(--font-main);transition:var(--transition);
    }
    .quiz-option:hover:not(:disabled) { border-color:rgba(16,185,129,0.55);background:rgba(16,185,129,0.08);transform:translateX(3px); }
    .quiz-option.is-correct { border-color:var(--neon-green);background:rgba(16,185,129,0.16);color:#6ee7b7; }
    .quiz-option.is-wrong { border-color:var(--neon-rose);background:rgba(244,63,94,0.12);color:#fda4af; }
    .quiz-option.is-muted { opacity:0.45; }
    .quiz-feedback { margin-top:1rem;font-size:0.88rem;font-weight:700;line-height:1.6; }
    .quiz-feedback-answer { display:block;font-weight:500;color:var(--text-muted);margin-top:0.2rem; }
    .quiz-next {
      width:100%;margin-top:1.25rem;padding:0.8rem 1.2rem;cursor:pointer;
      background:linear-gradient(135deg,var(--neon-green),#0d9488);
      border:none;border-radius:var(--radius-sm);color:#fff;
      font-size:0.9rem;font-weight:700;font-family:var(--font-main);transition:var(--transition);
    }
    .quiz-next:hover { box-shadow:0 0 24px rgba(16,185,129,0.4);transform:translateY(-2px); }
    .quiz-result { text-align:center;padding:1rem 0 0.25rem; }
    .quiz-result-icon { font-size:3rem;margin-bottom:0.75rem; }
    .quiz-result-title { font-size:1.35rem;font-weight:800;margin-bottom:0.35rem; }
    .quiz-result-score { color:var(--neon-green);font-weight:800;font-size:1.05rem;margin-bottom:0.5rem; }
    .quiz-result-msg { color:var(--text-muted);font-size:0.9rem; }
    .quiz-next[hidden],.quiz-feedback[hidden],.quiz-result[hidden],.quiz-feedback-answer[hidden],.quiz-state[hidden],.quiz-status[hidden] { display:none !important; }
    .quiz-status { display:flex;align-items:center;justify-content:space-between;gap:.75rem;margin-bottom:.75rem;padding:.55rem .8rem;background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.18);border-radius:12px;font-size:.78rem;color:var(--text-muted); }
    .quiz-status-rank { font-weight:700;color:#34d399; }
    .quiz-status-meta { white-space:nowrap; }
    .quiz-state { text-align:center;padding:1.25rem .5rem .25rem; }
    .quiz-state-icon { font-size:2.2rem;margin-bottom:.5rem; }
    .quiz-state h2 { font-size:1.35rem;margin-bottom:.5rem;color:#34d399; }
    .quiz-state p { color:var(--text-muted);font-size:.92rem;margin-bottom:.75rem;line-height:1.55; }
    .quiz-state-actions { display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;margin-top:.5rem; }
    .quiz-state-actions .quiz-next { min-width:160px;text-decoration:none;display:inline-flex;align-items:center;justify-content:center; }
    .quiz-state-actions .quiz-next.ghost { background:transparent;border:1px solid rgba(16,185,129,0.35);color:#34d399;box-shadow:none; }
    @media(max-width:600px){ .quiz-box { padding:1.5rem 1.25rem; } .quiz-question { font-size:1.02rem; } .quiz-status { flex-direction:column;align-items:flex-start;gap:.25rem; } }

    /* Playable riddles — warm/lightbulb identity, deliberately unlike the quiz */
    .riddle-overlay {
      position:fixed;inset:0;z-index:10001;padding:1rem;
      background:rgba(8,5,20,0.88);backdrop-filter:blur(8px);
      display:flex;align-items:center;justify-content:center;
      opacity:0;visibility:hidden;transition:opacity 0.25s ease,visibility 0.25s ease;
    }
    .riddle-overlay.open { opacity:1;visibility:visible; }
    .riddle-box {
      width:100%;max-width:540px;max-height:92vh;overflow-y:auto;
      background:#111027;border:1px solid rgba(244,114,182,0.28);
      border-radius:var(--radius-xl);padding:1.75rem;position:relative;
      box-shadow:0 30px 80px -30px rgba(244,114,182,0.35);
      transform:translateY(16px);transition:transform 0.25s ease;
    }
    .riddle-overlay.open .riddle-box { transform:translateY(0); }
    .riddle-close {
      position:absolute;top:0.85rem;right:0.85rem;width:34px;height:34px;
      display:flex;align-items:center;justify-content:center;cursor:pointer;
      background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);
      border-radius:9px;color:var(--text-muted);font-size:1rem;transition:var(--transition);
    }
    .riddle-close:hover { background:rgba(251,113,133,0.16);color:#fda4af; }
    .game-riddle-mark {
      position:relative;z-index:2;width:66px;height:66px;border-radius:21px;
      display:flex;align-items:center;justify-content:center;
      background:linear-gradient(135deg,#fbbf24 0%,#f472b6 55%,#a855f7 100%);
      box-shadow:0 16px 34px -12px rgba(244,114,182,0.8),inset 0 1px 0 rgba(255,255,255,0.5);
      transform:rotate(8deg);transition:transform 0.3s ease;
    }
    .game-card:hover .game-riddle-mark { transform:rotate(0deg) scale(1.05); }
    .game-riddle-mark svg { width:38px;height:38px; }
    .riddle-brand { display:flex;align-items:center;gap:0.85rem;padding-right:2.5rem;margin-bottom:1rem; }
    .riddle-brand-mark {
      flex:0 0 46px;width:46px;height:46px;border-radius:14px;
      display:flex;align-items:center;justify-content:center;
      background:linear-gradient(135deg,#fbbf24 0%,#f472b6 55%,#a855f7 100%);
      box-shadow:0 10px 26px -10px rgba(244,114,182,0.85),inset 0 1px 0 rgba(255,255,255,0.5);
    }
    .riddle-brand-mark svg { width:27px;height:27px; }
    .riddle-brand-copy { display:flex;flex-direction:column;gap:0.15rem;min-width:0; }
    .riddle-brand-name {
      font-family:'Outfit',var(--font-main);font-size:1.05rem;font-weight:800;
      background:linear-gradient(90deg,#fbbf24,#f472b6);
      -webkit-background-clip:text;background-clip:text;color:transparent;
    }
    .riddle-brand-sub { font-size:0.72rem;font-weight:700;letter-spacing:0.9px;text-transform:uppercase;color:#f9a8d4; }
    .riddle-stats { display:grid;grid-template-columns:repeat(3,1fr);gap:0.5rem;margin-bottom:0.7rem; }
    .riddle-stat {
      padding:0.6rem 0.35rem;text-align:center;border-radius:12px;
      background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);
    }
    .riddle-stat span { display:block;font-size:0.68rem;color:var(--text-muted);margin-bottom:0.2rem; }
    .riddle-stat strong { font-family:'Outfit',var(--font-main);font-size:1.05rem;color:#fbcfe8; }
    .riddle-rank {
      display:inline-flex;align-items:center;gap:0.35rem;margin-bottom:0.6rem;
      padding:0.25rem 0.65rem;border-radius:999px;font-size:0.72rem;font-weight:700;
      background:rgba(251,191,36,0.1);border:1px solid rgba(251,191,36,0.3);color:#fcd34d;
    }
    .riddle-goal { font-size:0.74rem;color:var(--text-muted);margin-bottom:0.9rem; }
    .riddle-goal-bar { height:4px;border-radius:999px;background:rgba(255,255,255,0.08);overflow:hidden;margin-top:0.35rem; }
    .riddle-goal-bar i { display:block;height:100%;background:linear-gradient(90deg,#fbbf24,#f472b6);transition:width 0.3s ease; }
    .riddle-text { font-size:1.12rem;font-weight:700;line-height:1.6;margin-bottom:1rem; }
    .riddle-options { display:grid;grid-template-columns:1fr 1fr;gap:0.55rem; }
    .riddle-option {
      padding:0.8rem 0.7rem;cursor:pointer;text-align:center;
      background:rgba(255,255,255,0.045);border:1px solid rgba(255,255,255,0.1);
      border-radius:12px;color:var(--text-primary);font-family:var(--font-main);
      font-size:0.87rem;font-weight:600;transition:var(--transition);
    }
    .riddle-option:hover:not(:disabled) { border-color:rgba(251,191,36,0.55);background:rgba(251,191,36,0.09);transform:translateY(-2px); }
    .riddle-option.is-correct { border-color:var(--neon-green);background:rgba(16,185,129,0.16);color:#6ee7b7; }
    .riddle-option.is-wrong { border-color:var(--neon-rose);background:rgba(244,63,94,0.12);color:#fda4af; }
    .riddle-option.is-muted { opacity:0.45; }
    .riddle-actions { display:flex;gap:0.55rem;margin-top:1rem; }
    .riddle-btn {
      flex:1;padding:0.75rem 0.9rem;cursor:pointer;border-radius:11px;
      font-family:var(--font-main);font-size:0.85rem;font-weight:700;transition:var(--transition);
    }
    .riddle-btn.ghost { background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.12);color:var(--text-muted); }
    .riddle-btn.ghost:hover { color:#fbcfe8;border-color:rgba(244,114,182,0.5); }
    .riddle-btn.primary { background:linear-gradient(135deg,#fbbf24,#f472b6);border:none;color:#2b1024; }
    .riddle-btn.primary:hover { box-shadow:0 0 24px rgba(244,114,182,0.4);transform:translateY(-2px); }
    .riddle-hint {
      margin-top:0.9rem;padding:0.7rem 0.85rem;border-radius:11px;
      background:rgba(251,191,36,0.08);border:1px solid rgba(251,191,36,0.28);
      color:#fcd34d;font-size:0.84rem;line-height:1.5;
    }
    .riddle-feedback { margin-top:0.9rem;font-size:0.88rem;font-weight:700;line-height:1.6; }
    .riddle-feedback small { display:block;font-weight:500;color:var(--text-muted);margin-top:0.2rem; }
    .riddle-toast {
      display:inline-block;margin:0 0 0.75rem;max-width:100%;
      padding:0.45rem 0.9rem;border-radius:999px;white-space:normal;text-align:center;
      background:rgba(251,191,36,0.16);border:1px solid rgba(251,191,36,0.4);
      color:#fde68a;font-size:0.76rem;font-weight:700;
    }
    .riddle-records {
      margin-top:0.9rem;font-size:0.75rem;color:var(--text-muted);
      display:flex;gap:0.4rem;flex-wrap:wrap;align-items:center;
    }
    .riddle-records b {
      padding:0.15rem 0.5rem;border-radius:999px;font-weight:700;color:#fbcfe8;
      background:rgba(244,114,182,0.12);border:1px solid rgba(244,114,182,0.28);
    }
    .riddle-overlay [hidden] { display:none !important; }
    .riddle-limits { display:flex;gap:0.45rem;flex-wrap:wrap;align-items:center;margin:-0.2rem 0 0.7rem; }
    .riddle-limit {
      padding:0.22rem 0.6rem;border-radius:999px;font-size:0.7rem;font-weight:700;
      background:rgba(255,255,255,0.045);border:1px solid rgba(255,255,255,0.1);color:var(--text-muted);
    }
    .riddle-limit b { color:#fcd34d; }
    .riddle-tz { margin-left:auto;font-size:0.66rem;color:var(--text-muted);opacity:0.8; }
    .riddle-board {
      margin-top:0.85rem;padding:0.75rem 0.85rem;border-radius:13px;
      background:rgba(255,255,255,0.035);border:1px solid rgba(255,255,255,0.09);
    }
    .riddle-board-head { display:flex;justify-content:space-between;gap:0.5rem;align-items:center;margin-bottom:0.5rem; }
    .riddle-board-head span:first-child { font-size:0.76rem;font-weight:800;color:#fbcfe8; }
    .riddle-board-head span:last-child { font-size:0.7rem;font-weight:700;color:#fcd34d; }
    .riddle-board ol { list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:0.28rem; }
    .riddle-board li {
      display:flex;justify-content:space-between;gap:0.5rem;font-size:0.74rem;
      padding:0.28rem 0.5rem;border-radius:8px;background:rgba(255,255,255,0.03);
    }
    .riddle-board li.me { background:rgba(251,191,36,0.12);border:1px solid rgba(251,191,36,0.3); }
    .riddle-board li i { font-style:normal;color:var(--text-muted);width:1.2rem; }
    .riddle-board li b { color:#fde68a;margin-left:auto; }
    .riddle-board-note { margin-top:0.5rem;font-size:0.68rem;color:var(--text-muted); }
    .riddle-state { text-align:center;padding:1.2rem 0.4rem 0.4rem; }
    .riddle-state-icon { font-size:2.2rem;margin-bottom:0.5rem; }
    .riddle-state h2 { font-family:'Outfit',var(--font-main);font-size:1.2rem;margin:0 0 0.5rem;color:#fbcfe8; }
    .riddle-state p { font-size:0.85rem;line-height:1.6;color:var(--text-muted);margin:0.35rem 0; }
    .riddle-state-small { font-size:0.75rem !important; }
    .riddle-wait { margin:0.9rem 0;font-family:'Outfit',var(--font-main);font-size:1.15rem;font-weight:800;color:#fcd34d; }
    .riddle-state-answer {
      margin:0.6rem auto;padding:0.5rem 0.75rem;border-radius:10px;max-width:100%;
      background:rgba(244,114,182,0.1);border:1px solid rgba(244,114,182,0.28);
      font-size:0.82rem;color:#f9a8d4;
    }
    .riddle-gate-actions { display:flex;gap:0.55rem;margin-top:1rem; }
    .riddle-gate-actions .riddle-btn { display:flex;align-items:center;justify-content:center;text-decoration:none; }
    @media(max-width:600px){
      .riddle-box { padding:1.5rem 1.2rem; }
      .riddle-options { grid-template-columns:1fr; }
      .riddle-text { font-size:1rem; }
      .riddle-brand { gap:0.65rem; }
      .riddle-tz { margin-left:0;width:100%; }
      .riddle-gate-actions { flex-direction:column; }
    }

    /* Brend Yaddaşı — compact memory match */
    .game-memory-mark svg { width:72px;height:72px;filter:drop-shadow(0 8px 24px rgba(56,189,248,.35)); }
    .memory-overlay { position:fixed;inset:0;z-index:10001;padding:.75rem;background:rgba(6,10,24,.88);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;opacity:0;visibility:hidden;transition:opacity .22s ease,visibility .22s ease; }
    .memory-overlay.open { opacity:1;visibility:visible; }
    .memory-box { width:100%;max-width:420px;max-height:94vh;overflow:auto;background:linear-gradient(180deg,#0f1a2e 0%,#0b1424 100%);border:1px solid rgba(56,189,248,.22);border-radius:18px;padding:1rem;position:relative;box-shadow:0 24px 60px -28px rgba(56,189,248,.35); }
    .memory-close { position:absolute;top:.65rem;right:.65rem;width:30px;height:30px;border-radius:8px;border:1px solid rgba(255,255,255,.1);background:rgba(255,255,255,.03);color:var(--text-muted);font-size:1.1rem;line-height:1;cursor:pointer; }
    .memory-close:hover { color:#fff;border-color:rgba(56,189,248,.35); }
    .memory-head { display:flex;align-items:center;justify-content:space-between;gap:.75rem;margin-bottom:.75rem;padding-right:2.2rem; }
    .memory-title { font-weight:800;font-size:1rem;color:#eafcff;letter-spacing:-.01em; }
    .memory-title span { color:#5eead4; }
    .memory-level { font-size:.72rem;color:#7dd3fc;font-weight:600;margin-top:.15rem; }
    .memory-stats { display:grid;grid-template-columns:repeat(4,1fr);gap:.4rem;margin-bottom:.75rem; }
    .memory-stat { background:rgba(255,255,255,.03);border:1px solid rgba(56,189,248,.12);border-radius:10px;padding:.35rem .25rem;text-align:center; }
    .memory-stat span { display:block;font-size:.62rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.04em;line-height:1; }
    .memory-stat strong { display:block;font-size:.88rem;color:#a5f3fc;margin-top:.2rem;font-variant-numeric:tabular-nums; }
    .memory-grid { display:grid;grid-template-columns:repeat(4,1fr);gap:.45rem; }
    .memory-card { aspect-ratio:1/1;border-radius:10px;border:1px solid rgba(56,189,248,.14);background:rgba(56,189,248,.05);cursor:pointer;position:relative;perspective:500px;padding:0; }
    .memory-card-inner { position:absolute;inset:0;border-radius:10px;transition:transform .32s ease;transform-style:preserve-3d; }
    .memory-card.flipped .memory-card-inner, .memory-card.matched .memory-card-inner { transform:rotateY(180deg); }
    .memory-face { position:absolute;inset:0;border-radius:10px;display:flex;align-items:center;justify-content:center;backface-visibility:hidden; }
    .memory-front { background:linear-gradient(160deg,rgba(56,189,248,.12),rgba(16,185,129,.06)); }
    .memory-front::after { content:''; width:18px;height:18px;border-radius:5px;border:2px solid rgba(125,211,252,.35);transform:rotate(45deg); }
    .memory-back { background:linear-gradient(160deg,rgba(15,23,42,.96),rgba(30,41,59,.92));transform:rotateY(180deg);border:1px solid rgba(56,189,248,.22); }
    .memory-back svg { width:54%;height:54%;display:block; }
    .memory-card.matched .memory-back { background:linear-gradient(160deg,rgba(16,185,129,.18),rgba(56,189,248,.1));border-color:rgba(52,211,153,.4); box-shadow:inset 0 0 0 1px rgba(52,211,153,.12); }
    .memory-card:disabled { cursor:default; }
    .memory-card:focus-visible { outline:2px solid rgba(56,189,248,.7);outline-offset:2px; }
    .memory-win { text-align:center;padding:.8rem .25rem .1rem; }
    .memory-win[hidden], .memory-overlay [hidden] { display:none !important; }
    .memory-win-title { font-size:1rem;font-weight:800;color:#5eead4;margin-bottom:.2rem; }
    .memory-win p { color:var(--text-muted);font-size:.8rem;margin-bottom:.65rem; }
    .memory-actions { display:flex;gap:.5rem;justify-content:center; }
    .memory-btn { padding:.55rem 1rem;border-radius:10px;border:none;font-weight:700;font-size:.8rem;cursor:pointer;transition:all .2s; }
    .memory-btn.primary { background:linear-gradient(135deg,#22d3ee,#10b981);color:#042f2e; }
    .memory-btn.primary:hover { filter:brightness(1.06); }
    @media(max-width:420px){ .memory-box{padding:.85rem;} .memory-grid{gap:.35rem;} .memory-stat span{font-size:.58rem;} .memory-stat strong{font-size:.82rem;} }

    /* Brend Ovçusu — retro target hunt */
    .hunt-overlay { position:fixed;inset:0;z-index:10001;padding:.75rem;background:rgba(6,10,24,.88);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;opacity:0;visibility:hidden;transition:opacity .22s ease,visibility .22s ease; }
    .hunt-overlay.open { opacity:1;visibility:visible; }
    .hunt-box { width:100%;max-width:460px;background:linear-gradient(180deg,#0f1a2e 0%,#0b1424 100%);border:1px solid rgba(251,191,36,.22);border-radius:18px;padding:1rem;position:relative;box-shadow:0 24px 60px -28px rgba(251,191,36,.25); }
    .hunt-close { position:absolute;top:.65rem;right:.65rem;width:30px;height:30px;border-radius:8px;border:1px solid rgba(255,255,255,.1);background:rgba(255,255,255,.03);color:var(--text-muted);font-size:1.1rem;line-height:1;cursor:pointer;z-index:5; }
    .hunt-close:hover { color:#fff;border-color:rgba(251,191,36,.35); }
    .hunt-head { display:flex;align-items:center;justify-content:space-between;gap:.5rem;margin-bottom:.65rem;padding-right:2.2rem; }
    .hunt-title { font-weight:800;font-size:1rem;color:#fff7ed;letter-spacing:-.01em; }
    .hunt-title span { color:#fbbf24; }
    .hunt-sub { font-size:.72rem;color:#fcd34d;font-weight:600;margin-top:.12rem; }
    .hunt-stats { display:grid;grid-template-columns:repeat(4,1fr);gap:.4rem;margin-bottom:.65rem; }
    .hunt-stat { background:rgba(255,255,255,.03);border:1px solid rgba(251,191,36,.12);border-radius:10px;padding:.35rem .25rem;text-align:center; }
    .hunt-stat span { display:block;font-size:.62rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.04em;line-height:1; }
    .hunt-stat strong { display:block;font-size:.88rem;color:#fde68a;margin-top:.2rem;font-variant-numeric:tabular-nums; }
    .hunt-arena { position:relative;width:100%;aspect-ratio:16/10;border-radius:12px;overflow:hidden;cursor:none;background:linear-gradient(180deg,#07111f 0%,#0d1b2a 40%,#13283a 68%,#0f2a22 68%,#091c18 100%);border:1px solid rgba(251,191,36,.15);touch-action:manipulation;user-select:none; }
    .hunt-arena::before { content:'';position:absolute;inset:0;background:repeating-linear-gradient(180deg,rgba(255,255,255,.022) 0,rgba(255,255,255,.022) 1px,transparent 1px,transparent 4px);pointer-events:none;z-index:2; }
    .hunt-arena::after { content:'';position:absolute;left:0;right:0;top:68%;height:1px;background:rgba(251,191,36,.18);box-shadow:0 0 12px rgba(251,191,36,.12);pointer-events:none;z-index:2; }
    .hunt-star { position:absolute;width:2px;height:2px;background:rgba(255,255,255,.6);border-radius:50%;pointer-events:none; }
    .hunt-crosshair { position:absolute;width:34px;height:34px;margin-left:-17px;margin-top:-17px;pointer-events:none;z-index:7;opacity:0;transition:opacity .12s; }
    .hunt-crosshair.on { opacity:1; }
    .hunt-crosshair::before,.hunt-crosshair::after { content:'';position:absolute;background:rgba(125,211,252,.95);box-shadow:0 0 6px rgba(56,189,248,.6);border-radius:2px; }
    .hunt-crosshair::before { left:16px;top:2px;width:2px;height:30px; }
    .hunt-crosshair::after { top:16px;left:2px;height:2px;width:30px; }
    .hunt-crosshair i { position:absolute;inset:5px;border:2px solid rgba(251,191,36,.9);border-radius:50%;box-shadow:0 0 8px rgba(251,191,36,.35), inset 0 0 8px rgba(251,191,36,.08); }
    .hunt-crosshair i::after { content:'';position:absolute;left:50%;top:50%;width:4px;height:4px;margin:-2px;background:#fbbf24;border-radius:50%;box-shadow:0 0 6px #fbbf24; }
    .hunt-target { position:absolute;width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;transform:translate(-50%,-50%);z-index:3;cursor:none;transition:transform .08s; }
    .hunt-target .hunt-target-body { width:100%;height:100%;border-radius:50%;display:flex;align-items:center;justify-content:center; }
    .hunt-target svg { width:58%;height:58%;display:block; }
    .hunt-target.bonus .hunt-target-body { background:radial-gradient(circle at 35% 30%,rgba(74,222,128,.35),rgba(16,185,129,.12) 60%,rgba(16,185,129,.04));border:1px solid rgba(74,222,128,.55);box-shadow:0 0 18px rgba(74,222,128,.35), inset 0 0 10px rgba(74,222,128,.12); }
    .hunt-target.bonus svg { filter:drop-shadow(0 0 8px rgba(74,222,128,.7)); }
    .hunt-target.hit { pointer-events:none;animation:huntPop .28s ease forwards; }
    @keyframes huntPop { 0%{transform:translate(-50%,-50%) scale(1);opacity:1} 60%{transform:translate(-50%,-50%) scale(1.35);opacity:.9} 100%{transform:translate(-50%,-50%) scale(.2);opacity:0} }
    .hunt-float { position:absolute;z-index:5;font-weight:800;font-size:.82rem;color:#4ade80;text-shadow:0 0 10px rgba(74,222,128,.6);pointer-events:none;animation:huntFloat .9s ease forwards;transform:translate(-50%,-50%); }
    @keyframes huntFloat { from{opacity:1;transform:translate(-50%,-50%) translateY(0)} to{opacity:0;transform:translate(-50%,-50%) translateY(-28px)} }
    .hunt-miss-fx { position:absolute;width:28px;height:28px;border:2px solid rgba(248,113,113,.7);border-radius:50%;transform:translate(-50%,-50%);pointer-events:none;z-index:4;animation:huntMiss .35s ease forwards; }
    @keyframes huntMiss { from{opacity:1;transform:translate(-50%,-50%) scale(.5)} to{opacity:0;transform:translate(-50%,-50%) scale(1.4)} }
    .hunt-msg { position:absolute;inset:0;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:.45rem;background:rgba(6,10,24,.55);z-index:6;text-align:center;padding:1rem; }
    .hunt-msg[hidden] { display:none !important; }
    .hunt-msg h3 { font-size:1.1rem;color:#fde68a;margin:0; }
    .hunt-msg p { font-size:.82rem;color:var(--text-muted);margin:0;line-height:1.5; }
    .hunt-msg .hunt-motto { font-size:.78rem;color:#86efac;background:rgba(16,185,129,.1);border:1px solid rgba(74,222,128,.18);padding:.45rem .65rem;border-radius:10px;margin-top:.15rem;max-width:320px; }
    .hunt-actions { display:flex;gap:.5rem;justify-content:center;margin-top:.65rem; }
    .hunt-btn { padding:.55rem 1rem;border-radius:10px;border:none;font-weight:700;font-size:.8rem;cursor:pointer;transition:all .2s; }
    .hunt-btn.primary { background:linear-gradient(135deg,#fbbf24,#f59e0b);color:#422006; }
    .hunt-btn.primary:hover { filter:brightness(1.05); }
    @media(max-width:420px){ .hunt-box{padding:.85rem;} .hunt-target{width:38px;height:38px;} .hunt-stat span{font-size:.58rem;} }
  </style>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body>

<nav id="main-navbar" class="navbar" role="navigation" aria-label="Əsas naviqasiya">
  <div class="container nav-inner">
    <?= render_language_switcher('module-lang-switch') ?>
    <a href="<?= SITE_URL ?>" class="logo" id="logo-link" aria-label="Skyweb.az Ana Səhifə">
      <div class="logo-icon" aria-hidden="true">
        <svg class="sky-logo-svg" viewBox="0 0 142 96" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="skySGrad" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#38bdf8" />
              <stop offset="100%" stop-color="#0284c7" />
            </linearGradient>
            <filter id="skyLogoGlow" x="-20%" y="-20%" width="140%" height="140%">
              <feGaussianBlur stdDeviation="3" result="blur" />
              <feMerge>
                <feMergeNode in="blur" />
                <feMergeNode in="SourceGraphic" />
              </feMerge>
            </filter>
          </defs>
          <path d="M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z" fill="url(#skySGrad)" />
          <g filter="url(#skyLogoGlow)">
            <path d="M48,20 Q64,13 80,13 L110,13" stroke="var(--neon-cyan)" stroke-width="1.8" stroke-linecap="round" fill="none" opacity="0.85" />
            <circle cx="110" cy="13" r="2.2" fill="var(--neon-cyan)" />
            <path d="M54,32 Q70,30 84,30 L110,30" stroke="var(--neon-cyan)" stroke-width="1.8" stroke-linecap="round" fill="none" opacity="0.85" />
            <circle cx="110" cy="30" r="2.2" fill="var(--neon-cyan)" />
            <path d="M60,48 L110,48" stroke="var(--neon-cyan)" stroke-width="1.8" stroke-linecap="round" fill="none" opacity="0.85" />
            <circle cx="110" cy="48" r="2.2" fill="var(--neon-cyan)" />
            <path d="M54,64 Q70,66 84,66 L110,66" stroke="var(--neon-cyan)" stroke-width="1.8" stroke-linecap="round" fill="none" opacity="0.85" />
            <circle cx="110" cy="66" r="2.2" fill="var(--neon-cyan)" />
            <path d="M48,76 Q64,83 80,83 L110,83" stroke="var(--neon-cyan)" stroke-width="1.8" stroke-linecap="round" fill="none" opacity="0.85" />
            <circle cx="110" cy="83" r="2.2" fill="var(--neon-cyan)" />
            <g transform="translate(122, 5)" stroke="var(--neon-cyan)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none">
              <path d="M2.5,12 h10 a2.5,2.5 0 0,0 2.2,-3.7 a3.5,3.5 0 0,0 -6.2,-2.3 a3,3 0 0,0 -5.3,1.5 a2,2 0 0,0 -0.7,4.5 z" />
            </g>
            <g transform="translate(122, 22)" stroke="var(--neon-cyan)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none">
              <rect x="1" y="2" width="13" height="4.5" rx="1" />
              <rect x="1" y="8.5" width="13" height="4.5" rx="1" />
              <circle cx="3.5" cy="4.25" r="0.5" fill="var(--neon-cyan)" />
              <circle cx="3.5" cy="10.75" r="0.5" fill="var(--neon-cyan)" />
            </g>
            <g transform="translate(122, 40)" stroke="var(--neon-cyan)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none">
              <path d="M1,2 L7.5,0.5 L14,2 L14,6 C14,10 11,12.5 7.5,14.5 C4,12.5 1,10 1,6 Z" />
              <path d="M4.5,7.5 L6.5,9.5 L10.5,5.5" />
            </g>
            <g transform="translate(122, 58.5)" stroke="var(--neon-cyan)" stroke-width="1.5" fill="none">
              <circle cx="7.5" cy="7.5" r="7" />
              <ellipse cx="7.5" cy="7.5" rx="2.5" ry="7" />
              <line x1="0.5" y1="7.5" x2="14.5" y2="7.5" stroke-linecap="round" stroke-linejoin="round" />
            </g>
            <g transform="translate(122, 75.5)" stroke="var(--neon-cyan)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none">
              <path d="M 7.5,0 L 14,3.5 L 14,11.5 L 7.5,15 L 1,11.5 L 1,3.5 Z" />
              <path d="M 1,3.5 L 7.5,7.5 L 14,3.5" />
              <path d="M 7.5,7.5 L 7.5,15" />
            </g>
          </g>
        </svg>
      </div>
      <span class="logo-text"><span class="logo-sky">sky</span><span class="logo-web">web</span><span class="dot-az">.az</span></span>
    </a>
    <a href="<?= SITE_URL ?>" class="games-back-link">← Ana səhifəyə qayıt</a>
  </div>
</nav>

<main class="games-page">
  <div class="container">

    <nav class="breadcrumb" aria-label="Naviqasiya yolu">
      <a href="<?= SITE_URL ?>">Ana Səhifə</a>
      <span style="opacity:0.4">/</span>
      <span>Oyun Sifariş Paneli</span>
    </nav>

    <!-- Hero -->
    <div class="games-hero">
      <div style="flex:1;min-width:250px;">
        <div class="games-hero-badge">🎮 Gamification Xidmətləri</div>
        <h1 class="games-hero-title">Brendinizə <span class="gradient-text">Mini Oyun</span> Sifariş Edin</h1>
        <p class="games-hero-desc">İstənilən biznes üçün müştəri cəlb edəcək, loyallığı artıracaq interaktiv mini oyunlar hazırlayırıq. Web &amp; Wap uyumlu, tam hazır çatdırılır.</p>
        <div style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-top:1.5rem;">
          <a href="#gamesGrid" class="btn-ghost"><span>Oyunlara Bax</span></a>
        </div>
      </div>
      <div class="games-hero-right">
        <div class="hero-stat"><div class="hero-stat-val">120+</div><div class="hero-stat-label">Tamamlanan layihə</div></div>
        <div class="hero-stat"><div class="hero-stat-val">98%</div><div class="hero-stat-label">Müştəri məmnuniyyəti</div></div>
        <div class="hero-stat"><div class="hero-stat-val">3-7</div><div class="hero-stat-label">Günlük çatdırılma</div></div>
      </div>
    </div>

    <!-- Game Cards -->
    <div class="games-grid" id="gamesGrid">

      <div class="game-card">
        <div class="game-card-preview" style="background:linear-gradient(135deg,rgba(99,102,241,0.15),rgba(139,92,246,0.1));">
          <span class="game-quiz-mark" aria-hidden="true">
            <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M25 23a7 7 0 1 1 11 5.6c-2.2 1.7-4 2.7-4 5.4" stroke="#fff" stroke-width="4" stroke-linecap="round"/>
              <circle cx="32" cy="43" r="2.6" fill="#fff"/>
              <path d="M49 7l1.4 4.1L54.5 12.5l-4.1 1.4L49 18l-1.4-4.1L43.5 12.5l4.1-1.4z" fill="#fff" opacity="0.9"/>
            </svg>
          </span>
          <div class="game-badge badge-popular">Populyar</div>
        </div>
        <div class="game-card-body">
          <div class="game-name">Brend Viktorinası</div>
          <div class="game-desc">Brend və məhsullarınız haqqında suallar-cavablar oyunu. Müştərilər oynayır, brend bilinirliyi artır, sosial mediada paylaşılır.</div>
          <div class="game-features">
            <span class="game-feat-tag">Çox oyunçu</span>
            <span class="game-feat-tag">Liderlik cədvəli</span>
            <span class="game-feat-tag">Mükafat sistemi</span>
            <span class="game-feat-tag">Avtomatik hesab</span>
          </div>
          <button class="game-demo-btn" id="quizDemoBtn" type="button">Oyuna daxil ol</button>
        </div>
      </div>

      <div class="game-card">
        <div class="game-card-preview" style="background:linear-gradient(135deg,rgba(99,102,241,0.1),rgba(244,63,94,0.08));">
          <span style="position:relative;z-index:2;">🧠</span>
          <div class="game-badge badge-new">Yeni</div>
        </div>
        <div class="game-card-body">
          <div class="game-name">Canlı Viktorina Müsabiqəsi</div>
          <div class="game-desc">Sosial media canlı yayımlarında istifadə üçün interaktiv viktorina. İzləyicilər real vaxtda iştirak edir, ən yaxşılar mükafat qazanır.</div>
          <div class="game-features">
            <span class="game-feat-tag">Canlı rejim</span>
            <span class="game-feat-tag">İnstagram uyumlu</span>
            <span class="game-feat-tag">Moderasiya paneli</span>
          </div>
          <button class="game-demo-btn" type="button">Oyuna daxil ol</button>
        </div>
      </div>

      <div class="game-card">
        <div class="game-card-preview" style="background:linear-gradient(135deg,rgba(251,191,36,0.14),rgba(168,85,247,0.12));">
          <span class="game-riddle-mark" aria-hidden="true">
            <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M32 8c-9.4 0-17 7.4-17 16.6 0 6.2 3.3 9.8 6.2 13.2 1.7 2 2.8 3.6 3.2 6.2h15.2c.4-2.6 1.5-4.2 3.2-6.2 2.9-3.4 6.2-7 6.2-13.2C49 15.4 41.4 8 32 8Z" stroke="#fff" stroke-width="4" stroke-linejoin="round"/>
              <path d="M26 48h12M28 54h8" stroke="#fff" stroke-width="4" stroke-linecap="round"/>
              <path d="M32 21v10M27 26h10" stroke="#fff" stroke-width="3" stroke-linecap="round" opacity="0.9"/>
            </svg>
          </span>
          <div class="game-badge badge-new">Yeni</div>
        </div>
        <div class="game-card-body">
          <div class="game-name">Brend Tapmacaları</div>
          <div class="game-desc">Gündə 2 ipucu, 3 keç imkanı və canlı reytinq cədvəli. Qeydiyyatdan keç, hər gün qayıdıb sıralamada irəli get.</div>
          <div class="game-features">
            <span class="game-feat-tag">Sonsuz rejim</span>
            <span class="game-feat-tag">Gündəlik limit</span>
            <span class="game-feat-tag">Reytinq cədvəli</span>
            <span class="game-feat-tag">Qeydiyyatla</span>
          </div>
          <button class="game-demo-btn" id="riddleDemoBtn" type="button">Oyuna daxil ol</button>
        </div>
      </div>

      <div class="game-card">
        <div class="game-card-preview" style="background:linear-gradient(135deg,rgba(56,189,248,0.14),rgba(16,185,129,0.10));">
          <span class="game-memory-mark" aria-hidden="true">
            <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="10" y="10" width="18" height="18" rx="4" stroke="#fff" stroke-width="3.5"/>
              <rect x="36" y="10" width="18" height="18" rx="4" stroke="#fff" stroke-width="3.5"/>
              <rect x="10" y="36" width="18" height="18" rx="4" stroke="#fff" stroke-width="3.5"/>
              <rect x="36" y="36" width="18" height="18" rx="4" fill="rgba(255,255,255,0.18)" stroke="#fff" stroke-width="3.5"/>
              <path d="M41 45l3 3 5-6" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <div class="game-badge badge-new">Yeni</div>
        </div>
        <div class="game-card-body">
          <div class="game-name">Brend Yaddaşı</div>
          <div class="game-desc">Kartları çevir, eyni cütləri tap. Yaddaşını sınayan bu retro mini oyun müştərini saytda daha uzun saxlayır.</div>
          <div class="game-features">
            <span class="game-feat-tag">Yaddaş oyunu</span>
            <span class="game-feat-tag">Səviyyə</span>
            <span class="game-feat-tag">Ən yaxşı nəticə</span>
            <span class="game-feat-tag">Səs effekti</span>
          </div>
          <button class="game-demo-btn" id="memoryDemoBtn" type="button">Oyuna daxil ol</button>
        </div>
      </div>

      <div class="game-card">
        <div class="game-card-preview" style="background:linear-gradient(135deg,rgba(251,191,36,0.14),rgba(249,115,22,0.10));">
          <span aria-hidden="true" style="position:relative;z-index:2;display:flex;align-items:center;justify-content:center;width:72px;height:72px;border-radius:18px;background:rgba(251,191,36,.12);border:1px solid rgba(251,191,36,.22);">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:38px;height:38px;"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="4"/><circle cx="12" cy="12" r="1.2" fill="#fbbf24" stroke="none"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/></svg>
          </span>
          <div class="game-badge badge-new">Yeni</div>
        </div>
        <div class="game-card-body">
          <div class="game-name">Brend Ovçusu</div>
          <div class="game-desc">Retro hədəf ovçusu: uçan brend nişanlarını vur, xal topla, səviyyə keç. Sürətli, yığcam və mobil uyumlu mini oyun.</div>
          <div class="game-features">
            <span class="game-feat-tag">Retro arcade</span>
            <span class="game-feat-tag">Refleks</span>
            <span class="game-feat-tag">Səviyyə</span>
            <span class="game-feat-tag">Səs effekti</span>
          </div>
          <button class="game-demo-btn" id="huntDemoBtn" type="button">Oyuna daxil ol</button>
        </div>
      </div>

    </div><!-- /games-grid -->

  </div>
</main>

<!-- Brend Ovçusu — retro target hunt demo -->
<div class="hunt-overlay" id="huntOverlay" role="dialog" aria-modal="true" aria-label="Brend Ovçusu">
  <div class="hunt-box">
    <button class="hunt-close" id="huntClose" type="button" aria-label="Oyunu bağla">×</button>
    <div class="hunt-head">
      <div>
        <div class="hunt-title">Brend <span>Ovçusu</span></div>
        <div class="hunt-sub" id="huntLevel">Səviyyə 1 · Retro rejim</div>
      </div>
    </div>
    <div class="hunt-stats">
      <div class="hunt-stat"><span>Xal</span><strong id="huntScore">0</strong></div>
      <div class="hunt-stat"><span>Həyat</span><strong id="huntLives">3</strong></div>
      <div class="hunt-stat"><span>Dalğa</span><strong id="huntWave">1</strong></div>
      <div class="hunt-stat"><span>Rekord</span><strong id="huntBest">0</strong></div>
    </div>
    <div class="hunt-arena" id="huntArena" aria-label="Oyun sahəsi">
      <div class="hunt-crosshair" id="huntCrosshair"><i></i></div>
      <div class="hunt-msg" id="huntMsg">
        <h3 id="huntMsgTitle">Brend Ovçusu</h3>
        <p id="huntMsgText">Uçan nişanlara vur, canını qoru.</p>
        <button class="hunt-btn primary" id="huntStart" type="button">Başla</button>
      </div>
    </div>
  </div>
</div>

<!-- Brend Viktorinası — oynanabilir demo -->
<div class="quiz-overlay" id="quizOverlay" role="dialog" aria-modal="true" aria-label="Brend Viktorinası">
  <div class="quiz-box">
    <button class="quiz-close" id="quizClose" type="button" aria-label="Oyunu bağla">✕</button>
    <div class="quiz-brand">
      <span class="quiz-brand-mark" aria-hidden="true">
        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M25 23a7 7 0 1 1 11 5.6c-2.2 1.7-4 2.7-4 5.4" stroke="#fff" stroke-width="4" stroke-linecap="round"/>
          <circle cx="32" cy="43" r="2.6" fill="#fff"/>
          <path d="M49 7l1.4 4.1L54.5 12.5l-4.1 1.4L49 18l-1.4-4.1L43.5 12.5l4.1-1.4z" fill="#fff" opacity="0.9"/>
        </svg>
      </span>
      <span class="quiz-brand-copy">
        <span class="quiz-brand-name">Brend Viktorinası</span>
        <span class="quiz-brand-sub">25 Azərbaycan sualı</span>
      </span>
    </div>
    <div class="quiz-topic" id="quizTopic">Azərbaycan coğrafiyası</div>
    <div class="quiz-counter"><span>Sual</span> <span id="quizQNum">1</span> / <span id="quizQTotal">25</span></div>
    <div class="quiz-progress"><div class="quiz-progress-bar" id="quizProgressBar"></div></div>

    <div class="quiz-status" id="quizStatus" hidden>
      <span class="quiz-status-rank" id="quizRankText"></span>
      <span class="quiz-status-meta"><span id="quizCorrectCount">0</span> <span id="quizCorrectLabel">doğru cavab</span> · <span id="quizNextRankText"></span></span>
    </div>

    <div id="quizPlay">
      <h2 class="quiz-question" id="quizQuestion"></h2>
      <div class="quiz-options" id="quizOptions"></div>
      <div class="quiz-feedback" id="quizFeedback" aria-live="polite" hidden>
        <span id="quizFeedbackText"></span>
        <span class="quiz-feedback-answer" id="quizFeedbackAnswerWrap" hidden><span>Doğru cavab:</span> <span id="quizFeedbackAnswer"></span></span>
      </div>
      <button class="quiz-next" id="quizNext" type="button" hidden>Növbəti sual</button>
    </div>

    <div class="quiz-result" id="quizResult" hidden>
      <div class="quiz-result-icon">🏆</div>
      <h2 class="quiz-result-title">Oyun bitdi!</h2>
      <p class="quiz-result-score"><span>Bal:</span> <span id="quizScore">0</span></p>
      <p class="quiz-result-msg" id="quizResultMsg"></p>
      <button class="quiz-next" id="quizRestart" type="button">Yenidən oyna</button>
    </div>

    <div class="quiz-state" id="quizGate" hidden>
      <div class="quiz-state-icon" aria-hidden="true">🔒</div>
      <h2 id="quizGateTitle">Qeydiyyat tələb olunur</h2>
      <p id="quizGateMsg">Viktorinada səhv cavab verdin. Davam etmək üçün saytda qeydiyyatdan keç.</p>
      <div class="quiz-state-actions">
        <a class="quiz-next" id="quizGateRegister" href="#">Qeydiyyatdan keç</a>
        <a class="quiz-next ghost" id="quizGateLogin" href="#">Giriş et</a>
      </div>
    </div>
  </div>
</div>

<!-- Brend Tapmacaları — endless daily riddles -->
<div class="riddle-overlay" id="riddleOverlay" role="dialog" aria-modal="true" aria-label="Brend Tapmacaları">
  <div class="riddle-box">
    <button class="riddle-close" id="riddleClose" type="button" aria-label="Tapmaca oyununu bağla">✕</button>
    <div class="riddle-brand">
      <span class="riddle-brand-mark" aria-hidden="true">
        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M32 8c-9.4 0-17 7.4-17 16.6 0 6.2 3.3 9.8 6.2 13.2 1.7 2 2.8 3.6 3.2 6.2h15.2c.4-2.6 1.5-4.2 3.2-6.2 2.9-3.4 6.2-7 6.2-13.2C49 15.4 41.4 8 32 8Z" stroke="#fff" stroke-width="4" stroke-linejoin="round"/>
          <path d="M26 48h12M28 54h8" stroke="#fff" stroke-width="4" stroke-linecap="round"/>
          <path d="M32 21v10M27 26h10" stroke="#fff" stroke-width="3" stroke-linecap="round" opacity="0.9"/>
        </svg>
      </span>
      <span class="riddle-brand-copy">
        <span class="riddle-brand-name">Brend Tapmacaları</span>
        <span class="riddle-brand-sub">Gündəlik reytinq seriyası</span>
      </span>
    </div>
    <div class="riddle-toast" id="riddleToast" hidden></div>
    <div class="riddle-stats">
      <div class="riddle-stat"><span>Reytinq</span><strong id="riddleRating">0</strong></div>
      <div class="riddle-stat"><span>Seriya</span><strong id="riddleStreak">0</strong></div>
      <div class="riddle-stat"><span>Bugün</span><strong><span id="riddleToday">0</span>/5</strong></div>
    </div>
    <div class="riddle-rank" id="riddleRank">Səviyyə 1 · Yeni başlayan</div>
    <div class="riddle-goal"><span id="riddleGoalText">Bugünkü məqsəd: 5 tapmaca</span><div class="riddle-goal-bar"><i id="riddleGoalBar"></i></div></div>
    <div class="riddle-limits" id="riddleLimits">
      <span class="riddle-limit"><span>İpucu</span> <b id="riddleHintLeft">2</b>/2</span>
      <span class="riddle-limit"><span>Keç</span> <b id="riddleSkipLeft">3</b>/3</span>
      <span class="riddle-tz" id="riddleTz"></span>
    </div>
    <div class="riddle-records" id="riddleRecords" hidden><span>Top nəticələr</span> <span id="riddleRecordsList"></span></div>
    <div class="riddle-board" id="riddleBoard">
      <div class="riddle-board-head"><span>Reytinq cədvəli</span><span id="riddleMyRank"></span></div>
      <ol id="riddleBoardList"></ol>
      <div class="riddle-board-note" id="riddleBoardNote" hidden></div>
    </div>
    <div class="riddle-card">
      <div class="quiz-counter"><span>Tapmaca</span> <span id="riddleNum">1</span> · <span>Raund</span> <span id="riddleRound">1</span> · ∞</div>
      <h2 class="riddle-text" id="riddleText"></h2>
      <div class="riddle-options" id="riddleOptions"></div>
      <div class="riddle-hint" id="riddleHint" hidden></div>
      <div class="riddle-feedback" id="riddleFeedback" aria-live="polite" hidden>
        <span id="riddleFeedbackText"></span>
        <small id="riddleFeedbackAnswer" hidden></small>
      </div>
      <div class="riddle-actions">
        <button class="riddle-btn ghost" id="riddleHintBtn" type="button">İpucu göstər</button>
        <button class="riddle-btn ghost" id="riddleSkipBtn" type="button">Keç</button>
        <button class="riddle-btn primary" id="riddleNextBtn" type="button" hidden>Növbəti tapmaca</button>
      </div>
    </div>

    <div class="riddle-state" id="riddleBlocked" hidden>
      <div class="riddle-state-icon" aria-hidden="true">⏳</div>
      <h2>Bugünkü oyun bitdi</h2>
      <p>Limitlər cihazının yerli vaxtına görə sıfırlanır.</p>
      <div class="riddle-wait" id="riddleWait"></div>
      <div class="riddle-state-answer" id="riddleBlockedAnswer" hidden></div>
      <button class="riddle-btn primary" id="riddleBlockedClose" type="button">Bağla</button>
    </div>

    <div class="riddle-state" id="riddleGate" hidden>
      <div class="riddle-state-icon" aria-hidden="true">🔒</div>
      <h2>Qeydiyyat tələb olunur</h2>
      <p>Bir pulsuz oyun oynadın. Davam etmək üçün qeydiyyatdan keç.</p>
      <p class="riddle-state-small">Qeydiyyatdan sonra günlük limitlərlə oynayacaqsan.</p>
      <div class="riddle-gate-actions">
        <a class="riddle-btn primary" id="riddleRegisterLink" href="#">Qeydiyyatdan keç</a>
        <a class="riddle-btn ghost" id="riddleLoginLink" href="#">Giriş et</a>
      </div>
    </div>
  </div>
</div>


<!-- Brend Yaddaşı — memory match demo -->
<div class="memory-overlay" id="memoryOverlay" role="dialog" aria-modal="true" aria-label="Brend Yaddaşı">
  <div class="memory-box">
    <button class="memory-close" id="memoryClose" type="button" aria-label="Oyunu bağla">×</button>
    <div class="memory-head">
      <div>
        <div class="memory-title">Brend <span>Yaddaşı</span></div>
        <div class="memory-level" id="memoryLevel">Səviyyə 1 · Yeni başlayan</div>
      </div>
    </div>
    <div class="memory-stats">
      <div class="memory-stat"><span>Gediş</span><strong id="memoryMoves">0</strong></div>
      <div class="memory-stat"><span>Vaxt</span><strong id="memoryTime">0:00</strong></div>
      <div class="memory-stat"><span>Cüt</span><strong id="memoryPairs">0/8</strong></div>
      <div class="memory-stat"><span>Rekord</span><strong id="memoryBest">—</strong></div>
    </div>
    <div class="memory-grid" id="memoryGrid"></div>
    <div class="memory-win" id="memoryWin" hidden>
      <div class="memory-win-title" id="memoryWinTitle">Əla! Bütün cütlər tapıldı</div>
      <p id="memoryWinMsg"></p>
      <div class="memory-actions">
        <button class="memory-btn primary" id="memoryRestart" type="button">Yenidən oyna</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
<script>
<?php $quizUser = currentUser(); ?>
var quizAuth = <?= json_encode([
  'loggedIn' => isLoggedIn(),
  'userId' => (int) ($_SESSION['user_id'] ?? 0),
  'name' => (string) ($quizUser['fullname'] ?? ''),
  'registerUrl' => SITE_URL . '/auth/register.php',
  'loginUrl' => SITE_URL . '/auth/login.php',
  'csrf' => csrf_token()
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
(function () {
  var overlay     = document.getElementById('quizOverlay');
  var openBtn     = document.getElementById('quizDemoBtn');
  var closeBtn    = document.getElementById('quizClose');
  var play        = document.getElementById('quizPlay');
  var result      = document.getElementById('quizResult');
  var topicEl     = document.getElementById('quizTopic');
  var questionEl  = document.getElementById('quizQuestion');
  var optionsEl   = document.getElementById('quizOptions');
  var qNum        = document.getElementById('quizQNum');
  var qTotal      = document.getElementById('quizQTotal');
  var progress    = document.getElementById('quizProgressBar');
  var feedback    = document.getElementById('quizFeedback');
  var feedbackTxt = document.getElementById('quizFeedbackText');
  var answerWrap  = document.getElementById('quizFeedbackAnswerWrap');
  var answerEl    = document.getElementById('quizFeedbackAnswer');
  var nextBtn     = document.getElementById('quizNext');
  var restartBtn  = document.getElementById('quizRestart');
  var scoreEl     = document.getElementById('quizScore');
  var resultMsg   = document.getElementById('quizResultMsg');
  var statusEl    = document.getElementById('quizStatus');
  var rankTextEl  = document.getElementById('quizRankText');
  var correctCountEl = document.getElementById('quizCorrectCount');
  var correctLabelEl = document.getElementById('quizCorrectLabel');
  var nextRankTextEl = document.getElementById('quizNextRankText');
  var gateEl      = document.getElementById('quizGate');
  var gateTitleEl = document.getElementById('quizGateTitle');
  var gateMsgEl   = document.getElementById('quizGateMsg');
  var gateRegister = document.getElementById('quizGateRegister');
  var gateLogin   = document.getElementById('quizGateLogin');

  if (!overlay || !openBtn) return;

  var QSTORE = 'skyweb_quiz_v1';
  var QGUEST_FLAG = 'skyweb_quiz_guest_played';
  var QGUEST_COOKIE = 'skyweb_quiz_guest=1';
  var audioCtx = null;

  function playSound(ok) {
    try {
      var Ctx = window.AudioContext || window.webkitAudioContext;
      if (!Ctx) return;
      if (!audioCtx) audioCtx = new Ctx();
      if (audioCtx.state === 'suspended') audioCtx.resume();
      var now = audioCtx.currentTime;
      function tone(freq, start, dur, type, vol, slide) {
        var o = audioCtx.createOscillator();
        var g = audioCtx.createGain();
        o.type = type;
        o.frequency.setValueAtTime(freq, now + start);
        if (slide) o.frequency.exponentialRampToValueAtTime(Math.max(slide, 0.0001), now + start + dur);
        g.gain.setValueAtTime(0.0001, now + start);
        g.gain.exponentialRampToValueAtTime(vol, now + start + 0.03);
        g.gain.exponentialRampToValueAtTime(0.0001, now + start + dur);
        o.connect(g); g.connect(audioCtx.destination);
        o.start(now + start); o.stop(now + start + dur + 0.02);
      }
      if (ok) {
        // Happy ascending major arpeggio with a soft sparkle
        tone(523.25, 0,    0.22, 'sine', 0.14, 523.25); // C5
        tone(659.25, 0.08, 0.24, 'sine', 0.15, 659.25); // E5
        tone(783.99, 0.16, 0.32, 'sine', 0.16, 783.99); // G5
        tone(1046.5, 0.24, 0.38, 'sine', 0.07, 1046.5); // C6 sparkle
      } else {
        // Gentle disappointed descending tones
        tone(392.00, 0,    0.34, 'triangle', 0.13, 349.23); // G4 -> F4
        tone(311.13, 0.12, 0.38, 'triangle', 0.11, 261.63); // Eb4 -> C4
        tone(220.00, 0.24, 0.45, 'sine',     0.09, 196.00); // A3 -> G3 soft tail
      }
    } catch (e) { /* audio optional */ }
  }

  function qStoreKey() {
    return quizAuth.loggedIn && quizAuth.userId ? QSTORE + '_u' + quizAuth.userId : QSTORE;
  }
  function qGuestPlayed() {
    try { if (localStorage.getItem(QGUEST_FLAG) === '1') return true; } catch (e) { /* private mode */ }
    return document.cookie.split(';').some(function (p) { return p.trim() === QGUEST_COOKIE; });
  }
  function qMarkGuestPlayed() {
    if (quizAuth.loggedIn) return;
    try { localStorage.setItem(QGUEST_FLAG, '1'); } catch (e) { /* private mode */ }
    document.cookie = QGUEST_COOKIE + '; path=/; max-age=31536000; SameSite=Lax';
  }
  function qDefault() { return { totalCorrect: 0, bestScore: 0, gamesPlayed: 0 }; }
  function qLoad() {
    try {
      var raw = localStorage.getItem(qStoreKey());
      if (!raw) return qDefault();
      var s = JSON.parse(raw);
      return {
        totalCorrect: Math.max(0, Number(s.totalCorrect) || 0),
        bestScore: Math.max(0, Number(s.bestScore) || 0),
        gamesPlayed: Math.max(0, Number(s.gamesPlayed) || 0)
      };
    } catch (e) { return qDefault(); }
  }
  function qSave(s) { try { localStorage.setItem(qStoreKey(), JSON.stringify(s)); } catch (e) { /* private mode */ } }
  var qState = qLoad();

  function qRankInfo(totalCorrect) {
    var level = Math.floor(totalCorrect / 10) + 1;
    var titles = ['Yeni başlayan', 'Bilməyə can atan', 'Bilici', 'Usta', 'Çempion', 'Əfsanə'];
    var title = titles[Math.min(level - 1, titles.length - 1)];
    var nextAt = level * 10;
    return { level: level, title: title, nextAt: nextAt, inLevel: totalCorrect % 10 };
  }
  function renderQuizStatus() {
    if (!statusEl) return;
    var info = qRankInfo(sessionCorrect);
    rankTextEl.textContent = qt('Səviyyə') + ' ' + info.level + ' · ' + qt(info.title);
    correctCountEl.textContent = String(sessionCorrect);
    correctLabelEl.textContent = qt('doğru cavab');
    nextRankTextEl.textContent = qt('növbəti') + ': ' + info.inLevel + '/10 · ' + qt('ümumi') + ': ' + qState.totalCorrect;
    statusEl.hidden = false;
  }
  function showQuizGate() {
    play.hidden = true;
    result.hidden = true;
    gateEl.hidden = false;
    gateRegister.href = quizAuth.registerUrl;
    gateLogin.href = quizAuth.loginUrl;
  }
  function hideQuizGate() {
    gateEl.hidden = true;
  }

  // 25 Azerbaijan questions — 5 topics x 5 questions. AZ source strings are
  // translated through the shared SkyI18n literal map, so every option follows
  // the active language exactly like the rest of the site.
  var questions = [
    /* Coğrafiya */
    {
      topic: 'Azərbaycan coğrafiyası',
      q: 'Azərbaycanın ərazisi neçə kvadrat kilometrdir?',
      options: ['86,600 km²', '186,600 km²', '56,600 km²', '126,600 km²'], answer: 0
    },
    {
      topic: 'Azərbaycan coğrafiyası',
      q: 'Ərazisinə görə Azərbaycanın ən böyük şəhəri hansıdır?',
      options: ['Bakı', 'Sumqayıt', 'Gəncə', 'Naxçıvan'], answer: 0
    },
    {
      topic: 'Azərbaycan coğrafiyası',
      q: 'Əhalisinin sayına görə Azərbaycanda üçüncü ən böyük şəhər hansıdır?',
      options: ['Gəncə', 'Sumqayıt', 'Xırdalan', 'Mingəçevir'], answer: 0
    },
    {
      topic: 'Azərbaycan coğrafiyası',
      q: 'Azərbaycanın ən yüksək dağ zirvəsi hansıdır?',
      options: ['Bazardüzü', 'Şahdağ', 'Tufandağ', 'Qapıcıq'], answer: 0
    },
    {
      topic: 'Azərbaycan coğrafiyası',
      q: 'Azərbaycanın quru sərhədinin olduğu ölkələr hansılardır?',
      options: [
        'Rusiya, Gürcüstan, Ermənistan, İran və Türkiyə',
        'Rusiya, Ukrayna, İran və Türkiyə',
        'Gürcüstan, Ermənistan, İraq və İran',
        'İran, Türkiyə, Suriya və Rusiya'
      ], answer: 0
    },

    /* Tarix */
    {
      topic: 'Azərbaycan tarixi',
      q: 'İkinci Qarabağ müharibəsinin Zəfər Günü hansı tarixdir?',
      options: ['8 noyabr 2020', '10 noyabr 2020', '27 sentyabr 2020', '9 may 1945'], answer: 0
    },
    {
      topic: 'Azərbaycan tarixi',
      q: 'Vətən müharibəsi neçə gün davam etdi?',
      options: ['44 gün', '28 gün', '100 gün', '30 gün'], answer: 0
    },
    {
      topic: 'Azərbaycan tarixi',
      q: 'Zəfər Günündə azad edilən şəhər hansı oldu?',
      options: ['Şuşa', 'Gəncə', 'Bərdə', 'Tərtər'], answer: 0
    },
    {
      topic: 'Azərbaycan tarixi',
      q: 'Azərbaycan müstəqilliyini nə vaxt bərpa etdi?',
      options: ['18 oktyabr 1991', '28 may 1918', '2 mart 1992', '10 noyabr 2020'], answer: 0
    },
    {
      topic: 'Azərbaycan tarixi',
      q: 'Atəşkəs haqqında üçtərəfli bəyanat hansı tarixdə imzalandı?',
      options: ['10 noyabr 2020', '8 noyabr 2020', '27 sentyabr 2020', '1 dekabr 2020'], answer: 0
    },

    /* İdman */
    {
      topic: 'Azərbaycan idmanı',
      q: '1966-cı il Dünya Kuboku finalında qol qərarı ilə tanınan azərbaycanlı hakim kimdir?',
      options: ['Tofiq Bəhramov', 'Rəfael Ağayev', 'Elnur Məmmədli', 'Vüqar Həşimov'], answer: 0
    },
    {
      topic: 'Azərbaycan idmanı',
      q: '2008 Pekin Olimpiadasında cüdoda qızıl medal qazanan idmançı kimdir?',
      options: ['Elnur Məmmədli', 'Rəfael Ağayev', 'Mariya Stadnik', 'Şəhriyar Məmmədyarov'], answer: 0
    },
    {
      topic: 'Azərbaycan idmanı',
      q: 'Dünya karate çempionatlarında beş dəfə çempion olan idmançı kimdir?',
      options: ['Rəfael Ağayev', 'Tofiq Bəhramov', 'Elnur Məmmədli', 'Vüqar Həşimov'], answer: 0
    },
    {
      topic: 'Azərbaycan idmanı',
      q: '2009-cu ildə dünya reytinqində 6-cı yerə qədər yüksələn şahmatçı kimdir?',
      options: ['Vüqar Həşimov', 'Şəhriyar Məmmədyarov', 'Tofiq Bəhramov', 'Rəfael Ağayev'], answer: 0
    },
    {
      topic: 'Azərbaycan idmanı',
      q: '2012 London Olimpiadasında güləş üzrə qızıl medal qazanan azərbaycanlı idmançı kimdir?',
      options: ['Toğrul Əsgərov', 'Mariya Stadnik', 'Rövşən Bayramov', 'Emin Əhmədov'], answer: 0
    },

    /* İncəsənət */
    {
      topic: 'Azərbaycan incəsənəti',
      q: 'Azərbaycanda ilk operanı — "Leyli və Məcnun"u kim yazdı?',
      options: ['Üzeyir Hacıbəyov', 'Qara Qarayev', 'Müslüm Maqomayev', 'Səttar Bəhlulzadə'], answer: 0
    },
    {
      topic: 'Azərbaycan incəsənəti',
      q: '"Yeddi gözəl" baletinin bəstəkarı kimdir?',
      options: ['Qara Qarayev', 'Üzeyir Hacıbəyov', 'Soltan Hacıbəyov', 'Müslüm Maqomayev'], answer: 0
    },
    {
      topic: 'Azərbaycan incəsənəti',
      q: 'Rəssam Səttar Bəhlulzadə hansı mövzuda əsərləri ilə tanınır?',
      options: ['Qarabağ təbiəti', 'Dəniz limanları', 'Şəhər küçələri', 'Zavodlar'], answer: 0
    },
    {
      topic: 'Azərbaycan incəsənəti',
      q: '1962-ci ildə Kreml Sarayında çıxışı ilə şöhrət qazanan müğənni kimdir?',
      options: ['Müslüm Maqomayev', 'Üzeyir Hacıbəyov', 'Qara Qarayev', 'Səttar Bəhlulzadə'], answer: 0
    },
    {
      topic: 'Azərbaycan incəsənəti',
      q: 'Şuşada yaşayıb yaradan məşhur azərbaycanlı şairə kimdir?',
      options: ['Xurşidbanu Natəvan', 'Səttar Bəhlulzadə', 'Müslüm Maqomayev', 'Qara Qarayev'], answer: 0
    },

    /* Təbiət */
    {
      topic: 'Azərbaycan təbiəti',
      q: 'Hirkan meşələrində və Zəngəzurda rast gəlinən nadir iri pişik hansıdır?',
      options: ['Fars bəbiri', 'Qəhvəyi ayı', 'Qızıl tülkü', 'Vaşaq'], answer: 0
    },
    {
      topic: 'Azərbaycan təbiəti',
      q: 'Kürü üçün ən dəyərli Xəzər balıqlarından biri hansıdır?',
      options: ['Ağ nərə (beluga)', 'Kütüm', 'Qızılbalıq', 'Sardina'], answer: 0
    },
    {
      topic: 'Azərbaycan təbiəti',
      q: 'Azərbaycanın dağlıq ərazilərində yaşayan və markalarda təsvir edilən yırtıcı quş hansıdır?',
      options: ['Qızıl qartal', 'Flaminqo', 'Leylək', 'Qara quzğun'], answer: 0
    },
    {
      topic: 'Azərbaycan təbiəti',
      q: 'Şirvan Milli Parkı hansı heyvanın əsas yaşayış yeridir?',
      options: ['Ceyranın', 'Qızıl qartalın', 'Fars bəbiri', 'Ağ nərənin'], answer: 0
    },
    {
      topic: 'Azərbaycan təbiəti',
      q: 'Naxçıvanda yaşayan yabanı dağ qoçu növü hansıdır?',
      options: ['Muflon', 'Maral', 'Dağ keçisi', 'Qaban'], answer: 0
    }
  ];

  var index = 0;
  var score = 0;
  var sessionCorrect = 0;
  var locked = false;

  // Use the site i18n engine so every dynamically generated string follows
  // the active language just like the SSR-translated markup above.
  function qt(text) {
    if (window.SkyI18n && typeof window.SkyI18n.tr === 'function') {
      return window.SkyI18n.tr(text, undefined, 'az');
    }
    return text;
  }

  // Rotate the four options by question index so the right answer is not
  // always in the same place. data-option-index keeps the source position
  // available for the end-to-end checks.
  function optionShift() {
    return index % 4;
  }

  function renderQuestion() {
    var item = questions[index];
    var shift = optionShift();
    qNum.textContent = String(index + 1);
    qTotal.textContent = String(questions.length);
    progress.style.width = ((index + 1) / questions.length * 100) + '%';
    topicEl.textContent = qt(item.topic);
    questionEl.textContent = qt(item.q);
    optionsEl.innerHTML = '';
    for (var j = 0; j < item.options.length; j++) {
      var sourceIndex = (j + shift) % item.options.length;
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'quiz-option';
      btn.dataset.optionIndex = String(sourceIndex);
      btn.textContent = qt(item.options[sourceIndex]);
      btn.addEventListener('click', (function (displayIndex) {
        return function () { choose(displayIndex); };
      })(j));
      optionsEl.appendChild(btn);
    }
    feedback.hidden = true;
    answerWrap.hidden = true;
    nextBtn.hidden = true;
    locked = false;
  }

  function choose(i) {
    if (locked) return;
    locked = true;
    var item = questions[index];
    var correctDisplay = (item.answer - optionShift() + item.options.length) % item.options.length;
    var correct = i === correctDisplay;
    if (correct) {
      score += 4;
      sessionCorrect += 1;
      qState.totalCorrect += 1;
      qSave(qState);
      renderQuizStatus();
      playSound(true);
      feedbackTxt.textContent = qt('Doğru cavab!');
      answerWrap.hidden = true;
    } else {
      playSound(false);
      feedbackTxt.textContent = qt('Yanlış cavab.');
      answerEl.textContent = qt(item.options[item.answer]);
      answerWrap.hidden = false;
    }
    feedback.hidden = false;
    Array.prototype.forEach.call(optionsEl.children, function (btn, j) {
      btn.disabled = true;
      btn.classList.add(j === correctDisplay ? 'is-correct' : (j === i ? 'is-wrong' : 'is-muted'));
    });
    if (!correct && !quizAuth.loggedIn) {
      qMarkGuestPlayed();
      qState.gamesPlayed += 1;
      qSave(qState);
      nextBtn.hidden = true;
      play.hidden = true;
      gateMsgEl.textContent = qt('Viktorinada səhv cavab verdin. Davam etmək üçün saytda qeydiyyatdan keç.');
      gateTitleEl.textContent = qt('Qeydiyyat tələb olunur');
      gateRegister.href = quizAuth.registerUrl;
      gateLogin.href = quizAuth.loginUrl;
      gateEl.hidden = false;
      return;
    }
    nextBtn.textContent = qt(index === questions.length - 1 ? 'Nəticəni gör' : 'Növbəti sual');
    nextBtn.hidden = false;
  }

  function showResult() {
    play.hidden = true;
    result.hidden = false;
    scoreEl.textContent = String(score);
    resultMsg.textContent = qt(score >= 80 ? 'Əla nəticə!' : (score >= 40 ? 'Yaxşı başlanğıc!' : 'Yenidən cəhd edin!'));
    if (score > qState.bestScore) qState.bestScore = score;
    qState.gamesPlayed += 1;
    if (!quizAuth.loggedIn) qMarkGuestPlayed();
    qSave(qState);
    renderQuizStatus();
  }

  function reset() {
    index = 0;
    score = 0;
    sessionCorrect = 0;
    locked = false;
    play.hidden = false;
    result.hidden = true;
    hideQuizGate();
    scoreEl.textContent = '0';
    renderQuizStatus();
    renderQuestion();
  }

  function openQuiz() {
    qState = qLoad();
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    closeBtn.focus();
    if (!quizAuth.loggedIn && qGuestPlayed()) {
      gateTitleEl.textContent = qt('Qeydiyyat tələb olunur');
      gateMsgEl.textContent = qt('Sən artıq bir dəfə oynadın. Davam etmək üçün saytda qeydiyyatdan keç.');
      showQuizGate();
      renderQuizStatus();
      return;
    }
    reset();
  }

  function closeQuiz() {
    overlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  openBtn.addEventListener('click', openQuiz);
  closeBtn.addEventListener('click', closeQuiz);
  restartBtn.addEventListener('click', reset);
  nextBtn.addEventListener('click', function () {
    if (index === questions.length - 1) showResult();
    else { index += 1; renderQuestion(); }
  });
  overlay.addEventListener('click', function (e) { if (e.target === overlay) closeQuiz(); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && overlay.classList.contains('open')) closeQuiz();
  });
})();

<?php $riddleUser = currentUser(); ?>
var riddleAuth = <?= json_encode([
  'loggedIn' => isLoggedIn(),
  'userId' => (int) ($_SESSION['user_id'] ?? 0),
  'name' => (string) ($riddleUser['fullname'] ?? ''),
  'registerUrl' => SITE_URL . '/auth/register.php',
  'loginUrl' => SITE_URL . '/auth/login.php',
  'boardUrl' => SITE_URL . '/api/riddles-scores.php',
  'csrf' => csrf_token()
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

(function () {
  var overlay    = document.getElementById('riddleOverlay');
  var openBtn    = document.getElementById('riddleDemoBtn');
  if (!overlay || !openBtn) return;

  var STORE = 'skyweb_riddles_v1';
  var audioCtx = null;
  function playSound(ok) {
    try {
      var Ctx = window.AudioContext || window.webkitAudioContext;
      if (!Ctx) return;
      if (!audioCtx) audioCtx = new Ctx();
      if (audioCtx.state === 'suspended') audioCtx.resume();
      var now = audioCtx.currentTime;
      function tone(freq, start, dur, type, vol, slide) {
        var o = audioCtx.createOscillator();
        var g = audioCtx.createGain();
        o.type = type;
        o.frequency.setValueAtTime(freq, now + start);
        if (slide) o.frequency.exponentialRampToValueAtTime(Math.max(slide, 0.0001), now + start + dur);
        g.gain.setValueAtTime(0.0001, now + start);
        g.gain.exponentialRampToValueAtTime(vol, now + start + 0.03);
        g.gain.exponentialRampToValueAtTime(0.0001, now + start + dur);
        o.connect(g); g.connect(audioCtx.destination);
        o.start(now + start); o.stop(now + start + dur + 0.02);
      }
      if (ok) {
        // Happy ascending major arpeggio with a soft sparkle
        tone(523.25, 0,    0.22, 'sine', 0.14, 523.25); // C5
        tone(659.25, 0.08, 0.24, 'sine', 0.15, 659.25); // E5
        tone(783.99, 0.16, 0.32, 'sine', 0.16, 783.99); // G5
        tone(1046.5, 0.24, 0.38, 'sine', 0.07, 1046.5); // C6 sparkle
      } else {
        // Gentle disappointed descending tones
        tone(392.00, 0,    0.34, 'triangle', 0.13, 349.23); // G4 -> F4
        tone(311.13, 0.12, 0.38, 'triangle', 0.11, 261.63); // Eb4 -> C4
        tone(220.00, 0.24, 0.45, 'sine',     0.09, 196.00); // A3 -> G3 soft tail
      }
    } catch (e) { /* audio optional */ }
  }
  var ratingEl   = document.getElementById('riddleRating');
  var streakEl   = document.getElementById('riddleStreak');
  var todayEl    = document.getElementById('riddleToday');
  var rankEl     = document.getElementById('riddleRank');
  var goalTextEl = document.getElementById('riddleGoalText');
  var goalBarEl  = document.getElementById('riddleGoalBar');
  var recordsEl  = document.getElementById('riddleRecords');
  var recordsListEl = document.getElementById('riddleRecordsList');
  var numEl      = document.getElementById('riddleNum');
  var roundEl    = document.getElementById('riddleRound');
  var textEl     = document.getElementById('riddleText');
  var optionsEl  = document.getElementById('riddleOptions');
  var hintEl     = document.getElementById('riddleHint');
  var hintBtn    = document.getElementById('riddleHintBtn');
  var skipBtn    = document.getElementById('riddleSkipBtn');
  var nextBtn    = document.getElementById('riddleNextBtn');
  var feedbackEl = document.getElementById('riddleFeedback');
  var feedbackTxt = document.getElementById('riddleFeedbackText');
  var feedbackAnswer = document.getElementById('riddleFeedbackAnswer');
  var toastEl    = document.getElementById('riddleToast');
  var closeBtn   = document.getElementById('riddleClose');
  var cardEl     = document.querySelector('.riddle-card');
  var statsEl    = document.querySelector('.riddle-stats');
  var limitsEl   = document.getElementById('riddleLimits');
  var goalWrapEl = document.querySelector('.riddle-goal');
  var hintLeftEl = document.getElementById('riddleHintLeft');
  var skipLeftEl = document.getElementById('riddleSkipLeft');
  var tzEl       = document.getElementById('riddleTz');
  var boardEl     = document.getElementById('riddleBoard');
  var boardListEl = document.getElementById('riddleBoardList');
  var boardRankEl = document.getElementById('riddleMyRank');
  var boardNoteEl = document.getElementById('riddleBoardNote');
  var blockedEl  = document.getElementById('riddleBlocked');
  var blockedAnswerEl = document.getElementById('riddleBlockedAnswer');
  var waitEl     = document.getElementById('riddleWait');
  var gateEl     = document.getElementById('riddleGate');
  var registerLink = document.getElementById('riddleRegisterLink');
  var loginLink  = document.getElementById('riddleLoginLink');
  var blockedClose = document.getElementById('riddleBlockedClose');

  var HINT_LIMIT = 2;
  var SKIP_LIMIT = 3;
  var GOAL_LIMIT = 5;
  var GUEST_FLAG = 'skyweb_riddle_guest_played';
  var GUEST_COOKIE = 'skyweb_riddle_guest=1';
  var countdownTimer = null;
  var boardTimer = null;
  var dayTimer = null;
  var guestSessionActive = false;

  // Well-known Azerbaijani folk riddles, checked against folklore collections
  // (Baku "Tapmacalar", azerbaijans.com and the Novruz riddle list).
  var riddles = [
    {
      r: 'Bir sinidə iki toyuq, biri isti, biri soyuq.',
      o: ['Gün və ulduz', 'Ay və Gün', 'Qaranquş və sərçə', 'Şam və tonqal'], a: 1,
      h: 'Biri gündüz isidir, biri gecə parlayır.'
    },
    {
      r: 'Aşmaz-uşmaz, yerə düşsə, beli sınmaz.',
      o: ['Yarpaq', 'Qələm', 'Stəkan', 'Daş'], a: 0,
      h: 'Payızda ağacdan tökülür.'
    },
    {
      r: 'Çəpər üstə çal xoruz.',
      o: ['Xoruz', 'Balqabaq', 'Pomidor', 'Qarpız'], a: 1,
      h: 'Bağçada yetişir, rəngi narıncıdır.'
    },
    {
      r: 'O hansı heyvandı anadan saqqallı doğular?',
      o: ['Qoyun', 'Pişik', 'Keçi', 'İt'], a: 2,
      h: 'Bu heyvanın saqqalı var, südü də var.'
    },
    {
      r: 'Bir quşum var, düz uçar.',
      o: ['Güllə', 'Göyərçin', 'Qartal', 'Ox'], a: 0,
      h: 'Atılır, havada düz gedir.'
    },
    {
      r: 'Ağ sinidə ağ təpə.',
      o: ['Çörək', 'Plov', 'Qar', 'Süd'], a: 1,
      h: 'Boşqabda düyü yığını.'
    },
    {
      r: 'Kəmərim qırmızı, yaşıl köynəyəm. Novruz bayramında hər bir evdəyəm.',
      o: ['Şam', 'Səməni', 'Yumurta', 'Qoğal'], a: 1,
      h: 'Novruzda cücərdilən taxıllar.'
    },
    {
      r: 'Harayçıyam, hayçıyam, bahar sözlü payçıyam; sinəm ağ, belim qara, quyruqdan da qayçıyam.',
      o: ['Leylək', 'Sərçə', 'Qaranquş', 'Kəklik'], a: 2,
      h: 'Baharda gəlir, quyruğu iki uca ayrılır.'
    },
    {
      r: 'Alov deyil, fanaram; ayı, günü sanaram. Novruzun xonçasında hər bir ada yanaram.',
      o: ['Şam', 'Fənər', 'Tonqal', 'Od'], a: 0,
      h: 'Xonçada yanan kiçik işıq.'
    },
    {
      r: 'Özüm isti, rəngim al, ağrı-dərdi məndə sal.',
      o: ['Soba', 'Tonqal', 'Şam', 'Kürə'], a: 1,
      h: 'Novruzda od üstündə qurulan şey.'
    },
    {
      r: 'Qapısız günbəzəm, üzüm ağ, içim sarı. Novruzda bəzənərəm, qırmızı, yaşıl, sarı.',
      o: ['Yumurta', 'Qoz', 'Fındıq', 'Şəkərbura'], a: 0,
      h: 'Qabığı ağ, sarısı var, bayramda rənglənir.'
    },
    {
      r: 'Ağızı bağlı, bizə tanış, ayparadı, üstü naxış.',
      o: ['Qoğal', 'Şəkərbura', 'Paxlava', 'Çörək'], a: 1,
      h: 'Şəkərli, ay formasında Novruz şirniyyatı.'
    },
    {
      r: 'Deyirmi, tağalağam, qat-qat paltar geyərəm.',
      o: ['Paxlava', 'Qoğal', 'Şəkərbura', 'Fəsəli'], a: 1,
      h: 'Qat-qat xəmirdən hazırlanır.'
    },
    {
      r: 'Ağ qəsirin içində köynəyi yaşıl yatıb.',
      o: ['Püstə', 'Fındıq', 'Qoz', 'Badam'], a: 0,
      h: 'Ağ qabıq, yaşıl ləpə.'
    },
    {
      r: 'O nədir ki, səhər dörd, günorta iki, axşam üç ayaqlı olur?',
      o: ['İnsan', 'At', 'Kürsü', 'Qaranquş'], a: 0,
      h: 'Beşikdə, ayaq üstə və əsa ilə.'
    }
  ];

  var index = 0;
  var score = 0;
  var locked = false;
  var toastTimer = null;

  function qt(text) {
    if (window.SkyI18n && typeof window.SkyI18n.tr === 'function') {
      return window.SkyI18n.tr(text, undefined, 'az');
    }
    return text;
  }

  function dayKey(date) {
    var d = date || new Date();
    return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
  }

  function wasYesterday(key) {
    if (!key) return false;
    var d = new Date();
    d.setDate(d.getDate() - 1);
    return dayKey(d) === key;
  }

  // Guest progress stays on this device; registered players get their own store.
  function storeKey() {
    return riddleAuth.loggedIn && riddleAuth.userId ? STORE + '_u' + riddleAuth.userId : STORE;
  }

  function guestPlayed() {
    try {
      if (localStorage.getItem(GUEST_FLAG) === '1') return true;
    } catch (e) { /* private mode */ }
    return document.cookie.split(';').some(function (part) { return part.trim() === GUEST_COOKIE; });
  }

  function markGuestPlayed() {
    if (riddleAuth.loggedIn) return;
    try { localStorage.setItem(GUEST_FLAG, '1'); } catch (e) { /* private mode */ }
    document.cookie = GUEST_COOKIE + '; path=/; max-age=31536000; SameSite=Lax';
  }

  function freshOrder() {
    var order = riddles.map(function (_, i) { return i; });
    for (var i = order.length - 1; i > 0; i--) {
      var j = Math.floor(Math.random() * (i + 1));
      var tmp = order[i]; order[i] = order[j]; order[j] = tmp;
    }
    return order;
  }

  function defaultState() {
    var today = dayKey();
    return {
      order: freshOrder(), cursor: 0, round: 1,
      score: 0, total: 0, best: 0, solved: 0,
      streak: 0, lastDate: '', today: today,
      todaySolved: 0, goalDone: '', records: [],
      hintLeft: HINT_LIMIT, skipLeft: SKIP_LIMIT,
      limitsDate: today, blockedDate: ''
    };
  }

  function loadState() {
    try {
      var raw = localStorage.getItem(storeKey());
      if (!raw) return defaultState();
      var s = JSON.parse(raw);
      if (!s || !Array.isArray(s.order) || typeof s.cursor !== 'number') return defaultState();
      s.order = s.order.filter(function (i) { return typeof i === 'number' && i >= 0 && i < riddles.length; });
      if (!s.order.length) s.order = freshOrder();
      if (s.cursor < 0 || s.cursor > s.order.length) s.cursor = 0;
      ['score', 'total', 'best', 'solved', 'streak', 'todaySolved'].forEach(function (key) {
        s[key] = Math.max(0, Number(s[key]) || 0);
      });
      s.round = Math.max(1, Number(s.round) || 1);
      s.today = s.today || dayKey();
      s.lastDate = s.lastDate || '';
      s.goalDone = s.goalDone || '';
      s.records = Array.isArray(s.records) ? s.records.slice(0, 5) : [];
      s.hintLeft = s.hintLeft === undefined ? HINT_LIMIT : Math.min(HINT_LIMIT, Math.max(0, Number(s.hintLeft) || 0));
      s.skipLeft = s.skipLeft === undefined ? SKIP_LIMIT : Math.min(SKIP_LIMIT, Math.max(0, Number(s.skipLeft) || 0));
      s.limitsDate = s.limitsDate || dayKey();
      s.blockedDate = s.blockedDate || '';
      return s;
    } catch (e) {
      return defaultState();
    }
  }

  var state = loadState();

  function saveState() {
    try { localStorage.setItem(storeKey(), JSON.stringify(state)); } catch (e) { /* private mode */ }
  }

  function ensureCycle() {
    if (state.cursor < state.order.length) return;
    state.order = freshOrder();
    state.cursor = 0;
    state.round += 1;
  }

  function addPoints(n) {
    var wasRecord = state.score > 0 && state.score >= state.best;
    state.score += n;
    state.total += n;
    if (state.score > state.best) {
      state.best = state.score;
      return !wasRecord;
    }
    return false;
  }

  function levelInfo(total) {
    if (total >= 2000) return { level: 5, title: 'Tapmaca əfsanəsi' };
    if (total >= 1000) return { level: 4, title: 'Reytinq lideri' };
    if (total >= 400) return { level: 3, title: 'Tapmaca ustası' };
    if (total >= 150) return { level: 2, title: 'Maraqlı' };
    return { level: 1, title: 'Yeni başlayan' };
  }

  function rankTitle() {
    var info = levelInfo(state.total);
    return qt('Səviyyə') + ' ' + info.level + ' · ' + qt(info.title);
  }

  function showToast(message) {
    toastEl.textContent = message;
    toastEl.hidden = false;
    if (toastTimer) clearTimeout(toastTimer);
    toastTimer = setTimeout(function () { toastEl.hidden = true; }, 2600);
  }

  function clearCountdown() {
    if (countdownTimer) clearInterval(countdownTimer);
    countdownTimer = null;
  }

  function togglePlayUI(show) {
    [cardEl, statsEl, limitsEl, goalWrapEl, recordsEl, rankEl, boardEl].forEach(function (el) {
      if (el) el.hidden = !show;
    });
    if (!show) toastEl.hidden = true;
    blockedEl.hidden = true;
    gateEl.hidden = true;
    if (!show) clearCountdown();
  }

  function renderTz() {
    var tz = 'UTC';
    try { tz = Intl.DateTimeFormat().resolvedOptions().timeZone || 'UTC'; } catch (e) { /* old browser */ }
    tzEl.textContent = qt('Yerli vaxt') + ': ' + tz;
  }

  function updateCountdown() {
    if (state.blockedDate && state.blockedDate !== dayKey()) {
      clearCountdown();
      var daily = refreshDay();
      renderRiddle();
      if (daily) showToast(qt('Günlük giriş +25'));
      return;
    }
    var now = new Date();
    var next = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1);
    var diff = Math.max(0, next - now);
    var hours = Math.floor(diff / 3600000);
    var minutes = Math.floor((diff % 3600000) / 60000);
    waitEl.textContent = String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0')
      + ' ' + qt('sonra davam edə bilərsən');
  }

  function renderBlocked(answer) {
    togglePlayUI(false);
    blockedEl.hidden = false;
    blockedAnswerEl.hidden = !answer;
    blockedAnswerEl.textContent = answer ? qt('Doğru cavab:') + ' ' + answer : '';
    updateCountdown();
    countdownTimer = setInterval(updateCountdown, 30000);
  }

  function renderGate() {
    togglePlayUI(false);
    gateEl.hidden = false;
    registerLink.href = riddleAuth.registerUrl;
    loginLink.href = riddleAuth.loginUrl;
  }

  function renderBoard(data) {
    var rows = data && Array.isArray(data.top) ? data.top : [];
    boardListEl.innerHTML = '';
    rows.slice(0, 5).forEach(function (row, i) {
      var li = document.createElement('li');
      if (row.is_me) li.className = 'me';
      var name = document.createElement('span');
      name.textContent = String(i + 1) + '. ' + (row.name || '—');
      var score = document.createElement('b');
      score.textContent = String(row.score || 0);
      li.appendChild(name);
      li.appendChild(score);
      boardListEl.appendChild(li);
    });
    boardRankEl.textContent = data && data.me ? qt('Sənin sıran') + ' #' + data.me.rank : '';
    boardNoteEl.hidden = riddleAuth.loggedIn;
    if (!riddleAuth.loggedIn) boardNoteEl.textContent = qt('Cədvəldə yer almaq üçün qeydiyyatdan keç.');
  }

  function fetchBoard() {
    if (!riddleAuth.boardUrl) return;
    fetch(riddleAuth.boardUrl + '?action=top', { credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(renderBoard)
      .catch(function () { /* leaderboard is optional */ });
  }

  function saveBoardScore() {
    if (!riddleAuth.loggedIn || !riddleAuth.boardUrl) return;
    if (boardTimer) clearTimeout(boardTimer);
    boardTimer = setTimeout(function () {
      fetch(riddleAuth.boardUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': riddleAuth.csrf },
        body: JSON.stringify({ action: 'save', score: state.total })
      }).then(function (r) { return r.json(); })
        .then(function (data) { if (data && data.top) renderBoard(data); })
        .catch(function () { /* leaderboard is optional */ });
    }, 500);
  }

  function isBlocked() {
    return state.blockedDate === dayKey();
  }

  function resetDaily() {
    var today = dayKey();
    state.today = today;
    state.todaySolved = 0;
    state.goalDone = '';
    state.hintLeft = HINT_LIMIT;
    state.skipLeft = SKIP_LIMIT;
    state.limitsDate = today;
    if (state.blockedDate && state.blockedDate !== today) state.blockedDate = '';
  }

  // Called on open and before every move, so a device crossing midnight is
  // unblocked immediately even if the modal stayed open all night.
  function refreshDay() {
    var today = dayKey();
    var changed = state.today !== today || state.limitsDate !== today
      || (state.blockedDate && state.blockedDate !== today);
    if (!changed) return false;
    var daily = applyDaily();
    resetDaily();
    renderStats();
    saveState();
    return daily;
  }

  function blockToday(answer) {
    state.blockedDate = dayKey();
    recordRun();
    saveState();
    renderBlocked(answer);
    saveBoardScore();
    showToast(qt('Bugünkü oyun bitdi'));
  }

  function renderStats() {
    ratingEl.textContent = String(state.total);
    streakEl.textContent = String(state.streak);
    todayEl.textContent = String(state.todaySolved);
    rankEl.textContent = rankTitle();
    goalTextEl.textContent = qt('Bugünkü məqsəd: 5 tapmaca');
    goalBarEl.style.width = Math.min(state.todaySolved, GOAL_LIMIT) / GOAL_LIMIT * 100 + '%';
    hintLeftEl.textContent = String(state.hintLeft);
    skipLeftEl.textContent = String(state.skipLeft);
    hintBtn.disabled = state.hintLeft <= 0 || locked || !hintEl.hidden;
    skipBtn.disabled = state.skipLeft <= 0 || locked;
    hintBtn.textContent = qt(state.hintLeft <= 0 ? 'İpucu limiti bitdi'
      : (!hintEl.hidden ? 'İpucu' : 'İpucu göstər'));
    skipBtn.textContent = qt(state.skipLeft <= 0 ? 'Keç limiti bitdi' : 'Keç');
    recordsEl.hidden = !state.records.length;
    recordsListEl.textContent = state.records.slice(0, 3).map(function (row) { return row.score; }).join(' · ');
  }

  function renderRiddle() {
    if (isBlocked()) { renderBlocked(); return; }
    if (!riddleAuth.loggedIn && guestPlayed() && !guestSessionActive) { renderGate(); return; }
    togglePlayUI(true);
    ensureCycle();
    var item = riddles[state.order[state.cursor]];
    numEl.textContent = String(state.cursor + 1);
    roundEl.textContent = String(state.round);
    textEl.textContent = qt(item.r);
    optionsEl.innerHTML = '';
    item.o.forEach(function (option, i) {
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'riddle-option';
      btn.dataset.correct = String(i === item.a);
      btn.textContent = qt(option);
      btn.addEventListener('click', (function (displayIndex) {
        return function () { choose(displayIndex); };
      })(i));
      optionsEl.appendChild(btn);
    });
    hintEl.textContent = qt(item.h);
    hintEl.hidden = true;
    hintBtn.hidden = false;
    skipBtn.hidden = false;
    nextBtn.hidden = true;
    feedbackEl.hidden = true;
    feedbackTxt.textContent = '';
    feedbackAnswer.textContent = '';
    feedbackAnswer.hidden = true;
    locked = false;
    renderStats();
    saveState();
  }

  function choose(i) {
    if (locked || isBlocked()) return;
    if (refreshDay()) {
      renderRiddle();
      showToast(qt('Günlük giriş +25'));
      return;
    }
    locked = true;
    var item = riddles[state.order[state.cursor]];
    var correct = i === item.a;
    var newRecord = false;

    if (correct) {
      newRecord = addPoints(10);
      state.solved += 1;
      state.todaySolved += 1;
      playSound(true);
      feedbackTxt.textContent = qt('Doğru cavab! +10');
      feedbackAnswer.hidden = true;
      if (state.todaySolved >= GOAL_LIMIT && state.goalDone !== dayKey()) {
        state.goalDone = dayKey();
        addPoints(50);
        showToast(qt('Günlük məqsəd tamamlandı +50'));
      }
    } else {
      playSound(false);
      var answerText = qt(item.o[item.a]);
      feedbackTxt.textContent = qt('Yanlış! Doğru cavab:');
      feedbackAnswer.textContent = answerText;
      feedbackAnswer.hidden = false;
      if (state.hintLeft <= 0 && state.skipLeft <= 0) {
        feedbackEl.hidden = true;
        hintBtn.hidden = true;
        skipBtn.hidden = true;
        nextBtn.hidden = true;
        renderStats();
        blockToday(answerText);
        return;
      }
    }

    feedbackEl.hidden = false;
    Array.prototype.forEach.call(optionsEl.children, function (btn, j) {
      btn.disabled = true;
      btn.classList.add(j === item.a ? 'is-correct' : (j === i ? 'is-wrong' : 'is-muted'));
    });
    hintBtn.hidden = true;
    skipBtn.hidden = true;
    nextBtn.hidden = false;
    renderStats();
    saveState();
    saveBoardScore();
    if (newRecord) showToast(qt('Yeni rekord!'));
  }

  function nextRiddle() {
    state.cursor += 1;
    renderRiddle();
  }

  function applyDaily() {
    var today = dayKey();
    if (state.lastDate === today) return false;
    state.streak = wasYesterday(state.lastDate) ? state.streak + 1 : 1;
    state.lastDate = today;
    resetDaily();
    addPoints(25);
    return true;
  }

  function recordRun() {
    if (state.score <= 0) return;
    var today = dayKey();
    var last = state.records[0];
    if (last && last.score === state.score && last.date === today) return;
    state.records.push({ score: state.score, date: today });
    state.records.sort(function (a, b) { return b.score - a.score; });
    state.records = state.records.slice(0, 5);
  }

  function openRiddle() {
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    closeBtn.focus();

    if (!riddleAuth.loggedIn && guestPlayed()) {
      renderGate();
      saveState();
      fetchBoard();
      return;
    }
    if (isBlocked()) {
      renderBlocked();
      saveState();
      fetchBoard();
      return;
    }

    var resumed = state.cursor > 0 || state.score > 0 || state.solved > 0 || state.round > 1;
    var daily = applyDaily();
    refreshDay();
    if (!riddleAuth.loggedIn) {
      guestSessionActive = true;
      markGuestPlayed();
    }
    renderRiddle();
    saveState();
    fetchBoard();
    if (daily) showToast(qt('Günlük giriş +25'));
    else if (resumed) showToast(qt('Qaldığın yerdən davam et'));
  }

  function closeRiddle() {
    // If the current riddle was already answered, come back to the next one —
    // but never advance when the day is blocked or the registration gate is shown.
    if (locked && !isBlocked() && gateEl.hidden) state.cursor += 1;
    guestSessionActive = false;
    clearCountdown();
    recordRun();
    saveState();
    overlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  function useHint() {
    if (locked || isBlocked()) return;
    if (refreshDay()) { renderRiddle(); showToast(qt('Günlük giriş +25')); return; }
    if (state.hintLeft <= 0) { showToast(qt('İpucu limiti bitdi')); return; }
    state.hintLeft -= 1;
    hintEl.hidden = false;
    saveState();
    renderStats();
  }

  function useSkip() {
    if (locked || isBlocked()) return;
    if (refreshDay()) { renderRiddle(); showToast(qt('Günlük giriş +25')); return; }
    if (state.skipLeft <= 0) { showToast(qt('Keç limiti bitdi')); return; }
    state.skipLeft -= 1;
    saveState();
    nextRiddle();
  }

  openBtn.addEventListener('click', openRiddle);
  closeBtn.addEventListener('click', closeRiddle);
  blockedClose.addEventListener('click', closeRiddle);
  nextBtn.addEventListener('click', nextRiddle);
  skipBtn.addEventListener('click', useSkip);
  hintBtn.addEventListener('click', useHint);
  overlay.addEventListener('click', function (e) { if (e.target === overlay) closeRiddle(); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && overlay.classList.contains('open')) closeRiddle();
  });

  renderTz();
  dayTimer = setInterval(function () {
    if (!overlay.classList.contains('open')) return;
    var today = dayKey();
    if (state.today === today && state.limitsDate === today
      && (!state.blockedDate || state.blockedDate === today)) return;
    var daily = refreshDay();
    renderRiddle();
    if (daily) showToast(qt('Günlük giriş +25'));
  }, 60000);
})();


(function () {
  var overlay = document.getElementById('memoryOverlay');
  var openBtn = document.getElementById('memoryDemoBtn');
  if (!overlay || !openBtn) return;

  var gridEl = document.getElementById('memoryGrid');
  var movesEl = document.getElementById('memoryMoves');
  var timeEl = document.getElementById('memoryTime');
  var pairsEl = document.getElementById('memoryPairs');
  var bestEl = document.getElementById('memoryBest');
  var levelEl = document.getElementById('memoryLevel');
  var winEl = document.getElementById('memoryWin');
  var winTitleEl = document.getElementById('memoryWinTitle');
  var winMsgEl = document.getElementById('memoryWinMsg');
  var restartBtn = document.getElementById('memoryRestart');
  var closeBtn = document.getElementById('memoryClose');

  var STORE = 'skyweb_memory_v1';
  var ICONS = [
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l2.5 5 5.5.8-4 3.9.9 5.5-4.9-2.6-4.9 2.6.9-5.5-4-3.9 5.5-.8L12 3z"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L4.5 13H11l-1 9 9.5-11H13l1-9z"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4.5v11L12 22l-8-4.5v-11L12 2z"/><path d="M12 2v20M4 6.5l8 4.5 8-4.5"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M4.22 4.22l2.12 2.12M17.66 17.66l2.12 2.12M2 12h3M19 12h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M4 12h16M4 17h10"/><circle cx="18" cy="17" r="2"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18M3 12h18"/><rect x="5" y="5" width="14" height="14" rx="3"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-4.4 7-10a7 7 0 10-14 0c0 5.6 7 10 7 10z"/><circle cx="12" cy="11" r="2.5"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 11-3-6.7"/><path d="M21 3v6h-6"/></svg>'
  ];
  var audioCtx = null;
  var timer = null;
  var seconds = 0;
  var moves = 0;
  var found = 0;
  var lock = false;
  var first = null;
  var second = null;
  var started = false;

  function qt(text) {
    if (window.SkyI18n && typeof window.SkyI18n.tr === 'function') {
      return window.SkyI18n.tr(text, undefined, 'az');
    }
    return text;
  }

  function playSound(kind) {
    try {
      var Ctx = window.AudioContext || window.webkitAudioContext;
      if (!Ctx) return;
      if (!audioCtx) audioCtx = new Ctx();
      if (audioCtx.state === 'suspended') audioCtx.resume();
      var now = audioCtx.currentTime;
      function tone(freq, start, dur, type, vol, slide) {
        var o = audioCtx.createOscillator();
        var g = audioCtx.createGain();
        o.type = type;
        o.frequency.setValueAtTime(freq, now + start);
        if (slide) o.frequency.exponentialRampToValueAtTime(Math.max(slide, 0.0001), now + start + dur);
        g.gain.setValueAtTime(0.0001, now + start);
        g.gain.exponentialRampToValueAtTime(vol, now + start + 0.02);
        g.gain.exponentialRampToValueAtTime(0.0001, now + start + dur);
        o.connect(g); g.connect(audioCtx.destination);
        o.start(now + start); o.stop(now + start + dur + 0.02);
      }
      if (kind === 'flip') {
        tone(440, 0, 0.07, 'sine', 0.06, 520);
      } else if (kind === 'match') {
        tone(523.25, 0, 0.18, 'sine', 0.13, 523.25);
        tone(659.25, 0.07, 0.2, 'sine', 0.14, 659.25);
        tone(783.99, 0.14, 0.28, 'sine', 0.12, 783.99);
      } else if (kind === 'wrong') {
        tone(330, 0, 0.22, 'triangle', 0.1, 220);
        tone(220, 0.08, 0.24, 'triangle', 0.07, 165);
      } else if (kind === 'win') {
        tone(523.25, 0, 0.2, 'sine', 0.14, 523.25);
        tone(659.25, 0.1, 0.22, 'sine', 0.14, 659.25);
        tone(783.99, 0.2, 0.28, 'sine', 0.15, 783.99);
        tone(1046.5, 0.3, 0.45, 'sine', 0.12, 1046.5);
      }
    } catch (e) { /* audio optional */ }
  }

  function load() {
    try {
      var raw = localStorage.getItem(STORE);
      if (!raw) return { wins: 0, bestMoves: null, bestTime: null };
      var s = JSON.parse(raw);
      return {
        wins: Math.max(0, Number(s.wins) || 0),
        bestMoves: s.bestMoves == null ? null : Math.max(1, Number(s.bestMoves) || 1),
        bestTime: s.bestTime == null ? null : Math.max(1, Number(s.bestTime) || 1)
      };
    } catch (e) { return { wins: 0, bestMoves: null, bestTime: null }; }
  }
  function save(s) { try { localStorage.setItem(STORE, JSON.stringify(s)); } catch (e) {} }
  var state = load();

  function levelInfo(wins) {
    var level = Math.floor(wins / 2) + 1;
    var titles = ['Yeni başlayan', 'Diqqətli', 'Yaddaş ustası', 'Çempion', 'Əfsanə'];
    return { level: level, title: titles[Math.min(level - 1, titles.length - 1)] };
  }

  function fmtTime(sec) {
    var m = Math.floor(sec / 60);
    var s = sec % 60;
    return m + ':' + String(s).padStart(2, '0');
  }

  function updateStats() {
    movesEl.textContent = String(moves);
    timeEl.textContent = fmtTime(seconds);
    pairsEl.textContent = found + '/8';
    bestEl.textContent = state.bestMoves == null ? '—' : String(state.bestMoves);
    var info = levelInfo(state.wins);
    levelEl.textContent = qt('Səviyyə') + ' ' + info.level + ' · ' + qt(info.title) + ' · ' + qt('Qələbə') + ': ' + state.wins;
  }

  function stopTimer() { if (timer) { clearInterval(timer); timer = null; } }
  function startTimer() {
    if (started) return;
    started = true;
    timer = setInterval(function () { seconds += 1; timeEl.textContent = fmtTime(seconds); }, 1000);
  }

  function shuffle(arr) {
    for (var i = arr.length - 1; i > 0; i--) {
      var j = Math.floor(Math.random() * (i + 1));
      var t = arr[i]; arr[i] = arr[j]; arr[j] = t;
    }
    return arr;
  }

  function buildGrid() {
    gridEl.innerHTML = '';
    var deck = shuffle(ICONS.concat(ICONS).map(function (icon, idx) { return { icon: icon, id: idx }; }));
    deck.forEach(function (card, i) {
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'memory-card';
      btn.dataset.icon = card.icon;
      btn.setAttribute('aria-label', qt('Kart'));
      btn.innerHTML = '<span class="memory-card-inner"><span class="memory-face memory-front"></span><span class="memory-face memory-back" style="color:#67e8f9">' + card.icon + '</span></span>';
      btn.addEventListener('click', function () { flip(btn); });
      gridEl.appendChild(btn);
    });
  }

  function flip(card) {
    if (lock || card === first || card.classList.contains('matched') || card.classList.contains('flipped')) return;
    startTimer();
    playSound('flip');
    card.classList.add('flipped');
    if (!first) { first = card; return; }
    second = card;
    moves += 1;
    updateStats();
    lock = true;
    var isMatch = first.dataset.icon === second.dataset.icon;
    if (isMatch) {
      setTimeout(function () {
        first.classList.add('matched');
        second.classList.add('matched');
        first.disabled = true;
        second.disabled = true;
        found += 1;
        playSound('match');
        resetPick();
        updateStats();
        if (found === 8) win();
      }, 220);
    } else {
      playSound('wrong');
      setTimeout(function () {
        first.classList.remove('flipped');
        second.classList.remove('flipped');
        resetPick();
      }, 700);
    }
  }

  function resetPick() { first = null; second = null; lock = false; }

  function win() {
    stopTimer();
    state.wins += 1;
    if (state.bestMoves == null || moves < state.bestMoves) state.bestMoves = moves;
    if (state.bestTime == null || seconds < state.bestTime) state.bestTime = seconds;
    save(state);
    updateStats();
    winTitleEl.textContent = qt('Əla! Bütün cütlər tapıldı');
    winMsgEl.textContent = qt('Gediş') + ': ' + moves + ' · ' + qt('Vaxt') + ': ' + fmtTime(seconds) + ' · ' + qt('Səviyyə') + ' ' + levelInfo(state.wins).level;
    winEl.hidden = false;
    playSound('win');
  }

  function reset() {
    stopTimer();
    seconds = 0; moves = 0; found = 0; lock = false; first = null; second = null; started = false;
    winEl.hidden = true;
    buildGrid();
    updateStats();
  }

  function open() {
    state = load();
    reset();
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    closeBtn.focus();
  }
  function close() {
    stopTimer();
    overlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  openBtn.addEventListener('click', open);
  closeBtn.addEventListener('click', close);
  restartBtn.addEventListener('click', reset);
  overlay.addEventListener('click', function (e) { if (e.target === overlay) close(); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && overlay.classList.contains('open')) close(); });
})();

</script>
<script>
(function () {
  var overlay = document.getElementById('huntOverlay');
  var openBtn = document.getElementById('huntDemoBtn');
  if (!overlay || !openBtn) return;
  var arena = document.getElementById('huntArena');
  var scoreEl = document.getElementById('huntScore');
  var livesEl = document.getElementById('huntLives');
  var waveEl = document.getElementById('huntWave');
  var bestEl = document.getElementById('huntBest');
  var levelEl = document.getElementById('huntLevel');
  var msg = document.getElementById('huntMsg');
  var msgTitle = document.getElementById('huntMsgTitle');
  var msgText = document.getElementById('huntMsgText');
  var startBtn = document.getElementById('huntStart');
  var closeBtn = document.getElementById('huntClose');
  var crosshair = document.getElementById('huntCrosshair');
  var STORE = 'skyweb_hunt_v1';
  function qt(t){ if(window.SkyI18n&&typeof window.SkyI18n.tr==='function') return window.SkyI18n.tr(t,undefined,'az'); return t; }
  var SHAPES = [
    { svg:'<svg viewBox="0 0 24 24" fill="rgba(251,191,36,.18)" stroke="#fbbf24" stroke-width="1.8"><path d="M12 2l8 4.5v11L12 22l-8-4.5v-11L12 2z"/></svg>', bg:'radial-gradient(circle at 35% 30%,rgba(251,191,36,.28),rgba(245,158,11,.08) 65%)', bd:'rgba(251,191,36,.45)', gl:'0 0 14px rgba(251,191,36,.3)' },
    { svg:'<svg viewBox="0 0 24 24" fill="rgba(56,189,248,.16)" stroke="#67e8f9" stroke-width="1.8"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3"/><path d="M12 4v2M12 18v2M4 12h2M18 12h2"/></svg>', bg:'radial-gradient(circle at 35% 30%,rgba(56,189,248,.28),rgba(14,165,233,.08) 65%)', bd:'rgba(56,189,248,.45)', gl:'0 0 14px rgba(56,189,248,.3)' },
    { svg:'<svg viewBox="0 0 24 24" fill="rgba(244,114,182,.16)" stroke="#f9a8d4" stroke-width="1.8"><path d="M13 2L4.5 13H11l-1 9 9.5-11H13z"/></svg>', bg:'radial-gradient(circle at 35% 30%,rgba(244,114,182,.28),rgba(236,72,153,.08) 65%)', bd:'rgba(244,114,182,.45)', gl:'0 0 14px rgba(244,114,182,.3)' },
    { svg:'<svg viewBox="0 0 24 24" fill="rgba(167,139,250,.16)" stroke="#c4b5fd" stroke-width="1.8"><path d="M12 3l2.7 5.5 6 .9-4.3 4.2 1 6-5.4-2.9-5.4 2.9 1-6L3.3 9.4l6-.9z"/></svg>', bg:'radial-gradient(circle at 35% 30%,rgba(167,139,250,.28),rgba(139,92,246,.08) 65%)', bd:'rgba(167,139,250,.45)', gl:'0 0 14px rgba(167,139,250,.3)' }
  ];
  var BONUS_SVG = '<svg viewBox="0 0 24 24" fill="rgba(74,222,128,.22)" stroke="#4ade80" stroke-width="1.8"><path d="M20.8 8.6c0 1.5-.6 2.9-1.6 3.9L12 19.7l-7.2-7.2a5.5 5.5 0 117.8-7.8l.4.4.4-.4a5.5 5.5 0 017.4 3.9z"/></svg>';
  var audioCtx = null, raf = null, spawnTimer = null, targets = [], score = 0, lives = 3, wave = 1, hits = 0, running = false;
  function bestGet(){ try { return Math.max(0, Number(localStorage.getItem(STORE))||0); } catch(e){ return 0; } }
  function bestSet(v){ try { localStorage.setItem(STORE, String(v)); } catch(e){} }
  var best = bestGet();
  bestEl.textContent = String(best);
  function sound(kind){
    try {
      var Ctx = window.AudioContext || window.webkitAudioContext; if(!Ctx) return;
      if(!audioCtx) audioCtx = new Ctx(); if(audioCtx.state==='suspended') audioCtx.resume();
      var now = audioCtx.currentTime;
      function tone(f,s,d,t,v,slide){ var o=audioCtx.createOscillator(),g=audioCtx.createGain(); o.type=t; o.frequency.setValueAtTime(f,now+s); if(slide) o.frequency.exponentialRampToValueAtTime(Math.max(slide,0.0001),now+s+d); g.gain.setValueAtTime(0.0001,now+s); g.gain.exponentialRampToValueAtTime(v,now+s+0.01); g.gain.exponentialRampToValueAtTime(0.0001,now+s+d); o.connect(g); g.connect(audioCtx.destination); o.start(now+s); o.stop(now+s+d+0.02); }
      if(kind==='shot'){ tone(220,0,0.06,'square',0.05,120); tone(110,0.02,0.08,'triangle',0.04,80); }
      else if(kind==='hit'){ tone(660,0,0.08,'sine',0.12,880); tone(990,0.05,0.12,'sine',0.08,1320); }
      else if(kind==='miss'){ tone(180,0,0.18,'sawtooth',0.05,120); }
      else if(kind==='over'){ tone(330,0,0.18,'triangle',0.08,220); tone(220,0.12,0.28,'triangle',0.07,165); }
      else if(kind==='level'){ tone(523,0,0.1,'sine',0.1,523); tone(659,0.07,0.12,'sine',0.1,659); tone(784,0.14,0.16,'sine',0.09,784); }
    } catch(e){}
  }
  function updateHud(){ scoreEl.textContent=String(score); livesEl.textContent=String(lives); waveEl.textContent=String(wave); bestEl.textContent=String(best); levelEl.textContent=qt('Səviyyə')+' '+wave+' · '+qt('Retro rejim'); }
  function clearTargets(){ targets.forEach(function(t){ if(t.el && t.el.parentNode) t.el.parentNode.removeChild(t.el); }); targets=[]; }
  function spawn(forceBonus){
    if(!running) return;
    var r = arena.getBoundingClientRect();
    var bonus = !!forceBonus || (Math.random() < 0.12 && wave > 0);
    var size = r.width < 400 ? (bonus ? 36 : 38) : (bonus ? 42 : 44);
    var y = 18 + Math.random() * (r.height * 0.52);
    var fromLeft = Math.random() > 0.5;
    var baseSpeed = bonus ? (95 + wave * 14 + Math.random() * 45) : (55 + wave * 12 + Math.random() * 35);
    var speed = baseSpeed * (fromLeft ? 1 : -1);
    var el = document.createElement('button');
    el.type = 'button'; el.className = 'hunt-target' + (bonus ? ' bonus' : '');
    el.style.width = size+'px'; el.style.height = size+'px';
    el.style.left = (fromLeft ? -30 : r.width + 30) + 'px';
    el.style.top = y + 'px';
    if (bonus) {
      el.innerHTML = '<span class="hunt-target-body">' + BONUS_SVG + '</span>';
      el.setAttribute('aria-label', qt('Bonus can'));
    } else {
      var shape = SHAPES[Math.floor(Math.random()*SHAPES.length)];
      el.innerHTML = '<span class="hunt-target-body" style="background:' + shape.bg + ';border:1px solid ' + shape.bd + ';box-shadow:' + shape.gl + '">' + shape.svg + '</span>';
      el.setAttribute('aria-label', qt('Hədəf'));
    }
    var t = {el:el, x: fromLeft ? -30 : r.width + 30, y:y, speed:speed, size:size, dead:false, bonus:bonus};
    el.addEventListener('pointerdown', function(ev){ ev.stopPropagation(); hit(t); });
    arena.appendChild(el);
    targets.push(t);
  }
  function hit(t){
    if(!running || t.dead) return;
    t.dead = true;
    if (t.bonus) {
      lives = Math.min(lives + 1, 5);
      score += 5 * wave;
      var fx = document.createElement('div'); fx.className='hunt-float'; fx.textContent='+1 ' + qt('Həyat');
      fx.style.left=t.x+'px'; fx.style.top=t.y+'px'; arena.appendChild(fx);
      setTimeout(function(){ if(fx.parentNode) fx.parentNode.removeChild(fx); }, 900);
      sound('level');
    } else {
      hits += 1; score += 10 * wave;
      sound('hit');
      if(hits % 8 === 0){ wave += 1; sound('level'); restartSpawn(); }
    }
    t.el.classList.add('hit');
    setTimeout(function(){ if(t.el.parentNode) t.el.parentNode.removeChild(t.el); targets = targets.filter(function(x){return x!==t;}); }, 280);
    if(score > best){ best = score; bestSet(best); }
    updateHud();
  }
  function missFx(x,y){
    var fx = document.createElement('div'); fx.className='hunt-miss-fx'; fx.style.left=x+'px'; fx.style.top=y+'px'; arena.appendChild(fx);
    setTimeout(function(){ if(fx.parentNode) fx.parentNode.removeChild(fx); }, 350);
  }
  function arenaMiss(ev){
    if(!running) return;
    if(ev.target.closest && ev.target.closest('.hunt-target')) return;
    if(ev.target.closest && ev.target.closest('.hunt-msg')) return;
    var r = arena.getBoundingClientRect();
    var x = ev.clientX - r.left, y = ev.clientY - r.top;
    missFx(x,y); sound('miss');
    lives -= 1; if(lives < 0) lives = 0;
    updateHud();
    if(lives <= 0) gameOver();
  }
  function loop(ts){
    if(!running) return;
    var r = arena.getBoundingClientRect();
    for(var i=targets.length-1;i>=0;i--){
      var t = targets[i]; if(t.dead) continue;
      t.x += t.speed * 0.016;
      t.el.style.left = t.x + 'px';
      if((t.speed > 0 && t.x > r.width + 40) || (t.speed < 0 && t.x < -40)){
        if(t.el.parentNode) t.el.parentNode.removeChild(t.el);
        targets.splice(i,1);
        if (!t.bonus) {
          lives -= 1; if(lives < 0) lives = 0; updateHud();
          if(lives <= 0){ gameOver(); return; }
        }
      }
    }
    raf = requestAnimationFrame(loop);
  }
  var bonusTimer = null;
  function restartSpawn(){ if(spawnTimer) clearInterval(spawnTimer); var ms = Math.max(520, 1100 - wave * 80); spawnTimer = setInterval(function(){ spawn(false); }, ms); if(bonusTimer) clearInterval(bonusTimer); bonusTimer = setInterval(function(){ if(running && Math.random()<0.55) spawn(true); }, 6500); }
  function startGame(){
    running = true; score = 0; lives = 3; wave = 1; hits = 0; clearTargets(); updateHud(); msg.hidden = true;
    restartSpawn(); spawn(); if(raf) cancelAnimationFrame(raf); raf = requestAnimationFrame(loop);
  }
  function gameOver(){
    running = false; if(raf) cancelAnimationFrame(raf); raf=null; if(spawnTimer) clearInterval(spawnTimer); spawnTimer=null; if(bonusTimer) clearInterval(bonusTimer); bonusTimer=null;
    clearTargets(); sound('over');
    if(score > best){ best = score; bestSet(best); updateHud(); }
    msgTitle.textContent = qt('Oyun bitdi');
    msgText.innerHTML = '<div>' + qt('Xal')+': '+score+' · '+qt('Dalğa')+': '+wave+' · '+qt('Rekord')+': '+best + '</div>'
      + '<div class="hunt-motto">' + qt('SkyWeb sizi salamlayır: bu sadəcə bir oyundur. Həyatda uduzmayın, davam edin!') + '</div>';
    startBtn.textContent = qt('Yenidən başla');
    msg.hidden = false;
  }
  function open(){
    best = bestGet(); updateHud(); clearTargets(); running = false;
    msgTitle.textContent = qt('Brend Ovçusu');
    msgText.innerHTML = qt('Uçan nişanlara vur, canını qoru.');
    startBtn.textContent = qt('Başla');
    msg.hidden = false;
    overlay.classList.add('open'); document.body.style.overflow='hidden';
  }
  function close(){
    running = false; if(raf) cancelAnimationFrame(raf); raf=null; if(spawnTimer) clearInterval(spawnTimer); spawnTimer=null; if(bonusTimer) clearInterval(bonusTimer); bonusTimer=null;
    crosshair.classList.remove('on'); clearTargets(); overlay.classList.remove('open'); document.body.style.overflow='';
  }
  arena.addEventListener('pointermove', function(e){ var r=arena.getBoundingClientRect(); crosshair.style.left=(e.clientX-r.left)+'px'; crosshair.style.top=(e.clientY-r.top)+'px'; crosshair.classList.add('on'); });
  arena.addEventListener('pointerleave', function(){ crosshair.classList.remove('on'); });
  openBtn.addEventListener('click', open);
  closeBtn.addEventListener('click', close);
  startBtn.addEventListener('click', function(e){ e.stopPropagation(); sound('shot'); startGame(); });
  arena.addEventListener('pointerdown', arenaMiss);
  overlay.addEventListener('click', function(e){ if(e.target===overlay) close(); });
  document.addEventListener('keydown', function(e){ if(e.key==='Escape' && overlay.classList.contains('open')) close(); });
})();
</script>
</body>
</html>
