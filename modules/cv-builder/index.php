<?php
/**
 * SKYWEB.AZ — CV Hazırlama Paneli
 * Ağıllı CV Builder, Şablonlar, PDF Export
 */
require_once __DIR__ . '/../../config/config.php';
ob_start(static function (string $html): string { return sky_translate_document_html($html); });
?>
<!DOCTYPE html>
<html lang="<?= current_lang() ?>" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="description" content="<?= e(__('cv_panel_desc', 'Skyweb.az CV Paneli — HR standartlarına uyğun peşəkar CV-lər hazırlayın. 5 şablon, PDF export, ATS-Ready format.')) ?>">
  <title><?= e(__('cv_panel_title', 'CV Hazırlama Paneli')) ?> — <?= SITE_NAME ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/sky.css?v=<?= time() ?>">
  <?= render_i18n_script() ?>
  <script src="<?= SITE_URL ?>/assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <style>
    /* ── Base ── */
    *, *::before, *::after { box-sizing: border-box; }
    .cv-page { padding-top: 80px; min-height: 100vh; padding-bottom: 4rem; }

    /* ── Breadcrumb ── */
    .breadcrumb {
      display: flex; align-items: center; gap: 0.5rem;
      font-size: 0.82rem; color: var(--text-muted); margin-bottom: 1.75rem;
      flex-wrap: wrap;
    }
    .breadcrumb a { color: var(--neon-cyan); text-decoration: none; }
    .breadcrumb a:hover { text-decoration: underline; }

    /* ── Hero Banner ── */
    .cv-hero {
      background: linear-gradient(135deg, rgba(245,158,11,0.08) 0%, rgba(249,115,22,0.04) 100%);
      border: 1px solid rgba(245,158,11,0.2);
      border-radius: var(--radius-xl);
      padding: clamp(1.5rem, 4vw, 2.5rem) clamp(1.25rem, 4vw, 2.5rem);
      margin-bottom: 2.5rem;
      position: relative; overflow: hidden;
      display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;
    }
    .cv-hero::before {
      content: ''; position: absolute; right: -60px; top: -60px;
      width: 300px; height: 300px; border-radius: 50%;
      background: radial-gradient(circle, rgba(245,158,11,0.1) 0%, transparent 70%);
      pointer-events: none;
    }
    .cv-hero-badge {
      display: inline-flex; align-items: center; gap: 0.4rem;
      background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.3);
      color: #fbbf24; border-radius: 999px; padding: 0.28rem 0.9rem;
      font-size: 0.76rem; font-weight: 600; margin-bottom: 0.65rem;
    }
    .cv-hero-title {
      font-size: clamp(1.5rem, 4vw, 2.4rem);
      font-weight: 800; line-height: 1.2; margin-bottom: 0.6rem;
    }
    .cv-hero-desc {
      color: var(--text-muted); font-size: 0.92rem;
      line-height: 1.65; max-width: 500px; margin-bottom: 1.25rem;
    }
    .cv-hero-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
    .cv-hero-emoji {
      font-size: clamp(4rem, 10vw, 7rem);
      position: relative; z-index: 1; flex-shrink: 0;
      line-height: 1;
    }

    /* ── Section label ── */
    .section-label-sm {
      font-size: 0.76rem; font-weight: 700; color: var(--neon-amber);
      text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.75rem;
    }

    /* ── Templates Grid ── */
    .templates-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 1rem; margin-bottom: 2.5rem;
    }
    .template-card {
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 16px; overflow: hidden;
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      cursor: pointer; position: relative;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }
    .template-card:hover {
      border-color: rgba(245,158,11,0.45);
      transform: translateY(-6px) scale(1.01);
      box-shadow: 0 24px 48px -12px rgba(0,0,0,0.5), 0 0 0 1px rgba(245,158,11,0.15);
    }
    .template-card.selected {
      border-color: var(--neon-amber);
      box-shadow: 0 0 0 2px rgba(245,158,11,0.35), 0 16px 40px -10px rgba(245,158,11,0.2);
    }
    .template-preview {
      height: 200px; display: flex; align-items: center;
      justify-content: center; padding: 1rem 0.75rem; position: relative; overflow: hidden;
    }
    /* Modern CV document mockup */
    .tpl-doc {
      width: 110px;
      height: 158px;
      border-radius: 6px;
      background: #fff;
      box-shadow: 0 8px 28px rgba(0,0,0,0.45), 0 2px 8px rgba(0,0,0,0.25);
      overflow: hidden;
      position: relative;
      flex-shrink: 0;
      transition: transform 0.3s ease;
    }
    .template-card:hover .tpl-doc {
      transform: rotate(-1deg) scale(1.04);
    }
    /* Second ghost doc for depth */
    .tpl-doc-ghost {
      width: 100px;
      height: 150px;
      border-radius: 6px;
      position: absolute;
      opacity: 0.35;
      transform: rotate(4deg) translateX(12px) translateY(6px);
    }
    .tpl-badge {
      position: absolute; top: 0.65rem; left: 0.65rem; z-index: 2;
      padding: 0.2rem 0.65rem; border-radius: 999px;
      font-size: 0.67rem; font-weight: 700; color: #fff;
      letter-spacing: 0.3px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    .tpl-selected-check {
      position: absolute; top: 0.65rem; right: 0.65rem; z-index: 2;
      width: 24px; height: 24px; border-radius: 50%; background: var(--neon-amber);
      display: none; align-items: center; justify-content: center;
      color: #000; font-size: 0.78rem; font-weight: 800;
      box-shadow: 0 2px 8px rgba(245,158,11,0.4);
    }
    .template-card.selected .tpl-selected-check { display: flex; }
    .template-card-body { padding: 0.85rem 1rem 1rem; }
    .template-name { font-size: 0.9rem; font-weight: 800; margin-bottom: 0.2rem; letter-spacing: -0.2px; }
    .template-desc { font-size: 0.74rem; color: var(--text-muted); margin-bottom: 0.6rem; line-height: 1.4; }
    .template-tags { display: flex; flex-wrap: wrap; gap: 0.25rem; margin-bottom: 0.75rem; }
    .tpl-tag {
      padding: 0.15rem 0.55rem; border-radius: 6px; font-size: 0.65rem; font-weight: 600;
      background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: var(--text-muted);
    }
    .tpl-select-btn {
      width: 100%; padding: 0.55rem; border-radius: 8px;
      font-size: 0.78rem; font-weight: 700; cursor: pointer; border: none; transition: var(--transition);
    }
    .tpl-select-btn-default { background: rgba(255,255,255,0.04); color: var(--text-secondary); border: 1px solid var(--sky-border); }
    .tpl-select-btn-active { background: linear-gradient(135deg, var(--neon-amber), #f97316); color: #fff; }

    /* ── CV Builder Form ── */
    .cv-builder-section {
      background: var(--sky-card); border: 1px solid var(--sky-border);
      border-radius: var(--radius-xl);
      padding: clamp(1.25rem, 4vw, 2.5rem);
      margin-bottom: 2.5rem;
    }
    .cv-builder-title { font-size: 1.25rem; font-weight: 800; margin-bottom: 0.4rem; }
    .cv-builder-desc { color: var(--text-muted); font-size: 0.88rem; margin-bottom: 1.75rem; }

    /* Tabs */
    .cv-tabs {
      display: flex; gap: 0; flex-wrap: nowrap; overflow-x: auto;
      margin-bottom: 1.75rem; border-bottom: 1px solid var(--sky-border);
      -webkit-overflow-scrolling: touch; scrollbar-width: none;
    }
    .cv-tabs::-webkit-scrollbar { display: none; }
    .cv-tab {
      padding: 0.6rem 1rem; border-radius: 8px 8px 0 0;
      font-size: 0.82rem; font-weight: 600; cursor: pointer; white-space: nowrap;
      background: transparent; border: none; color: var(--text-muted);
      transition: var(--transition); border-bottom: 2px solid transparent;
      margin-bottom: -1px; flex-shrink: 0;
    }
    .cv-tab:hover { color: var(--text-secondary); }
    .cv-tab.active { color: var(--neon-amber); border-bottom-color: var(--neon-amber); }
    .cv-tab-panel { display: none; }
    .cv-tab-panel.active { display: block; }

    /* Form Grid */
    .cv-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem; }
    .form-group { margin-bottom: 1.1rem; }
    .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.35rem; }
    .form-input, .form-select, .form-textarea {
      width: 100%; padding: 0.75rem 1rem;
      background: rgba(255,255,255,0.04); border: 1px solid var(--sky-border);
      border-radius: var(--radius-sm); color: var(--text-primary);
      font-size: 0.9rem; outline: none; font-family: var(--font-main);
      transition: var(--transition); -webkit-appearance: none; appearance: none;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
      border-color: var(--neon-amber); background: rgba(245,158,11,0.04);
    }
    .form-input::placeholder, .form-textarea::placeholder { color: var(--text-muted); }
    .form-select option { background: #0d1127; }
    .form-textarea { min-height: 95px; resize: vertical; }
    .form-full { grid-column: 1 / -1; }

    /* Exp / Edu Items */
    .exp-item {
      background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06);
      border-radius: var(--radius-sm); padding: 1.1rem; margin-bottom: 0.9rem; position: relative;
    }
    .exp-item-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.9rem; }
    .exp-item-title { font-size: 0.83rem; font-weight: 700; color: var(--text-secondary); }
    .exp-remove-btn {
      background: rgba(244,63,94,0.1); border: 1px solid rgba(244,63,94,0.25);
      color: var(--neon-rose); font-size: 0.73rem; font-weight: 700;
      padding: 0.22rem 0.55rem; border-radius: 6px; cursor: pointer; transition: var(--transition);
    }
    .exp-remove-btn:hover { background: rgba(244,63,94,0.2); }
    .add-item-btn {
      display: inline-flex; align-items: center; gap: 0.5rem;
      padding: 0.55rem 1.1rem; border-radius: var(--radius-sm);
      background: rgba(245,158,11,0.08); border: 1px dashed rgba(245,158,11,0.3);
      color: var(--neon-amber); font-size: 0.83rem; font-weight: 600;
      cursor: pointer; transition: var(--transition);
    }
    .add-item-btn:hover { background: rgba(245,158,11,0.15); }

    /* Skills */
    .skills-row { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.65rem; }
    .skill-tag-inp { display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; }
    .skill-chip {
      display: inline-flex; align-items: center; gap: 0.35rem;
      padding: 0.28rem 0.75rem; border-radius: 999px;
      background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.25);
      color: var(--neon-amber); font-size: 0.78rem; font-weight: 600;
    }
    .skill-chip button { background: none; border: none; cursor: pointer; color: inherit; padding: 0; line-height: 1; font-size: 0.9rem; }

    /* Actions */
    .cv-actions {
      display: flex; gap: 0.85rem; flex-wrap: wrap;
      margin-top: 1.5rem; justify-content: flex-end;
    }

    /* ── Info Banner (replaces pricing) ── */
    .cv-info-banner {
      background: linear-gradient(135deg, rgba(245,158,11,0.06), rgba(249,115,22,0.04));
      border: 1px solid rgba(245,158,11,0.2);
      border-radius: var(--radius-xl);
      padding: clamp(1.25rem, 4vw, 2rem) clamp(1.25rem, 4vw, 2rem);
      display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;
      margin-bottom: 3rem;
    }
    .cv-info-icon {
      font-size: 2.5rem; flex-shrink: 0;
    }
    .cv-info-title {
      font-size: 1.1rem; font-weight: 800; margin-bottom: 0.3rem;
    }
    .cv-info-text {
      color: var(--text-muted); font-size: 0.88rem; line-height: 1.6; max-width: 520px;
    }

    /* ── Template Card Actions ── */
    .template-card-actions {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.45rem;
      margin-top: 0.75rem;
    }
    .tpl-select-btn {
      padding: 0.55rem 0.25rem;
      font-size: 0.76rem;
      text-align: center;
      text-overflow: ellipsis;
      overflow: hidden;
      white-space: nowrap;
    }
    .tpl-preview-btn {
      padding: 0.55rem 0.25rem;
      border-radius: var(--radius-sm);
      font-size: 0.76rem;
      font-weight: 700;
      cursor: pointer;
      background: rgba(56, 189, 248, 0.08);
      color: var(--neon-cyan);
      border: 1px solid rgba(56, 189, 248, 0.25);
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.25rem;
      white-space: nowrap;
    }
    .tpl-preview-btn:hover {
      background: rgba(56, 189, 248, 0.16);
      border-color: var(--neon-cyan);
      box-shadow: 0 0 10px rgba(56, 189, 248, 0.2);
    }

    /* ── Focused Active Template Workspace Bar ── */
    .active-template-workspace-bar {
      display: none;
      background: linear-gradient(135deg, rgba(15, 23, 42, 0.96) 0%, rgba(30, 41, 59, 0.92) 100%);
      border: 1px solid rgba(245, 158, 11, 0.4);
      border-radius: var(--radius-xl);
      padding: 1.25rem 1.75rem;
      margin-bottom: 2rem;
      box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5), 0 0 30px rgba(245, 158, 11, 0.12);
      position: relative;
      overflow: hidden;
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      animation: slideDownBar 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes slideDownBar {
      from { opacity: 0; transform: translateY(-16px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .active-template-workspace-bar::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, var(--neon-amber), #f97316, var(--neon-cyan));
    }
    .active-tpl-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1.5rem;
      flex-wrap: wrap;
    }
    .active-tpl-left {
      display: flex;
      align-items: center;
      gap: 1.25rem;
      flex-wrap: wrap;
      flex: 1;
      min-width: 280px;
    }
    .active-tpl-icon-box {
      width: 56px;
      height: 64px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(249, 115, 22, 0.1));
      border: 1px solid rgba(245, 158, 11, 0.35);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.35);
      flex-shrink: 0;
    }
    .active-tpl-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.72rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      padding: 0.22rem 0.7rem;
      border-radius: 999px;
      background: rgba(16, 185, 129, 0.15);
      color: #34d399;
      border: 1px solid rgba(16, 185, 129, 0.35);
      margin-bottom: 0.35rem;
    }
    .active-tpl-title {
      font-size: 1.35rem;
      font-weight: 800;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 0.6rem;
      letter-spacing: -0.3px;
    }
    .active-tpl-desc {
      font-size: 0.84rem;
      color: var(--text-muted);
      margin-top: 0.25rem;
      line-height: 1.45;
    }
    .active-tpl-controls {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      flex-wrap: wrap;
    }
    .btn-control-back {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.65rem 1.25rem;
      border-radius: var(--radius-sm);
      background: rgba(56, 189, 248, 0.1);
      border: 1px solid rgba(56, 189, 248, 0.3);
      color: var(--neon-cyan);
      font-size: 0.85rem;
      font-weight: 700;
      cursor: pointer;
      transition: var(--transition);
    }
    .btn-control-back:hover {
      background: rgba(56, 189, 248, 0.22);
      border-color: var(--neon-cyan);
      box-shadow: 0 0 16px rgba(56, 189, 248, 0.25);
      transform: translateY(-2px);
    }
    .btn-control-cancel {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.65rem 1.25rem;
      border-radius: var(--radius-sm);
      background: rgba(244, 63, 94, 0.08);
      border: 1px solid rgba(244, 63, 94, 0.3);
      color: var(--neon-rose);
      font-size: 0.85rem;
      font-weight: 700;
      cursor: pointer;
      transition: var(--transition);
    }
    .btn-control-cancel:hover {
      background: rgba(244, 63, 94, 0.2);
      border-color: var(--neon-rose);
      box-shadow: 0 0 16px rgba(244, 63, 94, 0.3);
      transform: translateY(-2px);
    }
    .btn-control-preview {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.65rem 1.25rem;
      border-radius: var(--radius-sm);
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.15);
      color: var(--text-secondary);
      font-size: 0.85rem;
      font-weight: 700;
      cursor: pointer;
      transition: var(--transition);
    }
    .btn-control-preview:hover {
      background: rgba(255, 255, 255, 0.12);
      color: #fff;
      border-color: rgba(255, 255, 255, 0.3);
      transform: translateY(-2px);
    }

    /* ── Standard 3x4 Profile Picture Upload Box ── */
    .cv-photo-section {
      display: flex;
      gap: 1.5rem;
      align-items: center;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.02) 0%, rgba(245, 158, 11, 0.03) 100%);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: var(--radius-md);
      padding: 1.25rem;
      margin-bottom: 1.5rem;
      transition: var(--transition);
    }
    .cv-photo-uploader-box {
      width: 135px;
      height: 180px; /* Exact Standard 3:4 aspect ratio */
      aspect-ratio: 3 / 4;
      border-radius: 12px;
      border: 2px dashed rgba(245, 158, 11, 0.4);
      background: rgba(15, 23, 42, 0.7);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
      flex-shrink: 0;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    }
    .cv-photo-uploader-box:hover, .cv-photo-uploader-box.dragover {
      border-color: var(--neon-amber);
      background: rgba(245, 158, 11, 0.08);
      box-shadow: 0 0 24px rgba(245, 158, 11, 0.25);
      transform: translateY(-2px) scale(1.02);
    }
    .cv-photo-placeholder {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 0.75rem 0.5rem;
      pointer-events: none;
      width: 100%;
      height: 100%;
    }
    .cv-photo-icon-wrap {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: rgba(245, 158, 11, 0.12);
      border: 1px solid rgba(245, 158, 11, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.35rem;
      margin-bottom: 0.5rem;
    }
    .cv-photo-upload-text {
      font-size: 0.74rem;
      font-weight: 700;
      color: var(--neon-amber);
      margin-bottom: 0.25rem;
      line-height: 1.2;
    }
    .cv-photo-subtext {
      font-size: 0.64rem;
      color: var(--text-muted);
      line-height: 1.3;
    }
    .cv-photo-preview-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: none;
      border-radius: inherit;
    }
    .cv-photo-overlay {
      position: absolute;
      inset: 0;
      background: rgba(10, 14, 35, 0.8);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      display: none;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      opacity: 0;
      transition: opacity 0.25s ease;
    }
    .cv-photo-uploader-box:hover .cv-photo-overlay.has-image {
      display: flex;
      opacity: 1;
    }
    .cv-photo-change-btn, .cv-photo-delete-btn {
      font-size: 0.72rem;
      font-weight: 700;
      padding: 0.35rem 0.75rem;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
    }
    .cv-photo-change-btn {
      background: linear-gradient(135deg, var(--neon-amber), #f97316);
      color: #000;
    }
    .cv-photo-change-btn:hover {
      box-shadow: 0 0 10px rgba(245, 158, 11, 0.4);
    }
    .cv-photo-delete-btn {
      background: rgba(244, 63, 94, 0.2);
      color: var(--neon-rose);
      border: 1px solid rgba(244, 63, 94, 0.4);
    }
    .cv-photo-delete-btn:hover {
      background: rgba(244, 63, 94, 0.35);
    }
    .cv-photo-info {
      flex: 1;
    }
    .cv-photo-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      padding: 0.2rem 0.65rem;
      background: rgba(245, 158, 11, 0.1);
      border: 1px solid rgba(245, 158, 11, 0.25);
      color: var(--neon-amber);
      border-radius: 6px;
      font-size: 0.72rem;
      font-weight: 700;
      margin-bottom: 0.45rem;
    }
    .cv-photo-title {
      font-size: 0.98rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 0.3rem;
    }
    .cv-photo-desc {
      font-size: 0.82rem;
      color: var(--text-muted);
      line-height: 1.5;
      margin-bottom: 0.6rem;
    }
    .cv-photo-template-status {
      font-size: 0.78rem;
      color: var(--neon-cyan);
      display: flex;
      align-items: center;
      gap: 0.4rem;
      background: rgba(56, 189, 248, 0.06);
      border: 1px solid rgba(56, 189, 248, 0.18);
      padding: 0.35rem 0.75rem;
      border-radius: 8px;
      width: fit-content;
    }

    /* ── My Saved CVs Dashboard & Folder Workflow ── */
    .saved-count-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, var(--neon-cyan), #0284c7);
      color: #fff;
      font-size: 0.7rem;
      font-weight: 800;
      padding: 0.15rem 0.5rem;
      border-radius: 999px;
      line-height: 1;
      margin-left: 0.2rem;
      box-shadow: 0 0 10px rgba(56, 189, 248, 0.4);
    }
    
    .saved-cvs-section {
      background: linear-gradient(145deg, rgba(15, 23, 42, 0.95) 0%, rgba(10, 14, 35, 0.98) 100%);
      border: 1px solid rgba(56, 189, 248, 0.25);
      border-radius: var(--radius-xl);
      padding: clamp(1.25rem, 3.5vw, 2.25rem);
      margin-bottom: 2.5rem;
      box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5), 0 0 35px rgba(56, 189, 248, 0.08);
      position: relative;
      overflow: hidden;
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
    }
    .saved-cvs-section::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, var(--neon-cyan), #3b82f6, var(--neon-amber));
    }
    
    /* Transparent Account Folder Banner */
    .cv-vault-banner {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: var(--radius-lg);
      padding: 1.1rem 1.4rem;
      margin-bottom: 1.75rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1.25rem;
      flex-wrap: wrap;
    }
    .cv-vault-left {
      display: flex;
      align-items: center;
      gap: 1rem;
      flex: 1;
      min-width: 260px;
    }
    .cv-vault-icon-wrap {
      width: 46px;
      height: 46px;
      border-radius: 12px;
      background: rgba(56, 189, 248, 0.12);
      border: 1px solid rgba(56, 189, 248, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      flex-shrink: 0;
      color: var(--neon-cyan);
    }
    .cv-vault-label {
      font-size: 0.72rem;
      font-weight: 700;
      color: var(--neon-cyan);
      text-transform: uppercase;
      letter-spacing: 0.8px;
      margin-bottom: 0.2rem;
      display: flex;
      align-items: center;
      gap: 0.4rem;
    }
    .cv-vault-path-box {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      background: rgba(0, 0, 0, 0.35);
      border: 1px solid rgba(255, 255, 255, 0.1);
      padding: 0.28rem 0.65rem;
      border-radius: 6px;
      font-family: monospace;
      font-size: 0.78rem;
      color: #38bdf8;
      cursor: pointer;
      transition: var(--transition);
      max-width: 100%;
      word-break: break-all;
    }
    .cv-vault-path-box:hover {
      background: rgba(56, 189, 248, 0.12);
      border-color: rgba(56, 189, 248, 0.4);
    }
    .cv-vault-stats {
      display: flex;
      align-items: center;
      gap: 1rem;
      flex-wrap: wrap;
    }
    .cv-vault-stat-item {
      font-size: 0.78rem;
      color: var(--text-muted);
      display: flex;
      align-items: center;
      gap: 0.35rem;
    }
    .cv-vault-stat-item strong {
      color: #fff;
      font-weight: 700;
    }

    /* Saved CVs Grid */
    .saved-cvs-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 1.25rem;
    }

    /* Saved CV Card */
    .saved-cv-card {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: var(--radius-lg);
      padding: 1.25rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      position: relative;
      overflow: hidden;
    }
    .saved-cv-card:hover {
      border-color: rgba(56, 189, 248, 0.4);
      background: rgba(255, 255, 255, 0.05);
      transform: translateY(-4px);
      box-shadow: 0 16px 36px -10px rgba(0, 0, 0, 0.5), 0 0 20px rgba(56, 189, 248, 0.12);
    }

    /* Visual Document Mini Preview inside card */
    .saved-cv-card-top {
      display: flex;
      gap: 1.1rem;
      margin-bottom: 1.1rem;
      align-items: flex-start;
    }
    .saved-cv-mini-doc {
      width: 72px;
      height: 98px; /* 3:4 portrait ratio */
      border-radius: 6px;
      background: #fff;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4);
      overflow: hidden;
      flex-shrink: 0;
      position: relative;
      border: 1px solid rgba(255, 255, 255, 0.2);
      transition: transform 0.3s ease;
    }
    .saved-cv-card:hover .saved-cv-mini-doc {
      transform: scale(1.05) rotate(-1deg);
    }
    .saved-cv-doc-inner {
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      font-size: 5px;
      line-height: 1;
      padding: 4px 5px;
      color: #0f172a;
    }
    .saved-cv-doc-head {
      display: flex;
      align-items: center;
      gap: 3px;
      margin-bottom: 4px;
      border-bottom: 1px solid #cbd5e1;
      padding-bottom: 3px;
    }
    .saved-cv-doc-avatar {
      width: 14px;
      height: 18px;
      border-radius: 2px;
      background: #38bdf8;
      overflow: hidden;
      flex-shrink: 0;
    }
    .saved-cv-doc-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .saved-cv-doc-lines {
      flex: 1;
    }
    .saved-cv-doc-bar {
      height: 2px;
      border-radius: 1px;
      background: #0f172a;
      margin-bottom: 1.5px;
    }
    .saved-cv-doc-bar-sub {
      height: 1.5px;
      border-radius: 1px;
      background: #94a3b8;
      width: 70%;
    }
    .saved-cv-doc-body-line {
      height: 1.5px;
      background: #e2e8f0;
      border-radius: 1px;
      margin-bottom: 2px;
      width: 100%;
    }

    /* Card Details */
    .saved-cv-card-info {
      flex: 1;
      min-width: 0;
    }
    .saved-cv-badge-row {
      display: flex;
      align-items: center;
      gap: 0.4rem;
      margin-bottom: 0.35rem;
      flex-wrap: wrap;
    }
    .saved-cv-tpl-pill {
      font-size: 0.68rem;
      font-weight: 700;
      padding: 0.15rem 0.5rem;
      border-radius: 4px;
      background: rgba(245, 158, 11, 0.12);
      color: #fbbf24;
      border: 1px solid rgba(245, 158, 11, 0.25);
    }
    .saved-cv-status-pill {
      font-size: 0.66rem;
      font-weight: 700;
      padding: 0.15rem 0.5rem;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      gap: 0.25rem;
    }
    .status-exported {
      background: rgba(16, 185, 129, 0.15);
      color: #34d399;
      border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .status-draft {
      background: rgba(245, 158, 11, 0.15);
      color: #fbbf24;
      border: 1px solid rgba(245, 158, 11, 0.3);
    }
    .saved-cv-title {
      font-size: 1rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 0.2rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .saved-cv-role {
      font-size: 0.8rem;
      color: #94a3b8;
      margin-bottom: 0.35rem;
    }
    .saved-cv-meta {
      font-size: 0.72rem;
      color: var(--text-muted);
      display: flex;
      align-items: center;
      gap: 0.6rem;
      flex-wrap: wrap;
    }

    /* Card File Path Pill */
    .saved-cv-path-pill {
      background: rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.06);
      border-radius: 6px;
      padding: 0.35rem 0.6rem;
      font-size: 0.72rem;
      color: #94a3b8;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0.5rem;
      font-family: monospace;
    }
    .saved-cv-path-pill span {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    /* One-Click Action Suite Bar */
    .saved-cv-actions {
      display: grid;
      grid-template-columns: 1.2fr 1fr 1fr;
      gap: 0.4rem;
      margin-bottom: 0.45rem;
    }
    .btn-card-action {
      padding: 0.48rem 0.4rem;
      border-radius: var(--radius-sm);
      font-size: 0.74rem;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.3rem;
      transition: var(--transition);
      white-space: nowrap;
      border: none;
    }
    .btn-action-download {
      background: linear-gradient(135deg, var(--neon-amber), #f97316);
      color: #000;
    }
    .btn-action-download:hover {
      box-shadow: 0 0 12px rgba(245, 158, 11, 0.4);
      transform: translateY(-1px);
    }
    .btn-action-print {
      background: rgba(56, 189, 248, 0.1);
      color: var(--neon-cyan);
      border: 1px solid rgba(56, 189, 248, 0.25);
    }
    .btn-action-print:hover {
      background: rgba(56, 189, 248, 0.2);
      border-color: var(--neon-cyan);
      transform: translateY(-1px);
    }
    .btn-action-share {
      background: rgba(139, 92, 246, 0.12);
      color: #c084fc;
      border: 1px solid rgba(139, 92, 246, 0.3);
    }
    .btn-action-share:hover {
      background: rgba(139, 92, 246, 0.22);
      border-color: #c084fc;
      box-shadow: 0 0 12px rgba(139, 92, 246, 0.25);
      transform: translateY(-1px);
    }
    
    .saved-cv-secondary-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 0.3rem;
      padding-top: 0.5rem;
      border-top: 1px solid rgba(255, 255, 255, 0.06);
    }
    .btn-action-load {
      background: transparent;
      border: none;
      color: #38bdf8;
      font-size: 0.74rem;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 0.25rem;
      padding: 0;
      transition: var(--transition);
    }
    .btn-action-load:hover {
      color: #fff;
      text-decoration: underline;
    }
    .btn-action-delete {
      background: transparent;
      border: none;
      color: #94a3b8;
      font-size: 0.72rem;
      font-weight: 600;
      cursor: pointer;
      padding: 0;
      transition: var(--transition);
    }
    .btn-action-delete:hover {
      color: var(--neon-rose);
    }

    /* Empty state */
    .saved-cvs-empty {
      text-align: center;
      padding: 3rem 1.5rem;
      background: rgba(255, 255, 255, 0.015);
      border: 1px dashed rgba(255, 255, 255, 0.1);
      border-radius: var(--radius-lg);
    }
    .saved-cvs-empty-icon {
      font-size: 3rem;
      margin-bottom: 0.75rem;
      opacity: 0.8;
    }
    .saved-cvs-empty-title {
      font-size: 1.1rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 0.4rem;
    }
    .saved-cvs-empty-desc {
      font-size: 0.85rem;
      color: var(--text-muted);
      max-width: 460px;
      margin: 0 auto 1.25rem;
      line-height: 1.5;
    }

    /* ── Direct Share Suite Modal ── */
    .share-suite-modal {
      position: fixed;
      inset: 0;
      z-index: 1100;
      background: rgba(10, 14, 35, 0.85);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      display: none;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      opacity: 0;
      transition: opacity 0.25s ease;
    }
    .share-suite-modal.active {
      display: flex;
      opacity: 1;
    }
    .share-suite-content {
      background: #0f172a;
      border: 1px solid rgba(56, 189, 248, 0.3);
      border-radius: var(--radius-xl);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6), 0 0 35px rgba(56, 189, 248, 0.15);
      width: 100%;
      max-width: 480px;
      overflow: hidden;
      transform: scale(0.95);
      transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .share-suite-modal.active .share-suite-content {
      transform: scale(1);
    }
    .share-suite-header {
      padding: 1.1rem 1.4rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #1e293b;
    }
    .share-suite-title {
      font-size: 1.1rem;
      font-weight: 800;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .share-suite-body {
      padding: 1.5rem;
    }
    .share-cv-target-info {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: var(--radius-md);
      padding: 0.85rem 1rem;
      margin-bottom: 1.25rem;
      display: flex;
      align-items: center;
      gap: 0.85rem;
    }
    .share-cv-target-icon {
      font-size: 1.6rem;
      flex-shrink: 0;
    }
    .share-cv-target-title {
      font-size: 0.92rem;
      font-weight: 800;
      color: #fff;
      line-height: 1.2;
    }
    .share-cv-target-meta {
      font-size: 0.74rem;
      color: var(--text-muted);
      margin-top: 2px;
    }
    .share-channels-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.75rem;
      margin-bottom: 1.25rem;
    }
    .share-channel-btn {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.85rem 1rem;
      border-radius: var(--radius-md);
      font-size: 0.85rem;
      font-weight: 700;
      cursor: pointer;
      text-decoration: none;
      transition: var(--transition);
      border: 1px solid transparent;
    }
    .share-btn-whatsapp {
      background: rgba(37, 211, 102, 0.12);
      color: #25d366;
      border-color: rgba(37, 211, 102, 0.3);
    }
    .share-btn-whatsapp:hover {
      background: rgba(37, 211, 102, 0.22);
      box-shadow: 0 0 15px rgba(37, 211, 102, 0.25);
      transform: translateY(-2px);
    }
    .share-btn-email {
      background: rgba(56, 189, 248, 0.12);
      color: #38bdf8;
      border-color: rgba(56, 189, 248, 0.3);
    }
    .share-btn-email:hover {
      background: rgba(56, 189, 248, 0.22);
      box-shadow: 0 0 15px rgba(56, 189, 248, 0.25);
      transform: translateY(-2px);
    }
    .share-btn-instagram {
      background: rgba(225, 48, 108, 0.12);
      color: #f43f5e;
      border-color: rgba(225, 48, 108, 0.3);
    }
    .share-btn-instagram:hover {
      background: rgba(225, 48, 108, 0.22);
      box-shadow: 0 0 15px rgba(225, 48, 108, 0.25);
      transform: translateY(-2px);
    }
    .share-btn-facebook {
      background: rgba(24, 119, 242, 0.12);
      color: #60a5fa;
      border-color: rgba(24, 119, 242, 0.3);
    }
    .share-btn-facebook:hover {
      background: rgba(24, 119, 242, 0.22);
      box-shadow: 0 0 15px rgba(24, 119, 242, 0.25);
      transform: translateY(-2px);
    }
    .share-link-box {
      background: rgba(0, 0, 0, 0.4);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius-sm);
      padding: 0.65rem 0.85rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .share-link-input {
      background: transparent;
      border: none;
      color: #cbd5e1;
      font-size: 0.78rem;
      font-family: monospace;
      flex: 1;
      outline: none;
    }
    .share-copy-btn {
      background: linear-gradient(135deg, var(--neon-amber), #f97316);
      color: #000;
      font-size: 0.75rem;
      font-weight: 700;
      border: none;
      padding: 0.35rem 0.75rem;
      border-radius: 6px;
      cursor: pointer;
      transition: var(--transition);
      white-space: nowrap;
    }
    .share-copy-btn:hover {
      box-shadow: 0 0 10px rgba(245, 158, 11, 0.4);
    }

    /* ── Preview Modal ── */
    .preview-modal {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      z-index: 1000;
      background: rgba(10, 14, 35, 0.8);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      display: none;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .preview-modal.active {
      display: flex;
      opacity: 1;
    }
    .preview-modal-content {
      background: #0f172a;
      border: 1px solid rgba(255,255,255,0.08);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 40px rgba(56, 189, 248, 0.1);
      border-radius: var(--radius-xl);
      width: 100%;
      max-width: 1100px;
      height: 85vh;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      transform: scale(0.95);
      transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .preview-modal.active .preview-modal-content {
      transform: scale(1);
    }
    .preview-modal-header {
      padding: 1rem 1.5rem;
      border-bottom: 1px solid rgba(255,255,255,0.08);
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #1e293b;
    }
    .preview-modal-title {
      font-size: 1.15rem;
      font-weight: 800;
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }
    .preview-modal-close {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      color: #94a3b8;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 1rem;
      transition: var(--transition);
    }
    .preview-modal-close:hover {
      background: rgba(244,63,94,0.15);
      color: var(--neon-rose);
      border-color: rgba(244,63,94,0.3);
    }
    .preview-modal-body {
      flex: 1;
      display: grid;
      grid-template-columns: 1.4fr 1fr;
      overflow: hidden;
    }
    
    /* Device Simulation Panel */
    .device-sim-panel {
      background: #090d16;
      border-right: 1px solid rgba(255,255,255,0.05);
      display: flex;
      flex-direction: column;
      padding: 1rem;
      overflow: hidden;
      align-items: center;
    }
    .device-switcher {
      display: flex;
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 999px;
      padding: 3px;
      margin-bottom: 1rem;
      width: fit-content;
    }
    .device-switch-btn {
      background: transparent;
      border: none;
      color: #94a3b8;
      font-size: 0.78rem;
      font-weight: 700;
      padding: 0.45rem 1rem;
      border-radius: 999px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 0.35rem;
      transition: var(--transition);
    }
    .device-switch-btn.active {
      background: linear-gradient(135deg, var(--neon-cyan), #3b82f6);
      color: #fff;
      box-shadow: 0 4px 10px rgba(56, 189, 248, 0.2);
    }

    .device-viewport-wrapper {
      flex: 1;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow-y: auto;
      padding: 1rem;
    }

    /* Device Mockups */
    .device-frame-desktop {
      width: 100%;
      max-width: 820px;
      aspect-ratio: 16/10.5;
      background: #1e293b;
      border-radius: 12px;
      border: 6px solid #334155;
      box-shadow: 0 20px 40px rgba(0,0,0,0.6);
      overflow-y: auto;
      padding: 1rem;
    }
    .device-frame-tablet {
      width: 520px;
      height: 680px;
      background: #1e293b;
      border-radius: 24px;
      border: 12px solid #334155;
      box-shadow: 0 20px 40px rgba(0,0,0,0.6);
      overflow-y: auto;
      padding: 1rem;
    }
    .device-frame-mobile {
      width: 320px;
      height: 580px;
      background: #1e293b;
      border-radius: 36px;
      border: 12px solid #334155;
      box-shadow: 0 20px 40px rgba(0,0,0,0.6);
      overflow-y: auto;
      padding: 1rem 0.75rem;
      position: relative;
    }
    .device-frame-mobile::before {
      content: '';
      position: absolute;
      top: 0; left: 50%;
      transform: translateX(-50%);
      width: 110px; height: 18px;
      background: #334155;
      border-bottom-left-radius: 10px;
      border-bottom-right-radius: 10px;
      z-index: 10;
    }

    /* ── CV Styling within simulation ── */
    .sim-cv {
      background: #fff;
      color: #1e293b;
      font-family: 'Inter', sans-serif;
      font-size: 11px;
      line-height: 1.4;
      padding: 2rem;
      border-radius: 4px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      min-height: 100%;
    }

    /* Template 1: Klassik Peşəkar */
    .sim-cv-tpl-1 .cv-header {
      border-bottom: 2px solid #1e293b;
      padding-bottom: 0.8rem;
      margin-bottom: 1rem;
    }
    .sim-cv-tpl-1 .cv-name { font-size: 1.6rem; font-weight: 800; color: #0f172a; text-transform: uppercase; }
    .sim-cv-tpl-1 .cv-role { font-size: 1rem; color: #f59e0b; font-weight: 700; margin-top: 2px; }
    .sim-cv-tpl-1 .cv-contact { display: flex; flex-wrap: wrap; gap: 0.6rem; margin-top: 0.5rem; font-size: 0.75rem; color: #475569; }
    .sim-cv-tpl-1 .cv-section-title { font-size: 0.95rem; font-weight: 800; color: #0f172a; border-bottom: 1px solid #cbd5e1; padding-bottom: 2px; margin-top: 1rem; margin-bottom: 0.5rem; text-transform: uppercase; }
    .sim-cv-tpl-1 .cv-item { margin-bottom: 0.6rem; }
    .sim-cv-tpl-1 .cv-item-title { display: flex; justify-content: space-between; font-weight: 700; color: #1e293b; }
    .sim-cv-tpl-1 .cv-item-sub { color: #64748b; font-style: italic; font-size: 0.72rem; margin-bottom: 2px; }

    /* Template 2: Müasir Texnoloji */
    .sim-cv-tpl-2 { display: grid; grid-template-columns: 1fr; gap: 1rem; }
    .sim-cv-tpl-2 .cv-header {
      background: #0f172a;
      color: #fff;
      padding: 1.25rem;
      border-radius: 6px;
      position: relative;
    }
    .sim-cv-tpl-2 .cv-header::before {
      content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: #38bdf8; border-top-left-radius: 6px; border-bottom-left-radius: 6px;
    }
    .sim-cv-tpl-2 .cv-name { font-size: 1.5rem; font-weight: 800; color: #f8fafc; }
    .sim-cv-tpl-2 .cv-role { font-size: 0.95rem; color: #38bdf8; font-weight: 600; margin-top: 2px; }
    .sim-cv-tpl-2 .cv-contact { display: flex; flex-wrap: wrap; gap: 0.6rem; margin-top: 0.5rem; font-size: 0.72rem; color: #94a3b8; }
    .sim-cv-tpl-2 .cv-section-title { font-size: 0.9rem; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 0.4rem; margin-top: 1rem; margin-bottom: 0.5rem; }
    .sim-cv-tpl-2 .cv-section-title::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
    .sim-cv-tpl-2 .cv-chip { display: inline-block; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; color: #334155; margin-right: 3px; margin-bottom: 3px; border: 1px solid #e2e8f0; }

    /* Template 3: Kreativ Dizayn */
    .sim-cv-tpl-3 { display: grid; grid-template-columns: 1fr; gap: 1rem; padding: 0; }
    .sim-cv-tpl-3 .cv-top-bar {
      background: linear-gradient(135deg, #f43f5e, #8b5cf6);
      color: #fff;
      padding: 2rem;
    }
    .sim-cv-tpl-3 .cv-inner-body { padding: 1.5rem 2rem 2rem; }
    .sim-cv-tpl-3 .cv-name { font-size: 1.7rem; font-weight: 900; letter-spacing: -0.5px; }
    .sim-cv-tpl-3 .cv-role { font-size: 1rem; opacity: 0.9; font-weight: 500; margin-top: 4px; }
    .sim-cv-tpl-3 .cv-contact { display: flex; flex-wrap: wrap; gap: 0.8rem; margin-top: 0.75rem; font-size: 0.75rem; opacity: 0.85; }
    .sim-cv-tpl-3 .cv-section-title { font-size: 0.95rem; font-weight: 800; color: #8b5cf6; margin-top: 1.25rem; margin-bottom: 0.6rem; letter-spacing: 0.5px; text-transform: uppercase; }
    .sim-cv-tpl-3 .cv-skill-bar { height: 6px; background: #e2e8f0; border-radius: 3px; margin-top: 3px; overflow: hidden; }
    .sim-cv-tpl-3 .cv-skill-fill { height: 100%; background: linear-gradient(90deg, #f43f5e, #8b5cf6); border-radius: 3px; }

    /* Template 4: İcra Direktoru (Executive) */
    .sim-cv-tpl-4 { display: grid; grid-template-columns: 1fr; gap: 1rem; border-top: 6px solid #064e3b; }
    .sim-cv-tpl-4 .cv-header {
      display: flex; justify-content: space-between; align-items: flex-start;
      border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem; margin-bottom: 0.5rem;
    }
    .sim-cv-tpl-4 .cv-name { font-size: 1.5rem; font-weight: 800; color: #064e3b; font-family: 'Outfit', sans-serif; }
    .sim-cv-tpl-4 .cv-role { font-size: 0.95rem; color: #10b981; font-weight: 600; margin-top: 2px; }
    .sim-cv-tpl-4 .cv-contact { font-size: 0.72rem; color: #475569; text-align: right; }
    .sim-cv-tpl-4 .cv-section-title { font-size: 0.88rem; font-weight: 800; color: #064e3b; border-bottom: 2px solid #064e3b; display: inline-block; padding-bottom: 2px; margin-top: 1rem; margin-bottom: 0.6rem; text-transform: uppercase; letter-spacing: 1px; }

    /* Template 5: Gənc Start (Student) */
    .sim-cv-tpl-5 { display: grid; grid-template-columns: 1.2fr 2fr; gap: 1.5rem; }
    .sim-cv-tpl-5 .cv-sidebar {
      background: #f5f3ff;
      border-radius: 8px;
      padding: 1rem;
    }
    .sim-cv-tpl-5 .cv-main-content {
      padding: 0.5rem 0;
    }
    .sim-cv-tpl-5 .cv-name { font-size: 1.35rem; font-weight: 800; color: #4338ca; }
    .sim-cv-tpl-5 .cv-role { font-size: 0.85rem; color: #6366f1; font-weight: 600; margin-bottom: 0.5rem; }
    .sim-cv-tpl-5 .cv-sidebar-section { margin-bottom: 1rem; }
    .sim-cv-tpl-5 .cv-section-title { font-size: 0.85rem; font-weight: 800; color: #4338ca; border-bottom: 1.5px solid #e0e7ff; padding-bottom: 2px; margin-bottom: 0.5rem; }

    /* Right Details Panel */
    .preview-info-panel {
      padding: 1.5rem;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      background: #0f172a;
    }
    .preview-tpl-title { font-size: 1.4rem; font-weight: 800; margin-bottom: 0.4rem; color: #fff; }
    .preview-tpl-desc { font-size: 0.88rem; color: #94a3b8; margin-bottom: 1.25rem; line-height: 1.5; }
    .preview-info-section { margin-bottom: 1.2rem; }
    .preview-info-label { font-size: 0.72rem; font-weight: 700; color: var(--neon-cyan); text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 0.4rem; }
    .preview-info-chips { display: flex; flex-wrap: wrap; gap: 0.35rem; }
    .preview-info-chip { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); color: #e2e8f0; font-size: 0.75rem; padding: 0.25rem 0.6rem; border-radius: 4px; }
    .preview-feature-item { display: flex; align-items: flex-start; gap: 0.5rem; font-size: 0.8rem; color: #cbd5e1; margin-bottom: 0.45rem; }
    .preview-feature-icon { color: var(--neon-green); font-weight: 700; font-size: 0.85rem; }
    
    .preview-modal-actions {
      display: flex;
      flex-direction: column;
      gap: 0.6rem;
      margin-top: auto;
      border-top: 1px solid rgba(255,255,255,0.08);
      padding-top: 1.25rem;
    }

    /* ── Responsive ── */
    @media (max-width: 1200px) {
      .templates-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 900px) {
      .templates-grid { grid-template-columns: repeat(3, 1fr); gap: 0.85rem; }
      .template-preview { height: 185px; }
      .tpl-doc { width: 100px; height: 144px; }
      .preview-modal-content { height: 90vh; }
      .preview-modal-body { grid-template-columns: 1fr; overflow-y: auto; }
      .device-sim-panel { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.05); overflow: visible; height: auto; }
      .device-viewport-wrapper { overflow: visible; min-height: 350px; }
      .device-frame-desktop { max-width: 100%; aspect-ratio: auto; height: 350px; }
      .device-frame-tablet { width: 100%; height: 420px; }
      .device-frame-mobile { width: 290px; height: 420px; }
      .preview-info-panel { overflow: visible; }
    }
    @media (max-width: 768px) {
      .cv-page { padding-top: 70px; }
      .cv-hero-emoji { display: none; }
      .templates-grid { grid-template-columns: repeat(2, 1fr); gap: 0.85rem; }
      .template-preview { height: 185px; }
      .tpl-doc { width: 105px; height: 150px; }
    }
    @media (max-width: 600px) {
      .templates-grid { grid-template-columns: repeat(2, 1fr); gap: 0.65rem; }
      .template-preview { height: 170px; }
      .tpl-doc { width: 96px; height: 138px; }
      .template-card-body { padding: 0.65rem 0.75rem 0.75rem; }
      .template-name { font-size: 0.82rem; }
      .template-desc { font-size: 0.68rem; }
      .cv-form-grid { grid-template-columns: 1fr; }
      .cv-actions { justify-content: stretch; }
      .cv-actions .btn-primary,
      .cv-actions .btn-ghost { width: 100%; text-align: center; justify-content: center; }
    }
    @media (max-width: 480px) {
      .templates-grid { grid-template-columns: repeat(2, 1fr); gap: 0.5rem; }
      .template-preview { height: 155px; }
      .tpl-doc { width: 88px; height: 126px; }
      .template-card-body { padding: 0.55rem 0.6rem 0.6rem; }
      .template-name { font-size: 0.78rem; }
      .template-desc { display: none; }
      .template-tags { display: none; }
      .template-card-actions { grid-template-columns: 1fr; gap: 0.3rem; }
      .tpl-preview-btn { display: none; }
      .cv-tab { font-size: 0.76rem; padding: 0.55rem 0.75rem; }
      .cv-builder-section { padding: 1rem; }
      .skill-tag-inp { flex-direction: column; align-items: stretch; }
      .skill-tag-inp .form-input { max-width: 100% !important; }
      .preview-modal { padding: 0.5rem; }
      .preview-modal-content { height: 95vh; border-radius: var(--radius-lg); }
    }
    @media (max-width: 360px) {
      .templates-grid { grid-template-columns: 1fr; }
      .template-preview { height: 175px; }
      .tpl-doc { width: 110px; height: 155px; }
      .template-desc { display: block; }
      .template-tags { display: flex; }
      .tpl-preview-btn { display: flex; }
    }

    /* Touch targets for mobile */
    @media (hover: none) {
      .form-input, .form-select, .form-textarea { font-size: 16px; } /* prevents zoom on iOS */
      .tpl-select-btn, .add-item-btn, .exp-remove-btn, .tpl-preview-btn { min-height: 44px; }
    }
  </style>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body>

<nav id="main-navbar" class="navbar" role="navigation" aria-label="Əsas naviqasiya">
  <div class="container nav-inner">
    <a href="<?= SITE_URL ?>" class="logo" aria-label="Skyweb.az Ana Səhifə">
      <div class="logo-icon" aria-hidden="true">
        <svg class="sky-logo-svg" viewBox="0 0 142 96" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="skySGradCV" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#38bdf8" />
              <stop offset="100%" stop-color="#0284c7" />
            </linearGradient>
            <filter id="skyLogoGlowCV" x="-20%" y="-20%" width="140%" height="140%">
              <feGaussianBlur stdDeviation="3" result="blur" />
              <feMerge>
                <feMergeNode in="blur" />
                <feMergeNode in="SourceGraphic" />
              </feMerge>
            </filter>
          </defs>
          <path d="M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z" fill="url(#skySGradCV)" />
          <g filter="url(#skyLogoGlowCV)">
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
    <?= render_language_switcher('module-lang-switch') ?>
    <div style="display:flex;align-items:center;gap:1rem;">
      <a href="<?= SITE_URL ?>" style="color:var(--text-muted);text-decoration:none;font-size:0.85rem;display:flex;align-items:center;gap:0.4rem;" data-i18n="nav_home">
        ← <?= __("nav_home") ?>
      </a>
    </div>
  </div>
</nav>

<main class="cv-page">
  <div class="container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb" aria-label="<?= __("aria_breadcrumb_label") ?>" data-i18n-attr="aria-label:aria_breadcrumb_label">
      <a href="<?= SITE_URL ?>" data-i18n="nav_home"><?= __("nav_home") ?></a>
      <span style="opacity:0.4">/</span>
      <span data-i18n="cv_breadcrumb"><?= __("cv_breadcrumb") ?></span>
    </nav>

    <!-- Hero -->
    <div class="cv-hero">
      <div style="flex:1;min-width:220px;position:relative;z-index:1;">
        <div class="cv-hero-badge" data-i18n="cv_hero_badge"><?= __("cv_hero_badge") ?></div>
        <h1 class="cv-hero-title"><span data-i18n="cv_hero_title1"><?= __("cv_hero_title1") ?></span> <span class="gradient-text-gold" data-i18n="cv_hero_title2"><?= __("cv_hero_title2") ?></span> <span data-i18n="cv_hero_title3"><?= __("cv_hero_title3") ?></span></h1>
        <p class="cv-hero-desc" data-i18n="cv_hero_desc"><?= __("cv_hero_desc") ?></p>
        <div class="cv-hero-actions">
          <a href="#cv-builder" class="btn-primary" style="background:linear-gradient(135deg,var(--neon-amber),#f97316);">
            <span data-i18n="cv_btn_create"><?= __("cv_btn_create") ?></span>
          </a>
          <a href="#templates" class="btn-ghost" style="color:var(--neon-amber);border-color:rgba(245,158,11,0.3);">
            <span data-i18n="cv_btn_templates"><?= __("cv_btn_templates") ?></span>
          </a>
          <a href="#saved-cvs-dashboard" class="btn-ghost" style="color:var(--neon-cyan);border-color:rgba(56,189,248,0.35);display:inline-flex;align-items:center;gap:0.45rem;">
            <span data-i18n="cv_my_saved"><?= __("cv_my_saved") ?></span>
            <span class="saved-count-badge" id="heroSavedCountBadge">0</span>
          </a>
        </div>
      </div>
      <div class="cv-hero-emoji">📋</div>
    </div>

    <!-- ── My Saved CVs Dashboard Section ── -->
    <section class="saved-cvs-section" id="saved-cvs-dashboard">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;flex-wrap:wrap;gap:0.8rem;">
        <div>
          <div class="section-label-sm" style="color:var(--neon-cyan);margin-bottom:0.25rem;" data-i18n="cv_folder_archive"><?= __("cv_folder_archive") ?></div>
          <h2 style="font-size:1.35rem;font-weight:800;color:#fff;margin:0;display:flex;align-items:center;gap:0.5rem;">
            <span data-i18n="cv_saved_title"><?= __("cv_saved_title") ?></span>
            <span class="saved-count-badge" id="sectionSavedCountBadge">0</span>
          </h2>
        </div>
        <div style="display:flex;align-items:center;gap:0.6rem;flex-wrap:wrap;">
          <button type="button" onclick="refreshSavedCvs()" class="btn-ghost" style="font-size:0.78rem;padding:0.45rem 0.85rem;color:#94a3b8;border-color:rgba(255,255,255,0.1);border-radius:var(--radius-sm);cursor:pointer;">
            <span data-i18n="cv_btn_refresh"><?= __("cv_btn_refresh") ?></span>
          </button>
          <a href="#cv-builder" class="btn-primary" style="font-size:0.78rem;padding:0.45rem 0.95rem;background:linear-gradient(135deg,var(--neon-amber),#f97316);border:none;border-radius:var(--radius-sm);cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:0.35rem;font-weight:700;">
            <span data-i18n="cv_btn_new"><?= __("cv_btn_new") ?></span>
          </a>
        </div>
      </div>

      <!-- Transparent Account Folder Workflow Banner -->
      <div class="cv-vault-banner">
        <div class="cv-vault-left">
          <div class="cv-vault-icon-wrap">🗂️</div>
          <div>
            <div class="cv-vault-label">
              <span data-i18n="cv_account_path_title"><?= __("cv_account_path_title") ?></span>
              <span style="color:#34d399;font-size:0.68rem;" data-i18n="cv_auto_sync"><?= __("cv_auto_sync") ?></span>
            </div>
            <div class="cv-vault-path-box" id="vaultPathBox" onclick="copyVaultPath()" title="Qovluq yolunu kopyala">
              <span>📁</span>
              <span id="vaultPathText">/uploads/cvs/user_vault/</span>
              <span style="font-size:0.65rem;color:var(--text-muted);margin-left:4px;" data-i18n="cv_click_copy"><?= __("cv_click_copy") ?></span>
            </div>
          </div>
        </div>
        <div class="cv-vault-stats">
          <div class="cv-vault-stat-item">
            <span data-i18n="cv_files_label"><?= __("cv_files_label") ?></span>
            <strong id="vaultFilesCount">0 ədəd</strong>
          </div>
          <div class="cv-vault-stat-item">
            <span data-i18n="cv_storage_label"><?= __("cv_storage_label") ?></span>
            <strong id="vaultStorageUsed">0.0 KB</strong>
          </div>
          <div class="cv-vault-stat-item">
            <span data-i18n="cv_format_label"><?= __("cv_format_label") ?></span>
            <strong style="color:var(--neon-cyan);" data-i18n="cv_format_val"><?= __("cv_format_val") ?></strong>
          </div>
        </div>
      </div>

      <!-- Saved CVs Cards Grid -->
      <div class="saved-cvs-grid" id="savedCvsGrid">
        <!-- Injected dynamically by JavaScript -->
      </div>
    </section>

    <!-- Templates -->
    <div id="templates" style="margin-bottom:1.25rem;">
      <div class="section-label-sm" data-i18n="cv_templates_title"><?= __("cv_templates_title") ?></div>
      <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:0.4rem;" data-i18n="cv_templates_subtitle"><?= __("cv_templates_subtitle") ?></h2>
      <p style="color:var(--text-muted);font-size:0.88rem;margin-bottom:1.25rem;" data-i18n="cv_templates_desc"><?= __("cv_templates_desc") ?></p>
    </div>
    <div class="templates-grid" id="templatesGrid">

      <!-- Template 1: Professional Elite -->
      <div class="template-card" id="tpl-1">
        <div class="template-preview" onclick="openPreviewModal('tpl-1')" style="background:linear-gradient(160deg,rgba(245,158,11,0.12) 0%,rgba(15,23,42,0.95) 100%);">
          <div class="tpl-doc-ghost" style="background:linear-gradient(180deg,#1e293b 30%,#f59e0b22 100%);"></div>
          <div class="tpl-doc">
            <!-- Header bar -->
            <div style="background:#1e293b;padding:10px 9px 7px;">
              <div style="display:flex;align-items:center;gap:6px;">
                <div style="width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,#f59e0b,#f97316);flex-shrink:0;"></div>
                <div style="flex:1;">
                  <div style="height:5px;border-radius:3px;background:#f59e0b;width:72%;margin-bottom:3px;"></div>
                  <div style="height:3px;border-radius:3px;background:rgba(245,158,11,0.4);width:50%;"></div>
                </div>
              </div>
              <div style="margin-top:5px;display:flex;gap:3px;">
                <div style="height:2px;border-radius:2px;background:rgba(245,158,11,0.3);flex:1;"></div>
                <div style="height:2px;border-radius:2px;background:rgba(245,158,11,0.2);flex:1;"></div>
                <div style="height:2px;border-radius:2px;background:rgba(245,158,11,0.2);flex:1;"></div>
              </div>
            </div>
            <!-- Divider -->
            <div style="height:2px;background:#f59e0b;opacity:0.8;"></div>
            <!-- Body -->
            <div style="padding:7px 8px;background:#fff;">
              <div style="height:4px;border-radius:3px;background:#f59e0b;width:44%;margin-bottom:5px;"></div>
              <div style="height:2.5px;border-radius:2px;background:#e2e8f0;width:100%;margin-bottom:2px;"></div>
              <div style="height:2.5px;border-radius:2px;background:#e2e8f0;width:80%;margin-bottom:2px;"></div>
              <div style="height:2.5px;border-radius:2px;background:#e2e8f0;width:90%;margin-bottom:6px;"></div>
              <div style="height:4px;border-radius:3px;background:#f59e0b;width:44%;margin-bottom:5px;"></div>
              <div style="height:2.5px;border-radius:2px;background:#e2e8f0;width:100%;margin-bottom:2px;"></div>
              <div style="height:2.5px;border-radius:2px;background:#e2e8f0;width:70%;margin-bottom:2px;"></div>
              <div style="height:4px;border-radius:3px;background:#f59e0b;width:44%;margin-top:6px;margin-bottom:5px;"></div>
              <div style="display:flex;gap:3px;">
                <div style="height:14px;border-radius:3px;background:#fef3c7;border:1px solid #fde68a;flex:1;"></div>
                <div style="height:14px;border-radius:3px;background:#fef3c7;border:1px solid #fde68a;flex:1;"></div>
                <div style="height:14px;border-radius:3px;background:#fef3c7;border:1px solid #fde68a;flex:1;"></div>
              </div>
            </div>
          </div>
          <div class="tpl-badge" style="background:linear-gradient(135deg,#f59e0b,#f97316);" data-i18n="cv_tpl1_badge"><?= __("cv_tpl1_badge") ?></div>
          <div class="tpl-selected-check">✓</div>
        </div>
        <div class="template-card-body">
          <div class="template-name" data-i18n="cv_tpl1_name"><?= __("cv_tpl1_name") ?></div>
          <div class="template-desc" data-i18n="cv_tpl1_desc"><?= __("cv_tpl1_desc") ?></div>
          <div class="template-tags">
            <span class="tpl-tag" data-i18n="cv_tpl1_tag1"><?= __("cv_tpl1_tag1") ?></span><span class="tpl-tag" data-i18n="cv_tpl1_tag2"><?= __("cv_tpl1_tag2") ?></span>
          </div>
          <div class="template-card-actions">
            <button class="tpl-select-btn tpl-select-btn-default" id="tpl-1-btn" onclick="selectTemplate('tpl-1','Professional Elite')" data-i18n="cv_tpl_btn_select"><?= __("cv_tpl_btn_select") ?></button>
            <button class="tpl-preview-btn" onclick="openPreviewModal('tpl-1')" data-i18n="cv_tpl_btn_preview">👁️ <?= __("cv_btn_preview") ?></button>
          </div>
        </div>
      </div>

      <!-- Template 2: Müasir Texnoloji -->
      <div class="template-card" id="tpl-2">
        <div class="template-preview" onclick="openPreviewModal('tpl-2')" style="background:linear-gradient(160deg,rgba(56,189,248,0.12) 0%,rgba(15,23,42,0.95) 100%);">
          <div class="tpl-doc-ghost" style="background:linear-gradient(180deg,#0f172a 30%,#38bdf822 100%);"></div>
          <div class="tpl-doc">
            <!-- Dark tech header -->
            <div style="background:#0f172a;padding:10px 9px 8px;position:relative;">
              <div style="position:absolute;left:0;top:0;bottom:0;width:3px;background:#38bdf8;border-radius:0;"></div>
              <div style="height:5px;border-radius:3px;background:#38bdf8;width:70%;margin-bottom:3px;"></div>
              <div style="height:3px;border-radius:3px;background:rgba(56,189,248,0.4);width:52%;margin-bottom:5px;"></div>
              <div style="display:flex;gap:4px;">
                <div style="height:3px;border-radius:2px;background:rgba(56,189,248,0.25);flex:1;"></div>
                <div style="height:3px;border-radius:2px;background:rgba(56,189,248,0.25);flex:1;"></div>
                <div style="height:3px;border-radius:2px;background:rgba(56,189,248,0.25);flex:1;"></div>
              </div>
            </div>
            <!-- Body with chips -->
            <div style="padding:7px 8px;background:#f8fafc;">
              <div style="height:3.5px;border-radius:3px;background:#38bdf8;width:40%;margin-bottom:4px;"></div>
              <div style="height:2.5px;background:#e2e8f0;width:100%;margin-bottom:2px;border-radius:2px;"></div>
              <div style="height:2.5px;background:#e2e8f0;width:75%;margin-bottom:5px;border-radius:2px;"></div>
              <div style="display:flex;gap:3px;margin-bottom:5px;">
                <div style="height:10px;border-radius:4px;background:#e0f2fe;border:1px solid #bae6fd;width:30px;"></div>
                <div style="height:10px;border-radius:4px;background:#e0f2fe;border:1px solid #bae6fd;width:24px;"></div>
                <div style="height:10px;border-radius:4px;background:#e0f2fe;border:1px solid #bae6fd;width:28px;"></div>
              </div>
              <div style="height:3.5px;border-radius:3px;background:#6366f1;width:40%;margin-bottom:4px;"></div>
              <div style="height:2.5px;background:#e2e8f0;width:100%;margin-bottom:2px;border-radius:2px;"></div>
              <div style="height:2.5px;background:#e2e8f0;width:85%;margin-bottom:2px;border-radius:2px;"></div>
              <div style="height:2.5px;background:#e2e8f0;width:60%;border-radius:2px;"></div>
            </div>
          </div>
          <div class="tpl-badge" style="background:#38bdf8;color:#0f172a;" data-i18n="cv_tpl2_badge"><?= __("cv_tpl2_badge") ?></div>
          <div class="tpl-selected-check">✓</div>
        </div>
        <div class="template-card-body">
          <div class="template-name" data-i18n="cv_tpl2_name"><?= __("cv_tpl2_name") ?></div>
          <div class="template-desc" data-i18n="cv_tpl2_desc"><?= __("cv_tpl2_desc") ?></div>
          <div class="template-tags">
            <span class="tpl-tag" data-i18n="cv_tpl2_tag1"><?= __("cv_tpl2_tag1") ?></span><span class="tpl-tag" data-i18n="cv_tpl2_tag2"><?= __("cv_tpl2_tag2") ?></span>
          </div>
          <div class="template-card-actions">
            <button class="tpl-select-btn tpl-select-btn-default" id="tpl-2-btn" onclick="selectTemplate('tpl-2','Müasir Texnoloji')" data-i18n="cv_tpl_btn_select"><?= __("cv_tpl_btn_select") ?></button>
            <button class="tpl-preview-btn" onclick="openPreviewModal('tpl-2')" data-i18n="cv_tpl_btn_preview">👁️ <?= __("cv_btn_preview") ?></button>
          </div>
        </div>
      </div>

      <!-- Template 3: Kreativ Premium -->
      <div class="template-card" id="tpl-3">
        <div class="template-preview" onclick="openPreviewModal('tpl-3')" style="background:linear-gradient(160deg,rgba(244,63,94,0.12) 0%,rgba(139,92,246,0.12) 100%);">
          <div class="tpl-doc-ghost" style="background:linear-gradient(135deg,#f43f5e44,#8b5cf644);"></div>
          <div class="tpl-doc" style="overflow:hidden;">
            <!-- Gradient header -->
            <div style="background:linear-gradient(135deg,#f43f5e,#8b5cf6);padding:12px 9px 10px;">
              <div style="width:26px;height:26px;border-radius:50%;background:rgba(255,255,255,0.3);margin-bottom:5px;"></div>
              <div style="height:5px;border-radius:3px;background:#fff;width:72%;margin-bottom:3px;"></div>
              <div style="height:3px;border-radius:3px;background:rgba(255,255,255,0.5);width:50%;"></div>
            </div>
            <!-- Body -->
            <div style="padding:7px 8px;background:#fdf2f8;">
              <div style="height:3.5px;border-radius:3px;background:#f43f5e;width:38%;margin-bottom:4px;"></div>
              <div style="height:2.5px;background:#fce7f3;width:100%;margin-bottom:2px;border-radius:2px;"></div>
              <div style="height:2.5px;background:#fce7f3;width:80%;margin-bottom:5px;border-radius:2px;"></div>
              <!-- Skill bars -->
              <div style="height:3.5px;border-radius:3px;background:#8b5cf6;width:38%;margin-bottom:4px;"></div>
              <div style="margin-bottom:3px;">
                <div style="height:4px;background:#f3e8ff;border-radius:4px;overflow:hidden;margin-bottom:3px;"><div style="width:85%;height:100%;background:linear-gradient(90deg,#f43f5e,#8b5cf6);border-radius:4px;"></div></div>
                <div style="height:4px;background:#f3e8ff;border-radius:4px;overflow:hidden;margin-bottom:3px;"><div style="width:70%;height:100%;background:linear-gradient(90deg,#f43f5e,#8b5cf6);border-radius:4px;"></div></div>
                <div style="height:4px;background:#f3e8ff;border-radius:4px;overflow:hidden;"><div style="width:60%;height:100%;background:linear-gradient(90deg,#f43f5e,#8b5cf6);border-radius:4px;"></div></div>
              </div>
            </div>
          </div>
          <div class="tpl-badge" style="background:linear-gradient(135deg,#f43f5e,#8b5cf6);" data-i18n="cv_tpl3_badge"><?= __("cv_tpl3_badge") ?></div>
          <div class="tpl-selected-check">✓</div>
        </div>
        <div class="template-card-body">
          <div class="template-name" data-i18n="cv_tpl3_name"><?= __("cv_tpl3_name") ?></div>
          <div class="template-desc" data-i18n="cv_tpl3_desc"><?= __("cv_tpl3_desc") ?></div>
          <div class="template-tags">
            <span class="tpl-tag" data-i18n="cv_tpl3_tag1"><?= __("cv_tpl3_tag1") ?></span><span class="tpl-tag" data-i18n="cv_tpl3_tag2"><?= __("cv_tpl3_tag2") ?></span>
          </div>
          <div class="template-card-actions">
            <button class="tpl-select-btn tpl-select-btn-default" id="tpl-3-btn" onclick="selectTemplate('tpl-3','Kreativ Premium')" data-i18n="cv_tpl_btn_select"><?= __("cv_tpl_btn_select") ?></button>
            <button class="tpl-preview-btn" onclick="openPreviewModal('tpl-3')" data-i18n="cv_tpl_btn_preview">👁️ <?= __("cv_btn_preview") ?></button>
          </div>
        </div>
      </div>

      <!-- Template 4: Modern Minimalist -->
      <div class="template-card" id="tpl-4">
        <div class="template-preview" onclick="openPreviewModal('tpl-4')" style="background:linear-gradient(160deg,rgba(16,185,129,0.12) 0%,rgba(15,23,42,0.95) 100%);">
          <div class="tpl-doc-ghost" style="background:linear-gradient(180deg,#064e3b 30%,#10b98122 100%);"></div>
          <div class="tpl-doc" style="border-top:4px solid #10b981;">
            <!-- Header -->
            <div style="padding:8px 9px 6px;background:#fff;border-bottom:1px solid #d1fae5;display:flex;justify-content:space-between;align-items:flex-start;">
              <div>
                <div style="height:5px;border-radius:3px;background:#064e3b;width:68px;margin-bottom:3px;"></div>
                <div style="height:3px;border-radius:3px;background:#10b981;width:48px;"></div>
              </div>
              <div style="text-align:right;">
                <div style="height:2.5px;border-radius:2px;background:#d1fae5;width:32px;margin-bottom:2px;"></div>
                <div style="height:2.5px;border-radius:2px;background:#d1fae5;width:28px;"></div>
              </div>
            </div>
            <!-- Body -->
            <div style="padding:7px 8px;background:#f0fdf4;">
              <div style="height:3px;border-radius:2px;background:#10b981;width:42%;margin-bottom:4px;display:inline-block;"></div>
              <div style="height:2.5px;background:#dcfce7;width:100%;margin-bottom:2px;border-radius:2px;"></div>
              <div style="height:2.5px;background:#dcfce7;width:80%;margin-bottom:2px;border-radius:2px;"></div>
              <div style="height:2.5px;background:#dcfce7;width:90%;margin-bottom:5px;border-radius:2px;"></div>
              <div style="height:3px;border-radius:2px;background:#059669;width:42%;margin-bottom:4px;display:inline-block;"></div>
              <div style="height:2.5px;background:#dcfce7;width:100%;margin-bottom:2px;border-radius:2px;"></div>
              <div style="height:2.5px;background:#dcfce7;width:65%;border-radius:2px;"></div>
            </div>
          </div>
          <div class="tpl-badge" style="background:#10b981;" data-i18n="cv_tpl4_badge"><?= __("cv_tpl4_badge") ?></div>
          <div class="tpl-selected-check">✓</div>
        </div>
        <div class="template-card-body">
          <div class="template-name" data-i18n="cv_tpl4_name"><?= __("cv_tpl4_name") ?></div>
          <div class="template-desc" data-i18n="cv_tpl4_desc"><?= __("cv_tpl4_desc") ?></div>
          <div class="template-tags">
            <span class="tpl-tag" data-i18n="cv_tpl4_tag1"><?= __("cv_tpl4_tag1") ?></span><span class="tpl-tag" data-i18n="cv_tpl4_tag2"><?= __("cv_tpl4_tag2") ?></span>
          </div>
          <div class="template-card-actions">
            <button class="tpl-select-btn tpl-select-btn-default" id="tpl-4-btn" onclick="selectTemplate('tpl-4','Modern Minimalist')" data-i18n="cv_tpl_btn_select"><?= __("cv_tpl_btn_select") ?></button>
            <button class="tpl-preview-btn" onclick="openPreviewModal('tpl-4')" data-i18n="cv_tpl_btn_preview">👁️ <?= __("cv_btn_preview") ?></button>
          </div>
        </div>
      </div>

      <!-- Template 5: Gənc Start -->
      <div class="template-card" id="tpl-5">
        <div class="template-preview" onclick="openPreviewModal('tpl-5')" style="background:linear-gradient(160deg,rgba(99,102,241,0.14) 0%,rgba(139,92,246,0.1) 100%);">
          <div class="tpl-doc-ghost" style="background:linear-gradient(180deg,#4338ca 30%,#8b5cf622 100%);"></div>
          <div class="tpl-doc">
            <!-- Indigo header -->
            <div style="background:#4338ca;padding:10px 9px 8px;">
              <div style="display:flex;align-items:center;gap:5px;">
                <div style="width:20px;height:20px;border-radius:50%;background:#a5b4fc;flex-shrink:0;"></div>
                <div style="flex:1;">
                  <div style="height:4px;border-radius:3px;background:#a5b4fc;width:65%;margin-bottom:3px;"></div>
                  <div style="height:3px;border-radius:3px;background:rgba(165,180,252,0.4);width:48%;"></div>
                </div>
              </div>
            </div>
            <!-- Two-column body -->
            <div style="display:grid;grid-template-columns:1fr 1.8fr;background:#f5f3ff;">
              <!-- Sidebar -->
              <div style="padding:6px 5px;border-right:1px solid #e0e7ff;">
                <div style="height:3px;border-radius:2px;background:#6366f1;width:80%;margin-bottom:4px;"></div>
                <div style="height:2px;background:#e0e7ff;width:100%;margin-bottom:2px;border-radius:2px;"></div>
                <div style="height:2px;background:#e0e7ff;width:80%;margin-bottom:4px;border-radius:2px;"></div>
                <div style="height:3px;border-radius:2px;background:#8b5cf6;width:80%;margin-bottom:4px;"></div>
                <div style="height:2px;background:#e0e7ff;width:90%;margin-bottom:2px;border-radius:2px;"></div>
                <div style="height:2px;background:#e0e7ff;width:70%;border-radius:2px;"></div>
              </div>
              <!-- Main -->
              <div style="padding:6px;">
                <div style="height:3px;border-radius:2px;background:#4338ca;width:50%;margin-bottom:4px;"></div>
                <div style="height:2px;background:#ddd6fe;width:100%;margin-bottom:2px;border-radius:2px;"></div>
                <div style="height:2px;background:#ddd6fe;width:85%;margin-bottom:2px;border-radius:2px;"></div>
                <div style="height:2px;background:#ddd6fe;width:70%;margin-bottom:4px;border-radius:2px;"></div>
                <div style="height:3px;border-radius:2px;background:#4338ca;width:50%;margin-bottom:4px;"></div>
                <div style="height:2px;background:#ddd6fe;width:100%;margin-bottom:2px;border-radius:2px;"></div>
                <div style="height:2px;background:#ddd6fe;width:60%;border-radius:2px;"></div>
              </div>
            </div>
          </div>
          <div class="tpl-badge" style="background:#6366f1;" data-i18n="cv_tpl5_badge"><?= __("cv_tpl5_badge") ?></div>
          <div class="tpl-selected-check">✓</div>
        </div>
        <div class="template-card-body">
          <div class="template-name" data-i18n="cv_tpl5_name"><?= __("cv_tpl5_name") ?></div>
          <div class="template-desc" data-i18n="cv_tpl5_desc"><?= __("cv_tpl5_desc") ?></div>
          <div class="template-tags">
            <span class="tpl-tag" data-i18n="cv_tpl5_tag1"><?= __("cv_tpl5_tag1") ?></span><span class="tpl-tag" data-i18n="cv_tpl5_tag2"><?= __("cv_tpl5_tag2") ?></span>
          </div>
          <div class="template-card-actions">
            <button class="tpl-select-btn tpl-select-btn-default" id="tpl-5-btn" onclick="selectTemplate('tpl-5','Gənc Start')" data-i18n="cv_tpl_btn_select"><?= __("cv_tpl_btn_select") ?></button>
            <button class="tpl-preview-btn" onclick="openPreviewModal('tpl-5')" data-i18n="cv_tpl_btn_preview">👁️ <?= __("cv_btn_preview") ?></button>
          </div>
        </div>
      </div>

      <!-- Template 6: ATS-Friendly -->
      <div class="template-card" id="tpl-6">
        <div class="template-preview" onclick="openPreviewModal('tpl-6')" style="background:linear-gradient(160deg,rgba(6,182,212,0.14) 0%,rgba(15,23,42,0.95) 100%);">
          <div class="tpl-doc-ghost" style="background:linear-gradient(180deg,#164e63 30%,#06b6d422 100%);"></div>
          <div class="tpl-doc">
            <!-- Clean white header -->
            <div style="background:#fff;padding:10px 9px 6px;border-bottom:3px solid #06b6d4;">
              <div style="height:5px;border-radius:3px;background:#0e7490;width:75%;margin-bottom:3px;"></div>
              <div style="height:3px;border-radius:3px;background:#a5f3fc;width:55%;margin-bottom:5px;"></div>
              <div style="display:flex;gap:4px;">
                <div style="height:2.5px;border-radius:2px;background:#cffafe;flex:1;"></div>
                <div style="height:2.5px;border-radius:2px;background:#cffafe;flex:1;"></div>
                <div style="height:2.5px;border-radius:2px;background:#cffafe;flex:1;"></div>
              </div>
            </div>
            <!-- ATS body: plain text sections, no columns, no colors -->
            <div style="padding:7px 8px;background:#fff;">
              <!-- Section 1 -->
              <div style="height:3.5px;border-radius:2px;background:#0e7490;width:48%;margin-bottom:4px;"></div>
              <div style="height:2.5px;background:#e2e8f0;width:100%;margin-bottom:2px;border-radius:2px;"></div>
              <div style="height:2.5px;background:#e2e8f0;width:88%;margin-bottom:2px;border-radius:2px;"></div>
              <div style="height:2.5px;background:#e2e8f0;width:94%;margin-bottom:5px;border-radius:2px;"></div>
              <!-- Section 2 -->
              <div style="height:3.5px;border-radius:2px;background:#0e7490;width:48%;margin-bottom:4px;"></div>
              <div style="height:2.5px;background:#e2e8f0;width:100%;margin-bottom:2px;border-radius:2px;"></div>
              <div style="height:2.5px;background:#e2e8f0;width:76%;margin-bottom:5px;border-radius:2px;"></div>
              <!-- Keyword chips row -->
              <div style="height:3.5px;border-radius:2px;background:#0e7490;width:48%;margin-bottom:4px;"></div>
              <div style="display:flex;gap:2px;flex-wrap:wrap;">
                <div style="height:9px;border-radius:3px;background:#ecfeff;border:1px solid #a5f3fc;width:22px;"></div>
                <div style="height:9px;border-radius:3px;background:#ecfeff;border:1px solid #a5f3fc;width:26px;"></div>
                <div style="height:9px;border-radius:3px;background:#ecfeff;border:1px solid #a5f3fc;width:20px;"></div>
                <div style="height:9px;border-radius:3px;background:#ecfeff;border:1px solid #a5f3fc;width:24px;"></div>
              </div>
            </div>
          </div>
          <div class="tpl-badge" style="background:linear-gradient(135deg,#06b6d4,#0e7490);" data-i18n="cv_tpl6_badge"><?= __("cv_tpl6_badge") ?></div>
          <div class="tpl-selected-check">✓</div>
        </div>
        <div class="template-card-body">
          <div class="template-name" data-i18n="cv_tpl6_name"><?= __("cv_tpl6_name") ?></div>
          <div class="template-desc" data-i18n="cv_tpl6_desc"><?= __("cv_tpl6_desc") ?></div>
          <div class="template-tags">
            <span class="tpl-tag" data-i18n="cv_tpl6_tag1"><?= __("cv_tpl6_tag1") ?></span><span class="tpl-tag" data-i18n="cv_tpl6_tag2"><?= __("cv_tpl6_tag2") ?></span>
          </div>
          <div class="template-card-actions">
            <button class="tpl-select-btn tpl-select-btn-default" id="tpl-6-btn" onclick="selectTemplate('tpl-6','ATS-Friendly Pro')" data-i18n="cv_tpl_btn_select"><?= __("cv_tpl_btn_select") ?></button>
            <button class="tpl-preview-btn" onclick="openPreviewModal('tpl-6')" data-i18n="cv_tpl_btn_preview">👁️ <?= __("cv_btn_preview") ?></button>
          </div>
        </div>
      </div>

    </div><!-- /templates-grid -->

    <!-- Focused Active Template Workspace Bar (displayed when a template is chosen) -->
    <div class="active-template-workspace-bar" id="activeTemplateWorkspaceBar">
      <div class="active-tpl-content">
        <div class="active-tpl-left">
          <div class="active-tpl-icon-box" id="activeBarEmoji">💼</div>
          <div>
            <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;">
              <span class="active-tpl-badge" id="activeBarBadge" data-i18n="cv_active_tpl_badge"><?= __("cv_active_tpl_badge") ?></span>
              <span id="activeTplPhotoStatus" style="font-size:0.75rem;color:#38bdf8;font-weight:600;" data-i18n="cv_active_photo_supported"><?= __("cv_active_photo_supported") ?></span>
            </div>
            <div class="active-tpl-title" id="activeBarName">Professional Elite</div>
            <div class="active-tpl-desc" id="activeBarDesc">Bank, hüquq, idarəçilik və dövlət qurumları üçün ATS-uyğun şablon.</div>
          </div>
        </div>
        <div class="active-tpl-controls">
          <button class="btn-control-back" onclick="backToTemplates()" title="Bütün şablonları yenidən göstər">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span data-i18n="cv_btn_back_templates"><?= __("cv_btn_back_templates") ?></span>
          </button>
          <button class="btn-control-cancel" onclick="cancelTemplateSelection()" title="Şablon seçimini ləğv et">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            <span data-i18n="cv_btn_cancel_template"><?= __("cv_btn_cancel_template") ?></span>
          </button>
          <button class="btn-control-preview" onclick="openActivePreviewModal()" title="Canlı görünüşü böyük ekranda aç">
            <span data-i18n="cv_btn_active_preview">👁️ <?= __("cv_btn_preview") ?></span>
          </button>
        </div>
      </div>
    </div>

    <!-- CV Builder Form -->
    <div class="cv-builder-section" id="cv-builder">
      <div class="cv-builder-title" data-i18n="cv_form_title"><?= __("cv_form_title") ?></div>
      <div class="cv-builder-desc" data-i18n="cv_form_subtitle"><?= __("cv_form_subtitle") ?></div>

      <div class="cv-tabs" role="tablist" aria-label="CV bölmələri">
        <button class="cv-tab active" role="tab" id="tab-btn-personal" onclick="showTab(this,'tab-personal')" aria-selected="true" data-i18n="cv_tab_personal"><?= __("cv_tab_personal") ?></button>
        <button class="cv-tab" role="tab" id="tab-btn-exp" onclick="showTab(this,'tab-exp')" aria-selected="false" data-i18n="cv_tab_exp"><?= __("cv_tab_exp") ?></button>
        <button class="cv-tab" role="tab" id="tab-btn-edu" onclick="showTab(this,'tab-edu')" aria-selected="false" data-i18n="cv_tab_edu"><?= __("cv_tab_edu") ?></button>
        <button class="cv-tab" role="tab" id="tab-btn-skills" onclick="showTab(this,'tab-skills')" aria-selected="false" data-i18n="cv_tab_skills"><?= __("cv_tab_skills") ?></button>
        <button class="cv-tab" role="tab" id="tab-btn-extra" onclick="showTab(this,'tab-extra')" aria-selected="false" data-i18n="cv_tab_extra"><?= __("cv_tab_extra") ?></button>
      </div>

      <!-- Personal -->
      <div class="cv-tab-panel active" id="tab-personal" role="tabpanel">
        
        <!-- Standard 3x4 Profile Picture Upload Box -->
        <div class="cv-photo-section">
          <!-- Hidden file input -->
          <input type="file" id="cv-photo-input" accept="image/png, image/jpeg, image/webp" style="display:none" onchange="handlePhotoUpload(event)">
          
          <div class="cv-photo-uploader-box" id="cvPhotoBox" onclick="triggerPhotoPicker()" title="3x4 Standart Profil Şəkli Yüklə">
            <div class="cv-photo-placeholder" id="cv-photo-placeholder">
              <div class="cv-photo-icon-wrap">📸</div>
              <div class="cv-photo-upload-text" data-i18n="cv_photo_upload"><?= __("cv_photo_upload") ?></div>
              <div class="cv-photo-subtext" data-i18n="cv_photo_aspect_subtext"><?= __("cv_photo_aspect_subtext") ?></div>
            </div>
            <img id="cv-photo-preview-img" class="cv-photo-preview-img" alt="CV 3x4 Profil Şəkli">
            <div class="cv-photo-overlay" id="cv-photo-overlay">
              <button type="button" class="cv-photo-change-btn" onclick="triggerPhotoPicker(event)" data-i18n="cv_photo_change"><?= __("cv_photo_change") ?></button>
              <button type="button" class="cv-photo-delete-btn" onclick="removePhoto(event)" data-i18n="cv_photo_remove"><?= __("cv_photo_remove") ?></button>
            </div>
          </div>

          <div class="cv-photo-info">
            <span class="cv-photo-badge" data-i18n="cv_photo_badge_title"><?= __("cv_photo_badge_title") ?></span>
            <div class="cv-photo-title" data-i18n="cv_photo_main_title"><?= __("cv_photo_main_title") ?></div>
            <p class="cv-photo-desc" data-i18n="cv_photo_desc_text"><?= __("cv_photo_desc_text") ?></p>
            <div class="cv-photo-template-status" id="cvPhotoTemplateNotice">
              <span>✨</span>
              <span id="photoNoticeText" data-i18n="cv_photo_notice_text"><?= __("cv_photo_notice_text") ?></span>
            </div>
          </div>
        </div>

        <div class="cv-form-grid">
          <div class="form-group">
            <label class="form-label" for="cv-fname" data-i18n="cv_label_fname"><?= __("cv_label_fname") ?></label>
            <input class="form-input" id="cv-fname" type="text" placeholder="<?= __("cv_ph_fname") ?>" data-i18n-placeholder="cv_ph_fname" autocomplete="given-name">
          </div>
          <div class="form-group">
            <label class="form-label" for="cv-lname" data-i18n="cv_label_lname"><?= __("cv_label_lname") ?></label>
            <input class="form-input" id="cv-lname" type="text" placeholder="<?= __("cv_ph_lname") ?>" data-i18n-placeholder="cv_ph_lname" autocomplete="family-name">
          </div>
          <div class="form-group">
            <label class="form-label" for="cv-role" data-i18n="cv_label_role"><?= __("cv_label_role") ?></label>
            <input class="form-input" id="cv-role" type="text" placeholder="<?= __("cv_ph_role") ?>" data-i18n-placeholder="cv_ph_role">
          </div>
          <div class="form-group">
            <label class="form-label" for="cv-phone" data-i18n="cv_label_phone"><?= __("cv_label_phone") ?></label>
            <input class="form-input" id="cv-phone" type="tel" placeholder="+994 55 xxx xx xx" autocomplete="tel">
          </div>
          <div class="form-group">
            <label class="form-label" for="cv-email" data-i18n="cv_label_email"><?= __("cv_label_email") ?></label>
            <input class="form-input" id="cv-email" type="email" placeholder="ali@example.com" autocomplete="email">
          </div>
          <div class="form-group">
            <label class="form-label" for="cv-city" data-i18n="cv_label_city"><?= __("cv_label_city") ?></label>
            <input class="form-input" id="cv-city" type="text" placeholder="<?= __("cv_ph_city") ?>" data-i18n-placeholder="cv_ph_city" autocomplete="address-level2">
          </div>
          <div class="form-group">
            <label class="form-label" for="cv-linkedin" data-i18n="cv_label_linkedin"><?= __("cv_label_linkedin") ?></label>
            <input class="form-input" id="cv-linkedin" type="url" placeholder="linkedin.com/in/adınız">
          </div>
          <div class="form-group">
            <label class="form-label" for="cv-portfolio" data-i18n="cv_label_portfolio"><?= __("cv_label_portfolio") ?></label>
            <input class="form-input" id="cv-portfolio" type="url" placeholder="github.com/adınız">
          </div>
          <div class="form-group form-full">
            <label class="form-label" for="cv-summary" data-i18n="cv_label_summary"><?= __("cv_label_summary") ?></label>
            <textarea class="form-textarea" id="cv-summary" placeholder="<?= __("cv_ph_summary") ?>" data-i18n-placeholder="cv_ph_summary"></textarea>
          </div>
        </div>
      </div>

      <!-- Experience -->
      <div class="cv-tab-panel" id="tab-exp" role="tabpanel">
        <div id="exp-list">
          <div class="exp-item">
            <div class="exp-item-header">
              <span class="exp-item-title"><span data-i18n="cv_experience"><?= __("cv_experience") ?></span> #1</span>
              <button class="exp-remove-btn" onclick="removeItem(this)" data-i18n="cv_btn_delete_item"><?= __("cv_btn_delete_item") ?></button>
            </div>
            <div class="cv-form-grid">
              <div class="form-group">
                <label class="form-label" data-i18n="cv_label_company"><?= __("cv_label_company") ?></label>
                <input class="form-input" type="text" placeholder="<?= __("cv_ph_company") ?>" data-i18n-placeholder="cv_ph_company">
              </div>
              <div class="form-group">
                <label class="form-label" data-i18n="cv_label_position"><?= __("cv_label_position") ?></label>
                <input class="form-input" type="text" placeholder="<?= __("cv_ph_position") ?>" data-i18n-placeholder="cv_ph_position">
              </div>
              <div class="form-group">
                <label class="form-label" data-i18n="cv_label_start_date"><?= __("cv_label_start_date") ?></label>
                <input class="form-input" type="month">
              </div>
              <div class="form-group">
                <label class="form-label" data-i18n="cv_label_end_date"><?= __("cv_label_end_date") ?></label>
                <input class="form-input" type="month">
              </div>
              <div class="form-group form-full">
                <label class="form-label" data-i18n="cv_label_duties"><?= __("cv_label_duties") ?></label>
                <textarea class="form-textarea" placeholder="<?= __("cv_ph_duties") ?>" data-i18n-placeholder="cv_ph_duties" style="min-height:80px;"></textarea>
              </div>
            </div>
          </div>
        </div>
        <button class="add-item-btn" onclick="addExpItem()" data-i18n="cv_add_exp"><?= __("cv_add_exp") ?></button>
      </div>

      <!-- Education -->
      <div class="cv-tab-panel" id="tab-edu" role="tabpanel">
        <div id="edu-list">
          <div class="exp-item">
            <div class="exp-item-header">
              <span class="exp-item-title"><span data-i18n="cv_education"><?= __("cv_education") ?></span> #1</span>
              <button class="exp-remove-btn" onclick="removeItem(this)" data-i18n="cv_btn_delete_item"><?= __("cv_btn_delete_item") ?></button>
            </div>
            <div class="cv-form-grid">
              <div class="form-group">
                <label class="form-label" data-i18n="cv_label_school"><?= __("cv_label_school") ?></label>
                <input class="form-input" type="text" placeholder="<?= __("cv_ph_school") ?>" data-i18n-placeholder="cv_ph_school">
              </div>
              <div class="form-group">
                <label class="form-label" data-i18n="cv_label_major"><?= __("cv_label_major") ?></label>
                <input class="form-input" type="text" placeholder="<?= __("cv_ph_major") ?>" data-i18n-placeholder="cv_ph_major">
              </div>
              <div class="form-group">
                <label class="form-label" data-i18n="cv_label_degree"><?= __("cv_label_degree") ?></label>
                <select class="form-select">
                  <option value="" data-i18n="select_choose"><?= __("select_choose") ?></option>
                  <option data-i18n="cv_degree_bachelor"><?= __("cv_degree_bachelor") ?></option>
                  <option data-i18n="cv_degree_master"><?= __("cv_degree_master") ?></option>
                  <option data-i18n="cv_degree_phd"><?= __("cv_degree_phd") ?></option>
                  <option data-i18n="cv_degree_secondary"><?= __("cv_degree_secondary") ?></option>
                  <option data-i18n="cv_degree_certificate"><?= __("cv_degree_certificate") ?></option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label" data-i18n="cv_label_grad_year"><?= __("cv_label_grad_year") ?></label>
                <input class="form-input" type="number" min="1990" max="2030" placeholder="2024">
              </div>
              <div class="form-group form-full">
                <label class="form-label" data-i18n="cv_label_note"><?= __("cv_label_note") ?></label>
                <input class="form-input" type="text" placeholder="<?= __("cv_ph_note") ?>" data-i18n-placeholder="cv_ph_note">
              </div>
            </div>
          </div>
        </div>
        <button class="add-item-btn" onclick="addEduItem()" data-i18n="cv_add_edu"><?= __("cv_add_edu") ?></button>
      </div>

      <!-- Skills -->
      <div class="cv-tab-panel" id="tab-skills" role="tabpanel">
        <div class="form-group" style="max-width:600px;">
          <label class="form-label" data-i18n="cv_sec_languages"><?= __("cv_sec_languages") ?></label>
          <div id="lang-list" style="display:flex;flex-direction:column;gap:0.75rem;margin-bottom:0.75rem;">
            <div style="display:grid;grid-template-columns:1fr 1fr auto;gap:0.65rem;align-items:end;">
              <div><label class="form-label" style="font-size:0.73rem;" data-i18n="cv_sublabel_lang"><?= __("cv_sublabel_lang") ?></label><input class="form-input" type="text" value="Azərbaycanca" placeholder="Dil"></div>
              <div><label class="form-label" style="font-size:0.73rem;" data-i18n="cv_sublabel_level"><?= __("cv_sublabel_level") ?></label><select class="form-select"><option>Ana dili</option><option>C2 — Mükəmməl</option><option>C1 — İləri</option><option>B2 — Yüksək orta</option><option>B1 — Orta</option><option>A2 — Başlanğıc</option></select></div>
              <div style="padding-bottom:0.05rem;"><button class="exp-remove-btn" onclick="this.closest('div').parentElement.remove()">✕</button></div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr auto;gap:0.65rem;align-items:end;">
              <div><label class="form-label" style="font-size:0.73rem;" data-i18n="cv_sublabel_lang"><?= __("cv_sublabel_lang") ?></label><input class="form-input" type="text" value="İngilis dili" placeholder="Dil"></div>
              <div><label class="form-label" style="font-size:0.73rem;" data-i18n="cv_sublabel_level"><?= __("cv_sublabel_level") ?></label><select class="form-select"><option>Ana dili</option><option>C2 — Mükəmməl</option><option selected>C1 — İləri</option><option>B2 — Yüksək orta</option><option>B1 — Orta</option><option>A2 — Başlanğıc</option></select></div>
              <div><button class="exp-remove-btn" onclick="this.closest('div').parentElement.remove()">✕</button></div>
            </div>
          </div>
          <button class="add-item-btn" onclick="addLang()" data-i18n="cv_add_lang"><?= __("cv_add_lang") ?></button>
        </div>

        <div class="form-group" style="max-width:600px;margin-top:1.5rem;">
          <label class="form-label" data-i18n="cv_sec_tech_skills"><?= __("cv_sec_tech_skills") ?></label>
          <div class="skills-row" id="skills-chips">
            <span class="skill-chip">Microsoft Office <button onclick="this.closest('.skill-chip').remove()">×</button></span>
            <span class="skill-chip">Excel <button onclick="this.closest('.skill-chip').remove()">×</button></span>
          </div>
          <div class="skill-tag-inp" style="margin-top:0.5rem;">
            <input class="form-input" id="skill-input" type="text" placeholder="<?= __("cv_ph_add_skill") ?>" data-i18n-placeholder="cv_ph_add_skill" style="max-width:280px;" onkeydown="if(event.key==='Enter'){event.preventDefault();addSkill();}">
            <button class="add-item-btn" onclick="addSkill()" style="white-space:nowrap;" data-i18n="cv_btn_add_skill"><?= __("cv_btn_add_skill") ?></button>
          </div>
        </div>
      </div>

      <!-- Extra -->
      <div class="cv-tab-panel" id="tab-extra" role="tabpanel">
        <div class="cv-form-grid">
          <div class="form-group">
            <label class="form-label" for="cv-cert" data-i18n="cv_label_certifications"><?= __("cv_label_certifications") ?></label>
            <textarea class="form-textarea" id="cv-cert" placeholder="Google Analytics, Coursera Python, AWS..."></textarea>
          </div>
          <div class="form-group">
            <label class="form-label" for="cv-awards" data-i18n="cv_label_awards"><?= __("cv_label_awards") ?></label>
            <textarea class="form-textarea" id="cv-awards" placeholder="Müsabiqə qalibləri, 'Ay İşçisi' mükafatı..."></textarea>
          </div>
          <div class="form-group">
            <label class="form-label" for="cv-volunteer" data-i18n="cv_label_volunteer"><?= __("cv_label_volunteer") ?></label>
            <textarea class="form-textarea" id="cv-volunteer" placeholder="AIESEC, Rotaract, ictimai layihələr..."></textarea>
          </div>
          <div class="form-group">
            <label class="form-label" for="cv-lang-pref" data-i18n="cv_label_cv_lang_pref"><?= __("cv_label_cv_lang_pref") ?></label>
            <select class="form-select" id="cv-lang-pref">
              <option value="az" data-i18n="cv_pref_az"><?= __("cv_pref_az") ?></option>
              <option value="en" data-i18n="cv_pref_en"><?= __("cv_pref_en") ?></option>
              <option value="az-en" data-i18n="cv_pref_bilingual"><?= __("cv_pref_bilingual") ?></option>
              <option value="ru" data-i18n="cv_pref_ru"><?= __("cv_pref_ru") ?></option>
            </select>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="cv-actions">
        <button class="btn-ghost" style="color:var(--neon-amber);border-color:rgba(245,158,11,0.3);" onclick="saveProgress()" data-i18n="cv_btn_save_progress"><?= __("cv_btn_save_progress") ?></button>
        <button class="btn-primary" style="background:linear-gradient(135deg,var(--neon-amber),#f97316);" onclick="submitCVOrder()" data-i18n="cv_btn_download_pdf"><?= __("cv_btn_download_pdf") ?></button>
      </div>
    </div>

    <!-- Info Banner (pricing placeholder) -->
    <div class="cv-info-banner">
      <div class="cv-info-icon">💡</div>
      <div>
        <div class="cv-info-title" data-i18n="cv_info_banner_title"><?= __("cv_info_banner_title") ?></div>
        <p class="cv-info-text" data-i18n="cv_info_banner_text"><?= __("cv_info_banner_text") ?></p>
      </div>
    </div>

    <!-- Preview Modal -->
    <div class="preview-modal" id="tplPreviewModal" onclick="if(event.target===this) closePreviewModal()">
      <div class="preview-modal-content">
        <div class="preview-modal-header">
          <div class="preview-modal-title">
            <span id="modalHeaderEmoji">📄</span>
            <span id="modalHeaderTitle" data-i18n="cv_preview_modal_title"><?= __("cv_preview_modal_title") ?></span>
          </div>
          <button class="preview-modal-close" onclick="closePreviewModal()">&times;</button>
        </div>
        <div class="preview-modal-body">
          <!-- Left: Device simulator -->
          <div class="device-sim-panel">
            <div class="device-switcher">
              <button class="device-switch-btn active" id="dev-btn-desktop" onclick="changeDevice('desktop')" data-i18n="cv_dev_desktop"><?= __("cv_dev_desktop") ?></button>
              <button class="device-switch-btn" id="dev-btn-tablet" onclick="changeDevice('tablet')" data-i18n="cv_dev_tablet"><?= __("cv_dev_tablet") ?></button>
              <button class="device-switch-btn" id="dev-btn-mobile" onclick="changeDevice('mobile')" data-i18n="cv_dev_mobile"><?= __("cv_dev_mobile") ?></button>
            </div>
            <div class="device-viewport-wrapper">
              <div class="device-frame-desktop" id="deviceViewportFrame">
                <div class="sim-cv" id="simulatedCvContent">
                  <!-- Dynamic content will be injected by JavaScript -->
                </div>
              </div>
            </div>
          </div>
          <!-- Right: Template info -->
          <div class="preview-info-panel">
            <div>
              <h3 class="preview-tpl-title" id="infoTplName">Şablon Adı</h3>
              <p class="preview-tpl-desc" id="infoTplDesc">Bu şablon haqqında qısa məlumat...</p>
              
              <div class="preview-info-section">
                <div class="preview-info-label" data-i18n="cv_preview_recommended_sectors"><?= __("cv_preview_recommended_sectors") ?></div>
                <div class="preview-info-chips" id="infoTplSectors">
                  <span class="preview-info-chip">Bank</span>
                </div>
              </div>
              
              <div class="preview-info-section">
                <div class="preview-info-label" data-i18n="cv_preview_features_label"><?= __("cv_preview_features_label") ?></div>
                <div id="infoTplFeatures">
                  <div class="preview-feature-item"><span class="preview-feature-icon">✓</span> ATS Uyğunluq testi</div>
                </div>
              </div>
            </div>
            
            <div class="preview-modal-actions">
              <button class="btn-primary" id="modalChooseTplBtn" style="background:linear-gradient(135deg,var(--neon-amber),#f97316); width: 100%; border:none; padding:0.85rem; font-weight:700; border-radius:var(--radius-sm); cursor:pointer;">
                <span data-i18n="cv_modal_choose_template"><?= __("cv_modal_choose_template") ?></span>
              </button>
              <button class="btn-ghost" onclick="closePreviewModal()" style="border:1px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.03); color:#94a3b8; width: 100%; padding:0.85rem; font-weight:700; border-radius:var(--radius-sm); cursor:pointer;">
                <span data-i18n="cv_btn_close"><?= __("cv_btn_close") ?></span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── Direct Share Suite Modal ── -->
    <div class="share-suite-modal" id="shareSuiteModal" onclick="if(event.target===this) closeShareSuite()">
      <div class="share-suite-content">
        <div class="share-suite-header">
          <div class="share-suite-title">
            <span>🚀</span>
            <span data-i18n="cv_share_modal_title"><?= __("cv_share_modal_title") ?></span>
          </div>
          <button class="preview-modal-close" onclick="closeShareSuite()">&times;</button>
        </div>
        <div class="share-suite-body">
          <div class="share-cv-target-info">
            <div class="share-cv-target-icon" id="shareTargetEmoji">📄</div>
            <div style="flex:1;min-width:0;">
              <div class="share-cv-target-title" id="shareTargetTitle">Əli Həsənov — Proqram Mühəndisi</div>
              <div class="share-cv-target-meta" id="shareTargetMeta">Professional Elite • ATS-Ready • Standart A4</div>
            </div>
          </div>

          <div style="font-size:0.75rem;font-weight:700;color:var(--neon-cyan);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:0.65rem;">
            <span data-i18n="cv_share_channels_title"><?= __("cv_share_channels_title") ?></span>
          </div>
          <div class="share-channels-grid">
            <a href="#" id="shareBtnWhatsapp" target="_blank" class="share-channel-btn share-btn-whatsapp">
              <span style="font-size:1.25rem;">💬</span>
              <span>WhatsApp</span>
            </a>
            <a href="#" id="shareBtnEmail" target="_blank" class="share-channel-btn share-btn-email">
              <span style="font-size:1.25rem;">✉️</span>
              <span>E-poçt</span>
            </a>
            <button type="button" id="shareBtnInstagram" onclick="copyInstagramShareText()" class="share-channel-btn share-btn-instagram" style="width:100%;font-family:inherit;">
              <span style="font-size:1.25rem;">📸</span>
              <span>Instagram</span>
            </button>
            <a href="#" id="shareBtnFacebook" target="_blank" class="share-channel-btn share-btn-facebook">
              <span style="font-size:1.25rem;">🔵</span>
              <span>Facebook</span>
            </a>
          </div>

          <div style="font-size:0.75rem;font-weight:700;color:var(--text-muted);margin-bottom:0.4rem;">
            <span data-i18n="cv_share_link_title"><?= __("cv_share_link_title") ?></span>
          </div>
          <div class="share-link-box">
            <input type="text" id="shareDirectLinkInput" class="share-link-input" readonly value="">
            <button type="button" class="share-copy-btn" onclick="copyShareDirectLink()" data-i18n="cv_share_copy_btn"><?= __("cv_share_copy_btn") ?></button>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>

<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
<script>

// ── i18n for JS-rendered content (Saved CVs folder) ─────────────
// SkyI18n applies keyed translations to server markup; nodes injected here are
// rendered on demand, so read the active dictionary directly. The SSR language
// lives on <html lang> and is updated before the sky-lang-changed event fires.
function cvT(key) {
  var lang = (document.documentElement && document.documentElement.lang) || 'az';
  var dicts = window.__SKY_I18N__ || {};
  var val = (dicts[lang] || {})[key];
  if (val === undefined || val === '') val = (dicts.az || {})[key];
  return val === undefined ? key : val;
}

// ── Listen for Language Changes to Update Dynamic Content ──
document.addEventListener('sky-lang-changed', function(e) {
  if (typeof renderSavedCvsGrid === 'function' && Array.isArray(savedCvsList)) {
    renderSavedCvsGrid(savedCvsList);
  }
  if (typeof updateSimulatedCv === 'function') {
    updateSimulatedCv();
  }
});

// ── State Management ──
let selectedTemplateId = null;
let selectedTemplateName = null;
let currentPhotoDataUrl = null;
let currentPreviewTplId = null;
let savedCvsList = [];
let currentShareCv = null;
let userFolderPath = '/uploads/cvs/guest_vault/';

// ── Template Selection & Focused Workspace ──
function selectTemplate(id, name) {
  selectedTemplateId = id;
  selectedTemplateName = name;
  const tpl = templatesData[id];

  // Update selection UI in grid
  document.querySelectorAll('.template-card').forEach(c => {
    c.classList.remove('selected');
    const btn = c.querySelector('.tpl-select-btn');
    if (btn) { btn.textContent = 'Seç'; btn.className = 'tpl-select-btn tpl-select-btn-default'; }
  });
  const activeCard = document.getElementById(id);
  if (activeCard) {
    activeCard.classList.add('selected');
    const btn = document.getElementById(id + '-btn');
    if (btn) { btn.textContent = '✓ Seçildi'; btn.className = 'tpl-select-btn tpl-select-btn-active'; }
  }

  // Activate focused workspace mode
  enterFocusedWorkspace(id, name, tpl);

  if (typeof skyToast === 'function') {
    skyToast('"' + name + '" seçildi! Yalnız bu şablon aktivdir.', '✅', 2500);
  }
}

function enterFocusedWorkspace(id, name, tpl) {
  // Hide unselected templates grid and header
  const templatesSection = document.getElementById('templates');
  const templatesGrid = document.getElementById('templatesGrid');
  if (templatesSection) templatesSection.style.display = 'none';
  if (templatesGrid) templatesGrid.style.display = 'none';

  // Populate and show Active Template Workspace Bar
  const activeBar = document.getElementById('activeTemplateWorkspaceBar');
  if (activeBar && tpl) {
    const emojiEl = document.getElementById('activeBarEmoji');
    const nameEl = document.getElementById('activeBarName');
    const descEl = document.getElementById('activeBarDesc');
    const badgeEl = document.getElementById('activeBarBadge');
    const photoStatusEl = document.getElementById('activeTplPhotoStatus');

    if (emojiEl) emojiEl.textContent = tpl.emoji || '📄';
    if (nameEl) nameEl.textContent = name;
    if (descEl) descEl.textContent = tpl.desc || '';
    if (badgeEl) badgeEl.textContent = tpl.sectors ? '🟢 ' + tpl.sectors[0] : '🟢 Aktiv Şablon';

    if (photoStatusEl) {
      if (id === 'tpl-6') {
        photoStatusEl.innerHTML = 'ℹ️ ATS Mətn Formatı (Şəkil tövsiyə olunmur)';
        photoStatusEl.style.color = '#94a3b8';
      } else {
        photoStatusEl.innerHTML = '📸 3x4 Profil Şəkli Dəstəklənir';
        photoStatusEl.style.color = '#38bdf8';
      }
    }

    activeBar.style.display = 'block';
  }

  // Update notice in photo upload box
  const photoNoticeText = document.getElementById('photoNoticeText');
  if (photoNoticeText) {
    if (id === 'tpl-6') {
      photoNoticeText.textContent = 'ATS şablonu mətni əsas götürür. Şəkil yükləsəniz də sənəddə gizlədilir.';
    } else {
      photoNoticeText.textContent = `"${name}" şablonu üçün 3x4 profil şəkli aktivdir (PNG, JPG, WEBP — maks. 5MB)`;
    }
  }

  // Smooth scroll to workspace
  const builder = document.getElementById('activeTemplateWorkspaceBar') || document.getElementById('cv-builder');
  if (builder) {
    builder.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  // Live simulation update
  currentPreviewTplId = id;
  updateSimulatedCv();
}

function backToTemplates() {
  // Returns to the template gallery, displaying all 6 templates again
  const templatesSection = document.getElementById('templates');
  const templatesGrid = document.getElementById('templatesGrid');
  const activeBar = document.getElementById('activeTemplateWorkspaceBar');

  if (activeBar) activeBar.style.display = 'none';
  if (templatesSection) templatesSection.style.display = 'block';
  if (templatesGrid) templatesGrid.style.display = 'grid';

  if (templatesSection) {
    templatesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
  if (typeof skyToast === 'function') {
    skyToast('Bütün şablonlar açıldı. İstədiyiniz şablonu seçə bilərsiniz.', 'ℹ️', 2000);
  }
}

function cancelTemplateSelection() {
  // Resets template selection and returns to full template gallery
  selectedTemplateId = null;
  selectedTemplateName = null;

  document.querySelectorAll('.template-card').forEach(c => {
    c.classList.remove('selected');
    const btn = c.querySelector('.tpl-select-btn');
    if (btn) { btn.textContent = 'Seç'; btn.className = 'tpl-select-btn tpl-select-btn-default'; }
  });

  const activeBar = document.getElementById('activeTemplateWorkspaceBar');
  const templatesSection = document.getElementById('templates');
  const templatesGrid = document.getElementById('templatesGrid');

  if (activeBar) activeBar.style.display = 'none';
  if (templatesSection) templatesSection.style.display = 'block';
  if (templatesGrid) templatesGrid.style.display = 'grid';

  const photoNoticeText = document.getElementById('photoNoticeText');
  if (photoNoticeText) {
    photoNoticeText.textContent = 'Şəkil-dəstəkli şablonlar üçün aktivdir (PNG, JPG, WEBP — maks. 5MB)';
  }

  if (templatesSection) {
    templatesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
  if (typeof skyToast === 'function') {
    skyToast('Şablon seçimi ləğv edildi.', '↩️', 2000);
  }
}

function openActivePreviewModal() {
  if (selectedTemplateId) {
    openPreviewModal(selectedTemplateId);
  } else {
    openPreviewModal('tpl-1');
  }
}

// ── Standard 3x4 Profile Picture Handlers ──
function triggerPhotoPicker(event) {
  if (event) event.stopPropagation();
  const inp = document.getElementById('cv-photo-input');
  if (inp) inp.click();
}

function handlePhotoUpload(event) {
  const file = event.target.files && event.target.files[0];
  if (!file) return;
  processPhotoFile(file);
}

function processPhotoFile(file) {
  if (!file.type.startsWith('image/')) {
    if (typeof skyToast === 'function') skyToast('Zəhmət olmasa yalnız şəkil faylı seçin (JPG, PNG, WEBP).', '⚠️', 3000);
    return;
  }
  if (file.size > 5 * 1024 * 1024) {
    if (typeof skyToast === 'function') skyToast('Şəkil ölçüsü maksimum 5MB ola bilər.', '⚠️', 3000);
    return;
  }

  const reader = new FileReader();
  reader.onload = function(e) {
    currentPhotoDataUrl = e.target.result;
    
    // Update preview in 3x4 upload box
    const previewImg = document.getElementById('cv-photo-preview-img');
    const placeholder = document.getElementById('cv-photo-placeholder');
    const overlay = document.getElementById('cv-photo-overlay');
    const uploaderBox = document.getElementById('cvPhotoBox');
    
    if (previewImg) {
      previewImg.src = currentPhotoDataUrl;
      previewImg.style.display = 'block';
    }
    if (placeholder) placeholder.style.display = 'none';
    if (overlay) overlay.classList.add('has-image');
    if (uploaderBox) {
      uploaderBox.style.borderColor = 'var(--neon-amber)';
      uploaderBox.style.boxShadow = '0 0 25px rgba(245, 158, 11, 0.3)';
    }

    if (typeof skyToast === 'function') {
      skyToast('3x4 Profil şəkli uğurla əlavə edildi!', '📸', 2500);
    }

    // Refresh live preview
    updateSimulatedCv();
  };
  reader.readAsDataURL(file);
}

function removePhoto(event) {
  if (event) event.stopPropagation();
  currentPhotoDataUrl = null;
  
  const fileInput = document.getElementById('cv-photo-input');
  if (fileInput) fileInput.value = '';

  const previewImg = document.getElementById('cv-photo-preview-img');
  const placeholder = document.getElementById('cv-photo-placeholder');
  const overlay = document.getElementById('cv-photo-overlay');
  const uploaderBox = document.getElementById('cvPhotoBox');

  if (previewImg) {
    previewImg.src = '';
    previewImg.style.display = 'none';
  }
  if (placeholder) placeholder.style.display = 'flex';
  if (overlay) overlay.classList.remove('has-image');
  if (uploaderBox) {
    uploaderBox.style.borderColor = 'rgba(245, 158, 11, 0.4)';
    uploaderBox.style.boxShadow = 'none';
  }

  if (typeof skyToast === 'function') {
    skyToast('Profil şəkli silindi.', '🗑️', 2000);
  }

  // Refresh live preview
  updateSimulatedCv();
}

// ── Drag & Drop for 3x4 Photo Box ──
document.addEventListener('DOMContentLoaded', () => {
  const photoBox = document.getElementById('cvPhotoBox');
  if (photoBox) {
    ['dragenter', 'dragover'].forEach(eventName => {
      photoBox.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        photoBox.classList.add('dragover');
      }, false);
    });
    ['dragleave', 'drop'].forEach(eventName => {
      photoBox.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        photoBox.classList.remove('dragover');
      }, false);
    });
    photoBox.addEventListener('drop', (e) => {
      const dt = e.dataTransfer;
      const files = dt.files;
      if (files && files.length > 0) {
        processPhotoFile(files[0]);
      }
    }, false);
  }

  // Live input sync with CV simulation
  const syncInputs = [
    'cv-fname', 'cv-lname', 'cv-role', 'cv-phone', 'cv-email', 'cv-city', 'cv-linkedin', 'cv-portfolio', 'cv-summary'
  ];
  syncInputs.forEach(id => {
    const el = document.getElementById(id);
    if (el) {
      el.addEventListener('input', () => {
        if (currentPreviewTplId) updateSimulatedCv();
      });
    }
  });

  // Load Saved CVs on startup
  loadSavedCvs();
});

// ── Tab Switch ──
function showTab(btn, panelId) {
  document.querySelectorAll('.cv-tab').forEach(t => { t.classList.remove('active'); t.setAttribute('aria-selected','false'); });
  document.querySelectorAll('.cv-tab-panel').forEach(p => p.classList.remove('active'));
  btn.classList.add('active'); btn.setAttribute('aria-selected','true');
  document.getElementById(panelId).classList.add('active');
}

// ── Add Experience ──
let expCount = 1;
function addExpItem() {
  expCount++;
  const div = document.createElement('div'); div.className = 'exp-item';
  div.innerHTML = `<div class="exp-item-header"><span class="exp-item-title">💼 İş Təcrübəsi #${expCount}</span><button class="exp-remove-btn" onclick="removeItem(this)" data-i18n="cv_btn_delete_item"><?= __("cv_btn_delete_item") ?></button></div>
  <div class="cv-form-grid">
    <div class="form-group"><label class="form-label" data-i18n="cv_label_company"><?= __("cv_label_company") ?></label><input class="form-input" type="text" placeholder="<?= __("cv_ph_company") ?>" data-i18n-placeholder="cv_ph_company"></div>
    <div class="form-group"><label class="form-label" data-i18n="cv_label_position"><?= __("cv_label_position") ?></label><input class="form-input" type="text" placeholder="Mütəxəssis"></div>
    <div class="form-group"><label class="form-label" data-i18n="cv_label_start_date"><?= __("cv_label_start_date") ?></label><input class="form-input" type="month"></div>
    <div class="form-group"><label class="form-label" data-i18n="cv_label_end_date"><?= __("cv_label_end_date") ?></label><input class="form-input" type="month"></div>
    <div class="form-group form-full"><label class="form-label" data-i18n="cv_label_duties"><?= __("cv_label_duties") ?></label><textarea class="form-textarea" placeholder="Bu vəzifədə nə etdiniz?" style="min-height:80px;"></textarea></div>
  </div>`;
  document.getElementById('exp-list').appendChild(div);
}

// ── Add Education ──
let eduCount = 1;
function addEduItem() {
  eduCount++;
  const div = document.createElement('div'); div.className = 'exp-item';
  div.innerHTML = `<div class="exp-item-header"><span class="exp-item-title">🎓 Təhsil #${eduCount}</span><button class="exp-remove-btn" onclick="removeItem(this)" data-i18n="cv_btn_delete_item"><?= __("cv_btn_delete_item") ?></button></div>
  <div class="cv-form-grid">
    <div class="form-group"><label class="form-label" data-i18n="cv_label_school"><?= __("cv_label_school") ?></label><input class="form-input" type="text" placeholder="Universitetiniz"></div>
    <div class="form-group"><label class="form-label" data-i18n="cv_label_major"><?= __("cv_label_major") ?></label><input class="form-input" type="text" placeholder="İxtisasınız"></div>
    <div class="form-group"><label class="form-label" data-i18n="cv_label_degree"><?= __("cv_label_degree") ?></label><select class="form-select"><option data-i18n="cv_degree_bachelor"><?= __("cv_degree_bachelor") ?></option><option data-i18n="cv_degree_master"><?= __("cv_degree_master") ?></option><option>Doktor</option><option data-i18n="cv_degree_secondary"><?= __("cv_degree_secondary") ?></option></select></div>
    <div class="form-group"><label class="form-label" data-i18n="cv_label_grad_year"><?= __("cv_label_grad_year") ?></label><input class="form-input" type="number" min="1990" max="2030" placeholder="2024"></div>
    <div class="form-group form-full"><label class="form-label">Qeyd</label><input class="form-input" type="text" placeholder="Fərqlənmə, GPA..."></div>
  </div>`;
  document.getElementById('edu-list').appendChild(div);
}

function removeItem(btn) { btn.closest('.exp-item').remove(); }

// ── Skills & Languages ──
function addSkill() {
  const inp = document.getElementById('skill-input'); const val = inp.value.trim();
  if (!val) return;
  const span = document.createElement('span'); span.className = 'skill-chip';
  span.innerHTML = val + ' <button onclick="this.closest(\'.skill-chip\').remove()">×</button>';
  document.getElementById('skills-chips').appendChild(span);
  inp.value = ''; inp.focus();
}

function addLang() {
  const div = document.createElement('div');
  div.style.cssText = 'display:grid;grid-template-columns:1fr 1fr auto;gap:0.65rem;align-items:end;';
  div.innerHTML = `<div><label class="form-label" style="font-size:0.73rem;" data-i18n="cv_sublabel_lang"><?= __("cv_sublabel_lang") ?></label><input class="form-input" type="text" placeholder="Dil"></div>
  <div><label class="form-label" style="font-size:0.73rem;" data-i18n="cv_sublabel_level"><?= __("cv_sublabel_level") ?></label><select class="form-select"><option>Ana dili</option><option>C2</option><option>C1</option><option>B2</option><option>B1</option><option>A2</option></select></div>
  <div><button class="exp-remove-btn" onclick="this.closest('div').parentElement.remove()">✕</button></div>`;
  document.getElementById('lang-list').appendChild(div);
}

// ── Helper to Collect CV Form Data ──
function collectFormData(status = 'draft') {
  const fname = (document.getElementById('cv-fname') && document.getElementById('cv-fname').value.trim()) || 'Əli';
  const lname = (document.getElementById('cv-lname') && document.getElementById('cv-lname').value.trim()) || 'Həsənov';
  const role = (document.getElementById('cv-role') && document.getElementById('cv-role').value.trim()) || 'Proqram Mühəndisi';
  const email = (document.getElementById('cv-email') && document.getElementById('cv-email').value.trim()) || '';
  const phone = (document.getElementById('cv-phone') && document.getElementById('cv-phone').value.trim()) || '';
  const city = (document.getElementById('cv-city') && document.getElementById('cv-city').value.trim()) || '';
  const linkedin = (document.getElementById('cv-linkedin') && document.getElementById('cv-linkedin').value.trim()) || '';
  const portfolio = (document.getElementById('cv-portfolio') && document.getElementById('cv-portfolio').value.trim()) || '';
  const summary = (document.getElementById('cv-summary') && document.getElementById('cv-summary').value.trim()) || '';

  // ── Collect Experience entries ──
  const experience = [];
  document.querySelectorAll('#exp-list .exp-item').forEach(item => {
    const inputs = item.querySelectorAll('input, textarea');
    const company   = inputs[0] ? inputs[0].value.trim() : '';
    const position  = inputs[1] ? inputs[1].value.trim() : '';
    const dateStart = inputs[2] ? inputs[2].value.trim() : '';
    const dateEnd   = inputs[3] ? inputs[3].value.trim() : '';
    const duties    = inputs[4] ? inputs[4].value.trim() : '';
    if (company || position) {
      experience.push({ company, position, date_start: dateStart, date_end: dateEnd, duties });
    }
  });

  // ── Collect Education entries ──
  const education = [];
  document.querySelectorAll('#edu-list .exp-item').forEach(item => {
    const inputs  = item.querySelectorAll('input');
    const selects = item.querySelectorAll('select');
    const school  = inputs[0] ? inputs[0].value.trim() : '';
    const field   = inputs[1] ? inputs[1].value.trim() : '';
    const degree  = selects[0] ? selects[0].value.trim() : '';
    const year    = inputs[2] ? inputs[2].value.trim() : '';
    const note    = inputs[3] ? inputs[3].value.trim() : '';
    if (school || field) {
      education.push({ school, field, degree, year, note });
    }
  });

  // ── Collect Skills (chips) ──
  const skills = [];
  document.querySelectorAll('#skills-chips .skill-chip').forEach(chip => {
    // chip text node is first child; button is last child
    const text = chip.childNodes[0] ? chip.childNodes[0].textContent.trim() : '';
    if (text) skills.push(text);
  });

  // ── Collect Languages ──
  const languages = [];
  document.querySelectorAll('#lang-list > div').forEach(row => {
    const langInput = row.querySelector('input[type="text"]');
    const levelSel  = row.querySelector('select');
    const lang  = langInput ? langInput.value.trim() : '';
    const level = levelSel  ? levelSel.value.trim()  : '';
    if (lang) languages.push({ lang, level });
  });

  // ── Collect Extra / Əlavə tab ──
  const certifications = (document.getElementById('cv-cert')      && document.getElementById('cv-cert').value.trim())      || '';
  const awards         = (document.getElementById('cv-awards')    && document.getElementById('cv-awards').value.trim())    || '';
  const volunteer      = (document.getElementById('cv-volunteer') && document.getElementById('cv-volunteer').value.trim()) || '';
  const cv_language    = (document.getElementById('cv-lang-pref') && document.getElementById('cv-lang-pref').value)        || 'az';

  const tplId = selectedTemplateId || 'tpl-1';
  const tpl = templatesData[tplId] || templatesData['tpl-1'];

  return {
    fname, lname, role, email, phone, city, linkedin, portfolio, summary,
    experience, education, skills, languages,
    certifications, awards, volunteer, cv_language,
    photo_url: currentPhotoDataUrl,
    template_id: tplId,
    template_name: tpl.name,
    status: status,
    created_at: new Date().toISOString().slice(0, 19).replace('T', ' ')
  };
}

// ── Save Progress (Draft) ──
async function saveProgress() {
  const data = collectFormData('draft');
  await persistCvRecord(data, 'draft');
}

// ── Submit & Generate CV (Exported PDF) ──
async function submitCVOrder() {
  const fname = (document.getElementById('cv-fname') && document.getElementById('cv-fname').value.trim());
  if (!fname) {
    if (typeof skyToast === 'function') skyToast('Zəhmət olmasa ən azı adınızı daxil edin.', '❌', 3000);
    return;
  }

  if (typeof skyToast === 'function') skyToast('CV sənədi hazırlanır və şəxsi qovluğa göndərilir...', '⏳', 1500);

  const data = collectFormData('exported');
  const record = await persistCvRecord(data, 'exported');

  if (record) {
    setTimeout(() => {
      if (typeof skyToast === 'function') {
        skyToast(`"${record.template_name}" formatında CV hazırlandı və qovluğunuza saxlanıldı!`, '✅', 3500);
      }
      // Open standalone printable document
      if (record.view_url) {
        window.open(record.view_url, '_blank');
      }
    }, 800);
  }
}

// ── Persist CV Record to Server & LocalStorage ──
async function persistCvRecord(payload, status) {
  try {
    const res = await fetch('<?= SITE_URL ?>/api/cv-service.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action: 'save', cv: payload })
    });
    const result = await res.json();

    if (result.success && result.cv) {
      if (typeof skyToast === 'function' && status === 'draft') {
        skyToast('📁 CV şəxsi qovluğunuza yadda saxlanıldı!', '💾', 2500);
      }
      // Reload saved CVs from server
      await loadSavedCvs();
      return result.cv;
    }
  } catch (err) {
    console.warn('API error, falling back to LocalStorage:', err);
  }

  // Local fallback
  const id = 'cv_local_' + Date.now();
  const cvRecord = {
    id: id,
    title: (payload.fname + ' ' + payload.lname).trim() + ' — ' + payload.role,
    fullname: (payload.fname + ' ' + payload.lname).trim(),
    role: payload.role,
    template_id: payload.template_id,
    template_name: payload.template_name,
    status: status,
    status_text: (status === 'exported') ? 'Tamamlandı (PDF Export)' : 'Qaralama (Yadda Saxlanılıb)',
    created_at: payload.created_at,
    file_path: '/uploads/cvs/local/' + id + '.pdf',
    size_kb: 14.8,
    data: payload
  };

  const localSaved = JSON.parse(localStorage.getItem('skyweb_saved_cvs') || '[]');
  localSaved.unshift(cvRecord);
  localStorage.setItem('skyweb_saved_cvs', JSON.stringify(localSaved));

  if (typeof skyToast === 'function') {
    skyToast('📁 CV yerli qovluğunuzda saxlanıldı!', '💾', 2000);
  }
  renderSavedCvsLocal();
  return cvRecord;
}

// ── Load Saved CVs ──
async function loadSavedCvs() {
  try {
    const res = await fetch('<?= SITE_URL ?>/api/cv-service.php?action=list');
    const result = await res.json();

    if (result.success) {
      savedCvsList = result.cvs || [];
      userFolderPath = result.folder_path || '/uploads/cvs/user_vault/';
      
      // Update UI Vault Header
      const pathEl = document.getElementById('vaultPathText');
      const filesCountEl = document.getElementById('vaultFilesCount');
      const storageUsedEl = document.getElementById('vaultStorageUsed');
      const heroBadge = document.getElementById('heroSavedCountBadge');
      const sectionBadge = document.getElementById('sectionSavedCountBadge');

      if (pathEl) pathEl.textContent = userFolderPath;
      if (filesCountEl) filesCountEl.textContent = savedCvsList.length + ' ' + cvT('cv_count_unit');
      if (storageUsedEl) storageUsedEl.textContent = (result.storage_used_kb || '0') + ' KB';
      if (heroBadge) heroBadge.textContent = savedCvsList.length;
      if (sectionBadge) sectionBadge.textContent = savedCvsList.length;

      renderSavedCvsGrid(savedCvsList);
      return;
    }
  } catch (err) {
    console.warn('Cannot fetch from cv-service:', err);
  }

  renderSavedCvsLocal();
}

function renderSavedCvsLocal() {
  const localSaved = JSON.parse(localStorage.getItem('skyweb_saved_cvs') || '[]');
  savedCvsList = localSaved;

  const heroBadge = document.getElementById('heroSavedCountBadge');
  const sectionBadge = document.getElementById('sectionSavedCountBadge');
  const filesCountEl = document.getElementById('vaultFilesCount');
  if (heroBadge) heroBadge.textContent = savedCvsList.length;
  if (sectionBadge) sectionBadge.textContent = savedCvsList.length;
  if (filesCountEl) filesCountEl.textContent = savedCvsList.length + ' ' + cvT('cv_count_unit');

  renderSavedCvsGrid(savedCvsList);
}

function refreshSavedCvs() {
  loadSavedCvs();
  if (typeof skyToast === 'function') skyToast('Qovluq yeniləndi ✓', '🔄', 1500);
}

// ── Render Saved CVs Grid Cards ──
function renderSavedCvsGrid(list) {
  const grid = document.getElementById('savedCvsGrid');
  if (!grid) return;

  if (!list || list.length === 0) {
    grid.innerHTML = `
      <div class="saved-cvs-empty" style="grid-column: 1 / -1;">
        <div class="saved-cvs-empty-icon">📂</div>
        <div class="saved-cvs-empty-title">${cvT('cv_folder_empty_title')}</div>
        <div class="saved-cvs-empty-desc">${cvT('cv_folder_empty_desc')}</div>
        <a href="#templates" class="btn-primary" style="display:inline-flex;padding:0.65rem 1.4rem;background:linear-gradient(135deg,var(--neon-amber),#f97316);text-decoration:none;border-radius:var(--radius-sm);font-weight:700;">
          ${cvT('cv_folder_empty_cta')}
        </a>
      </div>
    `;
    return;
  }

  let html = '';
  list.forEach(cv => {
    const isExported = cv.status === 'exported';
    const statusPill = isExported 
      ? `<span class="saved-cv-status-pill status-exported">${cvT('cv_folder_card_completed')}</span>` 
      : `<span class="saved-cv-status-pill status-draft">${cvT('cv_folder_card_draft')}</span>`;
    
    const photoSrc = (cv.data && cv.data.photo_url) || '';
    const avatarHtml = photoSrc 
      ? `<img src="${photoSrc}" alt="${cv.fullname || 'CV'}">` 
      : `<div style="width:100%;height:100%;background:linear-gradient(135deg,#38bdf8,#0284c7);display:flex;align-items:center;justify-content:center;color:#fff;font-size:7px;">👤</div>`;

    const dateFormatted = cv.created_at || cvT('cv_folder_card_new');
    const viewUrl = cv.view_url || '<?= SITE_URL ?>/modules/cv-builder/view.php?id=' + cv.id;
    const filePathDisplay = cv.file_path || (userFolderPath + (cv.file_name || 'cv_document.pdf'));

    html += `
      <div class="saved-cv-card" id="card-${cv.id}">
        <div>
          <!-- Card Top with Visual Document Mini Preview -->
          <div class="saved-cv-card-top">
            <div class="saved-cv-mini-doc">
              <div class="saved-cv-doc-inner">
                <div class="saved-cv-doc-head">
                  <div class="saved-cv-doc-avatar">${avatarHtml}</div>
                  <div class="saved-cv-doc-lines">
                    <div class="saved-cv-doc-bar"></div>
                    <div class="saved-cv-doc-bar-sub"></div>
                  </div>
                </div>
                <div class="saved-cv-doc-body-line" style="width:90%;"></div>
                <div class="saved-cv-doc-body-line"></div>
                <div class="saved-cv-doc-body-line" style="width:75%;"></div>
                <div class="saved-cv-doc-body-line" style="width:85%;margin-top:3px;"></div>
                <div class="saved-cv-doc-body-line"></div>
              </div>
            </div>

            <div class="saved-cv-card-info">
              <div class="saved-cv-badge-row">
                <span class="saved-cv-tpl-pill">${cv.template_name || 'Professional Elite'}</span>
                ${statusPill}
              </div>
              <div class="saved-cv-title" title="${cv.fullname || cvT('cv_folder_card_no_doc')}">${cv.fullname || cvT('cv_folder_card_no_doc')}</div>
              <div class="saved-cv-role">${cv.role || cvT('cv_folder_card_role')}</div>
              <div class="saved-cv-meta">
                <span>🕒 ${dateFormatted}</span>
                <span>•</span>
                <span>${cv.size_kb || 14.5} KB</span>
              </div>
            </div>
          </div>

          <!-- Transparent Folder File Path Badge -->
          <div class="saved-cv-path-pill" title="${cvT('cv_folder_card_path_title')}: ${filePathDisplay}">
            <span>📁 ${filePathDisplay}</span>
            <span style="cursor:pointer;color:#38bdf8;" onclick="copySpecificPath('${filePathDisplay}')" title="${cvT('btn_copy')}">📋</span>
          </div>
        </div>

        <div>
          <!-- One-Click Action Menu -->
          <div class="saved-cv-actions">
            <button class="btn-card-action btn-action-download" onclick="downloadSavedCv('${cv.id}')" title="${cvT('cv_folder_card_download_title')}">
              <span>${cvT('cv_folder_card_download')}</span>
            </button>
            <button class="btn-card-action btn-action-print" onclick="printSavedCv('${cv.id}')" title="${cvT('cv_folder_card_print_title')}">
              <span>${cvT('cv_folder_card_print')}</span>
            </button>
            <button class="btn-card-action btn-action-share" onclick="openShareSuite('${cv.id}')" title="${cvT('cv_folder_card_share_title')}">
              <span>${cvT('cv_folder_card_share')}</span>
            </button>
          </div>

          <!-- Secondary Actions (Load into builder / Delete) -->
          <div class="saved-cv-secondary-actions">
            <button class="btn-action-load" onclick="loadCvIntoBuilder('${cv.id}')" title="${cvT('cv_folder_card_edit_title')}">
              <span>${cvT('cv_folder_card_edit')}</span>
            </button>
            <button class="btn-action-delete" onclick="deleteSavedCv('${cv.id}')" title="${cvT('cv_folder_card_delete_title')}">
              <span>${cvT('cv_btn_delete_item')}</span>
            </button>
          </div>
        </div>
      </div>
    `;
  });

  grid.innerHTML = html;
}

// ── One-Click Action: Download PDF ──
function downloadSavedCv(id) {
  const cv = savedCvsList.find(c => c.id === id);
  if (!cv) return;

  if (typeof skyToast === 'function') skyToast('📥 "' + cv.title + '" PDF sənədi yüklənir...', '📄', 2500);

  if (cv.view_url) {
    const win = window.open(cv.view_url, '_blank');
    if (win) {
      setTimeout(() => { win.focus(); }, 500);
    }
  } else {
    // Generate standalone printable view
    const win = window.open('<?= SITE_URL ?>/modules/cv-builder/view.php?id=' + id, '_blank');
  }
}

// ── One-Click Action: Print ──
function printSavedCv(id) {
  const cv = savedCvsList.find(c => c.id === id);
  if (!cv) return;

  if (typeof skyToast === 'function') skyToast('🖨️ Çap pəncərəsi açılır...', '📄', 2000);

  const url = cv.view_url || ('<?= SITE_URL ?>/modules/cv-builder/view.php?id=' + id);
  const printWindow = window.open(url, '_blank');
  if (printWindow) {
    printWindow.onload = function() {
      setTimeout(() => { printWindow.print(); }, 400);
    };
  }
}

// ── One-Click Action: Direct Share Suite ──
function openShareSuite(id) {
  const cv = savedCvsList.find(c => c.id === id);
  if (!cv) return;

  currentShareCv = cv;
  const shareUrl = cv.view_url || (window.location.origin + '<?= SITE_URL ?>/modules/cv-builder/view.php?id=' + cv.id);
  const title = cv.fullname + ' — ' + cv.role;
  const tplName = cv.template_name || 'Professional Elite';

  document.getElementById('shareTargetEmoji').textContent = templatesData[cv.template_id]?.emoji || '📄';
  document.getElementById('shareTargetTitle').textContent = title;
  document.getElementById('shareTargetMeta').textContent = `${tplName} • Standart A4 • Qovluq: ${cv.file_path || 'uploads/cvs/'}`;

  // WhatsApp
  const waText = encodeURIComponent(`Salam! Mənim peşəkar CV sənədim:\n📌 ${title}\n🎨 Şablon: ${tplName}\n📄 CV-ni buradan onlayn oxuya və yükləyə bilərsiniz:\n${shareUrl}`);
  document.getElementById('shareBtnWhatsapp').href = `https://api.whatsapp.com/send?text=${waText}`;

  // Email
  const mailSubject = encodeURIComponent(`CV — ${title}`);
  const mailBody = encodeURIComponent(`Hörmətli İnsan Resursları / İşəgötürən,\n\nMənim peşəkar CV sənədim aşağıdakı linkdə təqdim edilmişdir:\n\nNamizəd: ${cv.fullname}\nVəzifə: ${cv.role}\nƏlaqə: ${(cv.data && cv.data.phone) || ''} | ${(cv.data && cv.data.email) || ''}\n\n📄 Onlayn CV Sənədi və PDF yükləmə:\n${shareUrl}\n\nDiqqətiniz üçün təşəkkür edirəm!`);
  document.getElementById('shareBtnEmail').href = `mailto:?subject=${mailSubject}&body=${mailBody}`;

  // Facebook
  const fbUrl = encodeURIComponent(shareUrl);
  document.getElementById('shareBtnFacebook').href = `https://www.facebook.com/sharer/sharer.php?u=${fbUrl}`;

  // Direct Link Input
  document.getElementById('shareDirectLinkInput').value = shareUrl;

  // Open modal
  const modal = document.getElementById('shareSuiteModal');
  modal.style.display = 'flex';
  setTimeout(() => modal.classList.add('active'), 10);
}

function closeShareSuite() {
  const modal = document.getElementById('shareSuiteModal');
  modal.classList.remove('active');
  setTimeout(() => modal.style.display = 'none', 250);
}

function copyInstagramShareText() {
  if (!currentShareCv) return;
  const shareUrl = currentShareCv.view_url || (window.location.origin + '<?= SITE_URL ?>/modules/cv-builder/view.php?id=' + currentShareCv.id);
  const text = `💼 ${currentShareCv.fullname} | ${currentShareCv.role}\n📄 CV Link: ${shareUrl}`;
  navigator.clipboard.writeText(text).then(() => {
    if (typeof skyToast === 'function') skyToast('📸 Instagram üçün bio/mesaj mətni kopyalandı!', '✅', 2500);
  });
}

function copyShareDirectLink() {
  const inp = document.getElementById('shareDirectLinkInput');
  if (!inp) return;
  navigator.clipboard.writeText(inp.value).then(() => {
    if (typeof skyToast === 'function') skyToast('📋 Birbaşa CV linki kopyalandı!', '🔗', 2000);
  });
}

function copyVaultPath() {
  const path = document.getElementById('vaultPathText').textContent;
  navigator.clipboard.writeText(path).then(() => {
    if (typeof skyToast === 'function') skyToast('📁 Hesab qovluq yolu kopyalandı: ' + path, '📋', 2200);
  });
}

function copySpecificPath(path) {
  navigator.clipboard.writeText(path).then(() => {
    if (typeof skyToast === 'function') skyToast('📁 Fayl yolu kopyalandı: ' + path, '📋', 2000);
  });
}

// ── Load CV Data back into Builder ──
function loadCvIntoBuilder(id) {
  const cv = savedCvsList.find(c => c.id === id);
  if (!cv || !cv.data) return;

  const d = cv.data;
  if (document.getElementById('cv-fname')) document.getElementById('cv-fname').value = d.fname || '';
  if (document.getElementById('cv-lname')) document.getElementById('cv-lname').value = d.lname || '';
  if (document.getElementById('cv-role')) document.getElementById('cv-role').value = d.role || '';
  if (document.getElementById('cv-phone')) document.getElementById('cv-phone').value = d.phone || '';
  if (document.getElementById('cv-email')) document.getElementById('cv-email').value = d.email || '';
  if (document.getElementById('cv-city')) document.getElementById('cv-city').value = d.city || '';
  if (document.getElementById('cv-linkedin')) document.getElementById('cv-linkedin').value = d.linkedin || '';
  if (document.getElementById('cv-portfolio')) document.getElementById('cv-portfolio').value = d.portfolio || '';
  if (document.getElementById('cv-summary')) document.getElementById('cv-summary').value = d.summary || '';

  // ── Restore Section 2 / Əlavə fields ──
  if (document.getElementById('cv-cert')) document.getElementById('cv-cert').value = d.certifications || d['cv-cert'] || '';
  if (document.getElementById('cv-awards')) document.getElementById('cv-awards').value = d.awards || d['cv-awards'] || '';
  if (document.getElementById('cv-volunteer')) document.getElementById('cv-volunteer').value = d.volunteer || d['cv-volunteer'] || '';
  if (document.getElementById('cv-lang-pref')) document.getElementById('cv-lang-pref').value = d.cv_language || d['cv-lang-pref'] || 'az';

  // ── Restore Experience ──
  const expList = document.getElementById('exp-list');
  if (expList && Array.isArray(d.experience) && d.experience.length > 0) {
    expList.innerHTML = '';
    expCount = 0;
    d.experience.forEach(exp => {
      expCount++;
      const div = document.createElement('div'); div.className = 'exp-item';
      div.innerHTML = `<div class="exp-item-header"><span class="exp-item-title">💼 İş Təcrübəsi #${expCount}</span><button class="exp-remove-btn" onclick="removeItem(this)" data-i18n="cv_btn_delete_item"><?= __("cv_btn_delete_item") ?></button></div>
      <div class="cv-form-grid">
        <div class="form-group"><label class="form-label" data-i18n="cv_label_company"><?= __("cv_label_company") ?></label><input class="form-input" type="text" value="${exp.company || ''}" placeholder="<?= __("cv_ph_company") ?>" data-i18n-placeholder="cv_ph_company"></div>
        <div class="form-group"><label class="form-label" data-i18n="cv_label_position"><?= __("cv_label_position") ?></label><input class="form-input" type="text" value="${exp.position || ''}" placeholder="Mütəxəssis"></div>
        <div class="form-group"><label class="form-label" data-i18n="cv_label_start_date"><?= __("cv_label_start_date") ?></label><input class="form-input" type="month" value="${exp.date_start || ''}"></div>
        <div class="form-group"><label class="form-label" data-i18n="cv_label_end_date"><?= __("cv_label_end_date") ?></label><input class="form-input" type="month" value="${exp.date_end || ''}"></div>
        <div class="form-group form-full"><label class="form-label" data-i18n="cv_label_duties"><?= __("cv_label_duties") ?></label><textarea class="form-textarea" style="min-height:80px;">${exp.duties || ''}</textarea></div>
      </div>`;
      expList.appendChild(div);
    });
  }

  // ── Restore Education ──
  const eduList = document.getElementById('edu-list');
  if (eduList && Array.isArray(d.education) && d.education.length > 0) {
    eduList.innerHTML = '';
    eduCount = 0;
    d.education.forEach(edu => {
      eduCount++;
      const div = document.createElement('div'); div.className = 'exp-item';
      div.innerHTML = `<div class="exp-item-header"><span class="exp-item-title">🎓 Təhsil #${eduCount}</span><button class="exp-remove-btn" onclick="removeItem(this)" data-i18n="cv_btn_delete_item"><?= __("cv_btn_delete_item") ?></button></div>
      <div class="cv-form-grid">
        <div class="form-group"><label class="form-label" data-i18n="cv_label_school"><?= __("cv_label_school") ?></label><input class="form-input" type="text" value="${edu.school || ''}" placeholder="Universitetiniz"></div>
        <div class="form-group"><label class="form-label" data-i18n="cv_label_major"><?= __("cv_label_major") ?></label><input class="form-input" type="text" value="${edu.field || ''}" placeholder="İxtisasınız"></div>
        <div class="form-group"><label class="form-label" data-i18n="cv_label_degree"><?= __("cv_label_degree") ?></label><select class="form-select">
          <option value="" data-i18n="select_choose"><?= __("select_choose") ?></option>
          <option ${edu.degree === 'Bakalavr' ? 'selected' : ''}>Bakalavr</option>
          <option ${edu.degree === 'Magistr' ? 'selected' : ''}>Magistr</option>
          <option ${edu.degree === 'Doktor (PhD)' || edu.degree === 'Doktor' ? 'selected' : ''}>Doktor (PhD)</option>
          <option ${edu.degree === 'Orta' ? 'selected' : ''}>Orta</option>
          <option ${edu.degree === 'Sertifikat' ? 'selected' : ''}>Sertifikat</option>
        </select></div>
        <div class="form-group"><label class="form-label" data-i18n="cv_label_grad_year"><?= __("cv_label_grad_year") ?></label><input class="form-input" type="number" min="1990" max="2030" value="${edu.year || ''}" placeholder="2024"></div>
        <div class="form-group form-full"><label class="form-label">Qeyd</label><input class="form-input" type="text" value="${edu.note || ''}" placeholder="Fərqlənmə, GPA..."></div>
      </div>`;
      eduList.appendChild(div);
    });
  }

  // ── Restore Skills ──
  const skillsChips = document.getElementById('skills-chips');
  if (skillsChips && Array.isArray(d.skills) && d.skills.length > 0) {
    skillsChips.innerHTML = '';
    d.skills.forEach(s => {
      const span = document.createElement('span'); span.className = 'skill-chip';
      span.innerHTML = s + ' <button onclick="this.closest(\'.skill-chip\').remove()">×</button>';
      skillsChips.appendChild(span);
    });
  }

  // ── Restore Languages ──
  const langList = document.getElementById('lang-list');
  if (langList && Array.isArray(d.languages) && d.languages.length > 0) {
    langList.innerHTML = '';
    d.languages.forEach(l => {
      const div = document.createElement('div');
      div.style.cssText = 'display:grid;grid-template-columns:1fr 1fr auto;gap:0.65rem;align-items:end;';
      div.innerHTML = `<div><label class="form-label" style="font-size:0.73rem;" data-i18n="cv_sublabel_lang"><?= __("cv_sublabel_lang") ?></label><input class="form-input" type="text" value="${l.lang || ''}" placeholder="Dil"></div>
      <div><label class="form-label" style="font-size:0.73rem;" data-i18n="cv_sublabel_level"><?= __("cv_sublabel_level") ?></label><select class="form-select">
        <option ${l.level === 'Ana dili' ? 'selected' : ''}>Ana dili</option>
        <option ${(l.level || '').includes('C2') ? 'selected' : ''}>C2 — Mükəmməl</option>
        <option ${(l.level || '').includes('C1') ? 'selected' : ''}>C1 — İləri</option>
        <option ${(l.level || '').includes('B2') ? 'selected' : ''}>B2 — Yüksək orta</option>
        <option ${(l.level || '').includes('B1') ? 'selected' : ''}>B1 — Orta</option>
        <option ${(l.level || '').includes('A2') ? 'selected' : ''}>A2 — Başlanğıc</option>
      </select></div>
      <div><button class="exp-remove-btn" onclick="this.closest('div').parentElement.remove()">✕</button></div>`;
      langList.appendChild(div);
    });
  }

  if (d.photo_url) {
    currentPhotoDataUrl = d.photo_url;
    const previewImg = document.getElementById('cv-photo-preview-img');
    const placeholder = document.getElementById('cv-photo-placeholder');
    const overlay = document.getElementById('cv-photo-overlay');
    if (previewImg) { previewImg.src = currentPhotoDataUrl; previewImg.style.display = 'block'; }
    if (placeholder) placeholder.style.display = 'none';
    if (overlay) overlay.classList.add('has-image');
  }

  // Set template
  selectTemplate(cv.template_id || 'tpl-1', cv.template_name || 'Professional Elite');

  if (typeof skyToast === 'function') {
    skyToast('✏️ "' + cv.title + '" iş sahəsinə yükləndi!', '✅', 2500);
  }
}

// ── Delete Saved CV ──
async function deleteSavedCv(id) {
  if (!confirm('Bu CV sənədini şəxsi qovluğunuzdan silmək istədiyinizə əminsiniz?')) return;

  try {
    const res = await fetch('<?= SITE_URL ?>/api/cv-service.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action: 'delete', id: id })
    });
    const result = await res.json();
    if (result.success) {
      if (typeof skyToast === 'function') skyToast('🗑️ CV sənədi qovluqdan silindi.', '✅', 2000);
      loadSavedCvs();
      return;
    }
  } catch (err) {
    console.warn('API delete error, deleting from LocalStorage:', err);
  }

  // Local fallback
  const localSaved = JSON.parse(localStorage.getItem('skyweb_saved_cvs') || '[]');
  const filtered = localSaved.filter(c => c.id !== id);
  localStorage.setItem('skyweb_saved_cvs', JSON.stringify(filtered));
  if (typeof skyToast === 'function') skyToast('🗑️ CV silindi.', '✅', 2000);
  renderSavedCvsLocal();
}

// ── Templates Data & 3x4 Image-Integrated Simulation Renderers ──
const templatesData = {
  'tpl-1': {
    name: 'Professional Elite',
    desc: 'Ciddi, nizamlı və ənənəvi sahələr üçün mükəmməl seçim. ATS (kadr seçim proqramları) tərəfindən 100% oxunaqlıdır. Rəsmi qurumlar, banklar və hüquq firmaları üçün tövsiyə olunur.',
    sectors: ['Bank & Maliyyə', 'Hüquq', 'Dövlət Sektoru', 'Konsaltinq'],
    features: ['100% ATS Uyğun', 'Klassik və Rəsmi Dizayn', '3x4 Standart Portret İnteqrasiyası', 'Strukturlaşdırılmış Bölmələr'],
    emoji: '💼',
    render: (name, role, email, phone, city, summary, photoUrl) => `
      <div class="sim-cv-tpl-1">
        <div class="cv-header" style="display:flex;align-items:center;gap:16px;">
          <div style="width:54px;height:72px;border-radius:6px;overflow:hidden;background:linear-gradient(135deg,#f59e0b,#f97316);flex-shrink:0;border:1px solid rgba(245,158,11,0.5);box-shadow:0 4px 10px rgba(0,0,0,0.15);display:flex;align-items:center;justify-content:center;">
            ${photoUrl ? `<img src="${photoUrl}" alt="${name}" style="width:100%;height:100%;object-fit:cover;">` : `<span style="font-size:1.6rem;color:#fff;">👤</span>`}
          </div>
          <div style="flex:1;">
            <div class="cv-name">${name}</div>
            <div class="cv-role">${role}</div>
            <div class="cv-contact">📧 ${email} | 📞 ${phone} | 📍 ${city}</div>
          </div>
        </div>
        <div>
          <div class="cv-section-title">Peşəkar Xülasə</div>
          <p style="font-size:0.75rem; color:#475569; margin: 0.3rem 0 0.8rem 0; line-height:1.5;">${summary}</p>
        </div>
        <div>
          <div class="cv-section-title">İş Təcrübəsi</div>
          <div class="cv-item">
            <div class="cv-item-title"><span>Baş Mütəxəssis</span> <span>2022 - Hal-hazırda</span></div>
            <div class="cv-item-sub">Beynəlxalq Holdinq MMC</div>
            <p style="font-size:0.7rem; color:#64748b; margin-top:2px;">Maliyyə hesabatlarının hazırlanması, risklərin idarə olunması və audit proseslərinin koordinasiyası.</p>
          </div>
        </div>
        <div>
          <div class="cv-section-title">Təhsil</div>
          <div class="cv-item">
            <div class="cv-item-title"><span>Maliyyə (Bakalavr)</span> <span>2018 - 2022</span></div>
            <div class="cv-item-sub">Dövlət İqtisad Universiteti</div>
          </div>
        </div>
      </div>
    `
  },
  'tpl-2': {
    name: 'Müasir Texnoloji',
    desc: 'İnnovativ və müasir üslubu sevənlər üçün dizayn edilmişdir. GitHub, LinkedIn və digər linklər üçün xüsusi sahələrə malikdir. Proqram təminatı və analitika sahəsində çalışanlar üçün idealdır.',
    sectors: ['İT & Proqramlaşdırma', 'Data Analitika', 'Rəqəmsal Marketinq', 'Mühəndislik'],
    features: ['GitHub & Portfolio Linki', '3x4 Şəkil və İki Bölməli Vizual', 'Texniki Bacarıq Qrupları', 'İnnovativ Şrift Strukturu'],
    emoji: '🚀',
    render: (name, role, email, phone, city, summary, photoUrl) => `
      <div class="sim-cv-tpl-2">
        <div class="cv-header" style="display:flex;align-items:center;gap:16px;">
          <div style="width:54px;height:72px;border-radius:8px;overflow:hidden;background:#1e293b;flex-shrink:0;border:2px solid #38bdf8;box-shadow:0 4px 12px rgba(56,189,248,0.25);display:flex;align-items:center;justify-content:center;">
            ${photoUrl ? `<img src="${photoUrl}" alt="${name}" style="width:100%;height:100%;object-fit:cover;">` : `<span style="font-size:1.6rem;color:#38bdf8;">👤</span>`}
          </div>
          <div style="flex:1;">
            <div class="cv-name">${name}</div>
            <div class="cv-role">${role}</div>
            <div class="cv-contact">📧 ${email} | 📞 ${phone} | 📍 ${city}</div>
          </div>
        </div>
        <div>
          <div class="cv-section-title">⚡ XÜLASƏ</div>
          <p style="font-size:0.75rem; color:#475569; margin: 0.3rem 0 0.8rem 0; line-height:1.5;">${summary}</p>
        </div>
        <div>
          <div class="cv-section-title">🛠️ TEXNİKİ BACARIQLAR</div>
          <div style="margin: 0.4rem 0 0.8rem 0;">
            <span class="cv-chip">JavaScript</span>
            <span class="cv-chip">React</span>
            <span class="cv-chip">PHP</span>
            <span class="cv-chip">SQL</span>
            <span class="cv-chip">Git & GitHub</span>
          </div>
        </div>
        <div>
          <div class="cv-section-title">💼 KARYERA YOLU</div>
          <div class="cv-item">
            <div style="font-weight:700; font-size:0.75rem;">Full Stack Developer | TechSolutions MMC</div>
            <div style="font-size:0.68rem; color:#64748b;">2023 - Hal-hazırda</div>
            <p style="font-size:0.7rem; color:#64748b; margin-top:2px;">Veb tətbiqlərin memarlığının qurulması və API inteqrasiyalarının təmin edilməsi.</p>
          </div>
        </div>
      </div>
    `
  },
  'tpl-3': {
    name: 'Kreativ Premium',
    desc: 'Yaradıcı şəxslər üçün parlaq və yaddaqalan gradient dizayn. Portfolio vurğusu və dinamik rəng çalarları ilə digər CV-lərdən dərhal fərqlənir.',
    sectors: ['UX/UI Dizayn', 'Qrafik Dizayn', 'Media & PR', 'Kopiraytinq'],
    features: ['Premium Gradient Başlıq', '3x4 Şəkil Çərçivəsi', 'Bacarıq Faiz Qrafikləri', 'Dinamik Layout'],
    emoji: '🎨',
    render: (name, role, email, phone, city, summary, photoUrl) => `
      <div class="sim-cv-tpl-3">
        <div class="cv-top-bar" style="display:flex;align-items:center;gap:18px;">
          <div style="width:60px;height:80px;border-radius:10px;overflow:hidden;background:rgba(255,255,255,0.25);flex-shrink:0;border:2.5px solid #fff;box-shadow:0 6px 16px rgba(0,0,0,0.25);display:flex;align-items:center;justify-content:center;">
            ${photoUrl ? `<img src="${photoUrl}" alt="${name}" style="width:100%;height:100%;object-fit:cover;">` : `<span style="font-size:1.8rem;color:#fff;">👤</span>`}
          </div>
          <div style="flex:1;">
            <div class="cv-name">${name}</div>
            <div class="cv-role">${role}</div>
            <div class="cv-contact">📧 ${email} | 📞 ${phone} | 📍 ${city}</div>
          </div>
        </div>
        <div class="cv-inner-body">
          <div>
            <div class="cv-section-title">Haqqımda</div>
            <p style="font-size:0.75rem; color:#475569; margin: 0.3rem 0 0.8rem 0; line-height:1.5;">${summary}</p>
          </div>
          <div>
            <div class="cv-section-title">Yaradıcı Bacarıqlar</div>
            <div style="margin-bottom: 0.6rem; font-size: 0.72rem;">
              <div style="display:flex; justify-content:space-between; margin-bottom:2px;"><span>Figma & Adobe XD</span><span>90%</span></div>
              <div class="cv-skill-bar"><div class="cv-skill-fill" style="width: 90%;"></div></div>
            </div>
            <div style="font-size: 0.72rem;">
              <div style="display:flex; justify-content:space-between; margin-bottom:2px;"><span>Qrafik Dizayn & Brendinq</span><span>80%</span></div>
              <div class="cv-skill-bar"><div class="cv-skill-fill" style="width: 80%;"></div></div>
            </div>
          </div>
        </div>
      </div>
    `
  },
  'tpl-4': {
    name: 'Modern Minimalist',
    desc: 'Liderlər və yüksək dərəcəli menecerlər üçün prestijli, minimalist dizayn. Təmiz, sadə, lakin son dərəcə peşəkar görünüş ilə nəticələrə və KPI göstəricilərinə fokuslanır.',
    sectors: ['İcraçı Direktor (CEO)', 'Məhsul Meneceri', 'Layihə Rəhbəri', 'HR Menecer'],
    features: ['Zərif Yaşıl / Executive Rəng', '3x4 Zərif Foto Box', 'Nailiyyət & KPI Fokuslu', 'Mükəmməl Tipoqrafiya'],
    emoji: '👔',
    render: (name, role, email, phone, city, summary, photoUrl) => `
      <div class="sim-cv-tpl-4">
        <div class="cv-header">
          <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:52px;height:70px;border-radius:6px;overflow:hidden;background:#d1fae5;flex-shrink:0;border:1.5px solid #10b981;box-shadow:0 4px 10px rgba(0,0,0,0.1);display:flex;align-items:center;justify-content:center;">
              ${photoUrl ? `<img src="${photoUrl}" alt="${name}" style="width:100%;height:100%;object-fit:cover;">` : `<span style="font-size:1.5rem;color:#064e3b;">👤</span>`}
            </div>
            <div>
              <div class="cv-name">${name}</div>
              <div class="cv-role">${role}</div>
            </div>
          </div>
          <div class="cv-contact">
            <div>📧 ${email}</div>
            <div>📞 ${phone}</div>
            <div>📍 ${city}</div>
          </div>
        </div>
        <div>
          <div class="cv-section-title">Karyera Strategiyası</div>
          <p style="font-size:0.75rem; color:#475569; margin: 0.3rem 0 0.8rem 0; line-height:1.5;">${summary}</p>
        </div>
        <div>
          <div class="cv-section-title">Əsas Nailiyyətlər</div>
          <p style="font-size:0.7rem; color:#475569; line-height: 1.5; margin: 0.3rem 0 0.8rem 0;">
            • Satış komandasının idarə olunması sayəsində gəlirlərin 35% artırılması.<br>
            • Yeni rəqəmsal transformasiya layihəsinin 3 ay müddətinə tətbiqi.
          </p>
        </div>
      </div>
    `
  },
  'tpl-5': {
    name: 'Gənc Start',
    desc: 'Tələbələr, məzunlar və könüllülər üçün xüsusi dizayn edilmiş şablon. Təcrübə azlığı olan hallarda təhsil, könüllü fəaliyyət və fərdi keyfiyyətləri ön plana çıxarır.',
    sectors: ['Tələbələr', 'Könüllülər', 'Məzunlar', 'Junior Vəzifələr'],
    features: ['İki Sütunlu Struktur', '3x4 Mərkəzi Profil Şəkli', 'Təhsil & Kurs Vurğusu', 'Könüllülük Bölməsi'],
    emoji: '🎓',
    render: (name, role, email, phone, city, summary, photoUrl) => `
      <div class="sim-cv-tpl-5">
        <div class="cv-sidebar">
          <div style="width:58px;height:78px;border-radius:8px;overflow:hidden;background:#e0e7ff;margin:0 auto 10px;border:2px solid #6366f1;box-shadow:0 4px 10px rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;">
            ${photoUrl ? `<img src="${photoUrl}" alt="${name}" style="width:100%;height:100%;object-fit:cover;">` : `<span style="font-size:1.6rem;color:#4338ca;">👤</span>`}
          </div>
          <div class="cv-name" style="text-align:center;">${name}</div>
          <div class="cv-role" style="font-size:0.75rem;text-align:center;">${role}</div>
          <div class="cv-sidebar-section" style="margin-top:1rem;">
            <div class="cv-section-title" style="font-size:0.7rem;">Əlaqə</div>
            <div style="font-size:0.65rem; color:#4b5563; line-height: 1.4;">
              <div>📧 ${email}</div>
              <div>📞 ${phone}</div>
              <div>📍 ${city}</div>
            </div>
          </div>
          <div class="cv-sidebar-section">
            <div class="cv-section-title" style="font-size:0.7rem;">Dillər</div>
            <div style="font-size:0.65rem; font-weight: 600; line-height: 1.4;">
              <div>Azərbaycan (Ana)</div>
              <div>İngilis dili (C1)</div>
            </div>
          </div>
        </div>
        <div class="cv-main-content">
          <div>
            <div class="cv-section-title">Profil</div>
            <p style="font-size:0.7rem; color:#475569; margin: 0.2rem 0 0.6rem 0; line-height:1.5;">${summary}</p>
          </div>
          <div>
            <div class="cv-section-title">Təhsil</div>
            <div class="cv-item">
              <div style="font-weight:700; font-size:0.72rem;">İnformasiya Texnologiyaları</div>
              <div style="font-size:0.65rem; color:#64748b; margin-bottom: 2px;">Bakı Dövlət Universiteti</div>
              <div style="font-size:0.65rem; color:#94a3b8;">2021 - 2025</div>
            </div>
          </div>
        </div>
      </div>
    `
  },
  'tpl-6': {
    name: 'ATS-Friendly Pro',
    desc: 'HR sistemləri (Applicant Tracking Systems) tərəfindən 100% oxunaqlıdır. Sadə, təmiz və açıq format. Bütün sektorlar üçün uyğundur, xüsusilə böyük şirkətlərə müraciət zamanı ideal seçimdir.',
    sectors: ['Bütün Sektorlar', 'Böyük Korporasiyalar', 'HR Sistemləri', 'Beynəlxalq Müraciətlər'],
    features: ['100% ATS Skan Uyğunluğu', 'Keyword Optimallaşdırılmış', 'Sadə & Təmiz Format', 'Hər Sektor Üçün Uyğun'],
    emoji: '🤖',
    render: (name, role, email, phone, city, summary, photoUrl) => `
      <div class="sim-cv-tpl-1" style="border-top: 4px solid #06b6d4;">
        <div class="cv-header" style="border-bottom-color: #06b6d4;">
          <div class="cv-name" style="color:#0e7490;">${name}</div>
          <div class="cv-role" style="color:#06b6d4; font-weight:700;">${role}</div>
          <div class="cv-contact">📧 ${email} | 📞 ${phone} | 📍 ${city}</div>
          ${photoUrl ? `<div style="margin-top:6px;font-size:0.68rem;color:#64748b;font-style:italic;">[3x4 Profil Şəkli Əlavə Edilib (ATS Standartı Üçün İstəyə Bağlı)]</div>` : ''}
        </div>
        <div>
          <div class="cv-section-title" style="color:#0e7490; border-bottom-color:#a5f3fc;">PEŞƏKAR XÜLASƏ</div>
          <p style="font-size:0.75rem; color:#334155; margin: 0.3rem 0 0.8rem 0; line-height:1.6;">${summary}</p>
        </div>
        <div>
          <div class="cv-section-title" style="color:#0e7490; border-bottom-color:#a5f3fc;">İŞ TƏCRÜBƏSİ</div>
          <div class="cv-item">
            <div class="cv-item-title"><span>Baş Mütəxəssis</span> <span>2021 - İndiki</span></div>
            <div class="cv-item-sub">Azərbaycan Beynəlxalq Bank</div>
            <ul style="font-size:0.7rem; color:#475569; margin: 4px 0 0 12px; padding:0; line-height:1.5;">
              <li>Maliyyə hesabatlarının tərtib edilməsi</li>
              <li>ATS sistemlərinə uyğun keyword əsasında CV yenilənməsi</li>
            </ul>
          </div>
        </div>
        <div>
          <div class="cv-section-title" style="color:#0e7490; border-bottom-color:#a5f3fc;">TƏHSİL</div>
          <div class="cv-item">
            <div class="cv-item-title"><span>İqtisadiyyat (Bakalavr)</span> <span>2017 - 2021</span></div>
            <div class="cv-item-sub">BDU — Bakı Dövlət Universiteti</div>
          </div>
        </div>
        <div>
          <div class="cv-section-title" style="color:#0e7490; border-bottom-color:#a5f3fc;">ƏSAS BACARIQLAR</div>
          <div style="display:flex; flex-wrap:wrap; gap:4px; margin-top:4px;">
            <span style="background:#ecfeff; border:1px solid #06b6d4; color:#0e7490; padding:2px 7px; border-radius:4px; font-size:0.7rem; font-weight:600;">MS Excel</span>
            <span style="background:#ecfeff; border:1px solid #06b6d4; color:#0e7490; padding:2px 7px; border-radius:4px; font-size:0.7rem; font-weight:600;">1C Mühasibat</span>
            <span style="background:#ecfeff; border:1px solid #06b6d4; color:#0e7490; padding:2px 7px; border-radius:4px; font-size:0.7rem; font-weight:600;">ATS Keywords</span>
            <span style="background:#ecfeff; border:1px solid #06b6d4; color:#0e7490; padding:2px 7px; border-radius:4px; font-size:0.7rem; font-weight:600;">SAP</span>
          </div>
        </div>
      </div>
    `
  }
};

// ── Preview Modal Logic ──
function openPreviewModal(tplId) {
  currentPreviewTplId = tplId;
  const tpl = templatesData[tplId];
  if (!tpl) return;
  
  // Fill details
  document.getElementById('modalHeaderEmoji').textContent = tpl.emoji;
  document.getElementById('modalHeaderTitle').textContent = tpl.name + ' - Şablon Önizləmə';
  document.getElementById('infoTplName').textContent = tpl.name;
  document.getElementById('infoTplDesc').textContent = tpl.desc;
  
  // Sectors
  const sectorsCont = document.getElementById('infoTplSectors');
  sectorsCont.innerHTML = '';
  tpl.sectors.forEach(s => {
    const span = document.createElement('span');
    span.className = 'preview-info-chip';
    span.textContent = s;
    sectorsCont.appendChild(span);
  });
  
  // Features
  const featuresCont = document.getElementById('infoTplFeatures');
  featuresCont.innerHTML = '';
  tpl.features.forEach(f => {
    const div = document.createElement('div');
    div.className = 'preview-feature-item';
    div.innerHTML = `<span class="preview-feature-icon">✓</span> ${f}`;
    featuresCont.appendChild(div);
  });
  
  // Choose button binding
  const chooseBtn = document.getElementById('modalChooseTplBtn');
  chooseBtn.onclick = () => {
    selectTemplate(tplId, tpl.name);
    closePreviewModal();
  };
  
  // Render simulated CV
  updateSimulatedCv();
  
  // Set default active device simulator
  changeDevice('desktop');
  
  // Open modal
  const modal = document.getElementById('tplPreviewModal');
  modal.style.display = 'flex';
  setTimeout(() => modal.classList.add('active'), 10);
}

function closePreviewModal() {
  const modal = document.getElementById('tplPreviewModal');
  modal.classList.remove('active');
  setTimeout(() => modal.style.display = 'none', 300);
}

function changeDevice(device) {
  document.querySelectorAll('.device-switch-btn').forEach(btn => btn.classList.remove('active'));
  const btn = document.getElementById('dev-btn-' + device);
  if (btn) btn.classList.add('active');
  
  const frame = document.getElementById('deviceViewportFrame');
  if (!frame) return;
  frame.className = ''; // Reset
  
  if (device === 'desktop') {
    frame.className = 'device-frame-desktop';
  } else if (device === 'tablet') {
    frame.className = 'device-frame-tablet';
  } else if (device === 'mobile') {
    frame.className = 'device-frame-mobile';
  }
}

function buildDynamicCvHtml(tplId, d) {
  const name = ((d.fname || '') + ' ' + (d.lname || '')).trim() || 'Namizəd';
  const role = d.role || 'Mütəxəssis';
  const email = d.email || '';
  const phone = d.phone || '';
  const city = d.city || '';
  const linkedin = d.linkedin || '';
  const portfolio = d.portfolio || '';
  const summary = d.summary || '';
  const photoUrl = d.photo_url || '';

  let contactItems = [];
  if (email) contactItems.push(`📧 ${email}`);
  if (phone) contactItems.push(`📞 ${phone}`);
  if (city) contactItems.push(`📍 ${city}`);
  if (linkedin) contactItems.push(`🔗 ${linkedin}`);
  if (portfolio) contactItems.push(`🌐 ${portfolio}`);
  const contactStr = contactItems.join(' | ');

  let expHtml = '';
  if (Array.isArray(d.experience) && d.experience.length > 0) {
    expHtml += `<div class="cv-section-title" style="font-weight:700;font-size:0.75rem;border-bottom:1px solid #e2e8f0;margin-top:10px;margin-bottom:4px;text-transform:uppercase;">İş Təcrübəsi</div>`;
    d.experience.forEach(exp => {
      const dates = (exp.date_start || '') + (exp.date_start && exp.date_end ? ' - ' : '') + (exp.date_end || '');
      expHtml += `
        <div class="cv-item" style="margin-bottom:6px;">
          <div style="font-weight:700;font-size:0.72rem;display:flex;justify-content:space-between;">
            <span>${exp.position || ''} ${exp.company ? '— ' + exp.company : ''}</span>
            <span>${dates}</span>
          </div>
          ${exp.duties ? `<p style="font-size:0.68rem;color:#475569;margin-top:2px;">${exp.duties}</p>` : ''}
        </div>
      `;
    });
  }

  let eduHtml = '';
  if (Array.isArray(d.education) && d.education.length > 0) {
    eduHtml += `<div class="cv-section-title" style="font-weight:700;font-size:0.75rem;border-bottom:1px solid #e2e8f0;margin-top:10px;margin-bottom:4px;text-transform:uppercase;">Təhsil</div>`;
    d.education.forEach(edu => {
      eduHtml += `
        <div class="cv-item" style="margin-bottom:6px;">
          <div style="font-weight:700;font-size:0.72rem;display:flex;justify-content:space-between;">
            <span>${edu.school || ''}</span>
            <span>${edu.year || ''}</span>
          </div>
          <div style="font-size:0.68rem;color:#64748b;">${[edu.degree, edu.field].filter(Boolean).join(' · ')}</div>
          ${edu.note ? `<p style="font-size:0.65rem;color:#475569;margin-top:2px;">${edu.note}</p>` : ''}
        </div>
      `;
    });
  }

  let skillsHtml = '';
  if (Array.isArray(d.skills) && d.skills.length > 0) {
    skillsHtml += `<div class="cv-section-title" style="font-weight:700;font-size:0.75rem;border-bottom:1px solid #e2e8f0;margin-top:10px;margin-bottom:4px;text-transform:uppercase;">Texniki Bacarıqlar</div><div style="display:flex;flex-wrap:wrap;gap:4px;margin-bottom:6px;">`;
    d.skills.forEach(s => {
      skillsHtml += `<span style="background:#f1f5f9;border:1px solid #cbd5e1;padding:2px 8px;border-radius:12px;font-size:0.65rem;font-weight:600;">${s}</span>`;
    });
    skillsHtml += `</div>`;
  }

  let langHtml = '';
  if (Array.isArray(d.languages) && d.languages.length > 0) {
    langHtml += `<div class="cv-section-title" style="font-weight:700;font-size:0.75rem;border-bottom:1px solid #e2e8f0;margin-top:10px;margin-bottom:4px;text-transform:uppercase;">Dil Bilikləri</div><div style="display:flex;flex-wrap:wrap;gap:4px;margin-bottom:6px;">`;
    d.languages.forEach(l => {
      if (l.lang) {
        langHtml += `<span style="background:#f1f5f9;border:1px solid #cbd5e1;padding:2px 8px;border-radius:12px;font-size:0.65rem;font-weight:600;">${l.lang}${l.level ? ' (' + l.level + ')' : ''}</span>`;
      }
    });
    langHtml += `</div>`;
  }

  let extraHtml = '';
  const certs = d.certifications || d['cv-cert'] || '';
  const awards = d.awards || d['cv-awards'] || '';
  const vol = d.volunteer || d['cv-volunteer'] || '';
  const cvLang = d.cv_language || d['cv-lang-pref'] || '';

  if (certs) {
    extraHtml += `<div class="cv-section-title" style="font-weight:700;font-size:0.75rem;border-bottom:1px solid #e2e8f0;margin-top:10px;margin-bottom:4px;text-transform:uppercase;">Sertifikatlar</div><p style="font-size:0.7rem;color:#475569;margin-bottom:6px;white-space:pre-line;">${certs}</p>`;
  }
  if (awards) {
    extraHtml += `<div class="cv-section-title" style="font-weight:700;font-size:0.75rem;border-bottom:1px solid #e2e8f0;margin-top:10px;margin-bottom:4px;text-transform:uppercase;">Mükafatlar & Nailiyyətlər</div><p style="font-size:0.7rem;color:#475569;margin-bottom:6px;white-space:pre-line;">${awards}</p>`;
  }
  if (vol) {
    extraHtml += `<div class="cv-section-title" style="font-weight:700;font-size:0.75rem;border-bottom:1px solid #e2e8f0;margin-top:10px;margin-bottom:4px;text-transform:uppercase;">Könüllü Fəaliyyət</div><p style="font-size:0.7rem;color:#475569;margin-bottom:6px;white-space:pre-line;">${vol}</p>`;
  }
  if (cvLang && cvLang !== 'az') {
    const lMap = { 'en': 'İngiliscə', 'az-en': 'İkidilli (AZ + EN)', 'ru': 'Rusca' };
    extraHtml += `<div class="cv-section-title" style="font-weight:700;font-size:0.75rem;border-bottom:1px solid #e2e8f0;margin-top:10px;margin-bottom:4px;text-transform:uppercase;">CV Dili</div><p style="font-size:0.7rem;color:#475569;margin-bottom:6px;">${lMap[cvLang] || cvLang}</p>`;
  }

  return `
    <div class="sim-cv-tpl-1">
      <div class="cv-header" style="display:flex;align-items:center;gap:14px;border-bottom:2px solid #0f172a;padding-bottom:10px;margin-bottom:10px;">
        <div style="width:54px;height:72px;border-radius:6px;overflow:hidden;background:#cbd5e1;flex-shrink:0;border:1px solid rgba(0,0,0,0.1);display:flex;align-items:center;justify-content:center;">
          ${photoUrl ? `<img src="${photoUrl}" alt="${name}" style="width:100%;height:100%;object-fit:cover;">` : `<span style="font-size:1.6rem;color:#64748b;">👤</span>`}
        </div>
        <div style="flex:1;">
          <div class="cv-name" style="font-size:1.1rem;font-weight:800;text-transform:uppercase;">${name}</div>
          <div class="cv-role" style="font-size:0.8rem;color:#d97706;font-weight:700;">${role}</div>
          <div class="cv-contact" style="font-size:0.68rem;color:#64748b;margin-top:3px;">${contactStr}</div>
        </div>
      </div>
      ${summary ? `<div><div class="cv-section-title" style="font-weight:700;font-size:0.75rem;border-bottom:1px solid #e2e8f0;margin-top:10px;margin-bottom:4px;text-transform:uppercase;">Peşəkar Xülasə</div><p style="font-size:0.72rem;color:#475569;margin:0.2rem 0 0.6rem 0;line-height:1.5;">${summary}</p></div>` : ''}
      ${expHtml}
      ${eduHtml}
      ${skillsHtml}
      ${langHtml}
      ${extraHtml}
    </div>
  `;
}

function updateSimulatedCv() {
  const targetTplId = currentPreviewTplId || selectedTemplateId || 'tpl-1';
  const tpl = templatesData[targetTplId];
  if (!tpl) return;
  
  const d = collectFormData();
  const contentArea = document.getElementById('simulatedCvContent');
  if (contentArea) {
    contentArea.innerHTML = buildDynamicCvHtml(targetTplId, d);
  }
}
</script>
</body>
</html>
