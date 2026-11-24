<?php
/**
 * SkyBot Admin Panel
 * URL: /sky/skybot/admin.php
 * Password: config/secrets.php → SKY_SECRET_SKYBOT_ADMIN_PASSWORD
 */

if (is_file(__DIR__ . '/../config/secrets.php')) {
    require_once __DIR__ . '/../config/secrets.php';
}

define('ADMIN_PASSWORD', defined('SKY_SECRET_SKYBOT_ADMIN_PASSWORD') ? SKY_SECRET_SKYBOT_ADMIN_PASSWORD : '');
define('KNOWLEDGE_FILE', __DIR__ . '/knowledge.php');

session_start();

// ── Auth ──────────────────────────────────────────────────────────────────────
$error = '';

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

if (!isset($_SESSION['skybot_admin'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        if (ADMIN_PASSWORD !== '' && hash_equals(ADMIN_PASSWORD, (string) $_POST['password'])) {
            $_SESSION['skybot_admin'] = true;
            header('Location: admin.php');
            exit;
        } else {
            $error = 'Yanlış şifrə!';
        }
    }
    // Show login form
    showLogin($error);
    exit;
}

// ── Load knowledge ────────────────────────────────────────────────────────────
require_once KNOWLEDGE_FILE;
// $skybot_knowledge is now available

// ── Handle actions ────────────────────────────────────────────────────────────
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // ── DELETE ────────────────────────────────────────────────────────────────
    if ($action === 'delete') {
        $delId = trim($_POST['entry_id'] ?? '');
        $skybot_knowledge = array_values(array_filter(
            $skybot_knowledge,
            fn($e) => ($e['id'] ?? '') !== $delId
        ));
        saveKnowledge($skybot_knowledge);
        $msg = "✅ \"$delId\" silindi.";
    }

    // ── EDIT ──────────────────────────────────────────────────────────────────
    if ($action === 'edit') {
        $editId = trim($_POST['entry_id'] ?? '');
        $keywords = array_map('trim', explode(',', $_POST['keywords'] ?? ''));
        $keywords = array_filter($keywords, fn($k) => $k !== '');

        // Parse links JSON
        $linksRaw = trim($_POST['links'] ?? '');
        $links = [];
        if ($linksRaw !== '') {
            $decoded = json_decode($linksRaw, true);
            if (is_array($decoded)) $links = $decoded;
        }

        foreach ($skybot_knowledge as &$entry) {
            if (($entry['id'] ?? '') === $editId) {
                $entry['topic']    = trim($_POST['topic'] ?? $entry['topic']);
                $entry['keywords'] = array_values($keywords);
                $entry['langs']['az'] = $_POST['lang_az'] ?? '';
                $entry['langs']['en'] = $_POST['lang_en'] ?? '';
                $entry['langs']['ru'] = $_POST['lang_ru'] ?? '';
                $entry['langs']['tr'] = $_POST['lang_tr'] ?? '';
                $entry['links']    = $links;
                break;
            }
        }
        unset($entry);
        saveKnowledge($skybot_knowledge);
        $msg = "✅ \"$editId\" yeniləndi.";
    }

    // ── ADD ───────────────────────────────────────────────────────────────────
    if ($action === 'add') {
        $newId = trim($_POST['new_id'] ?? '');
        if ($newId === '') {
            $msg = '❌ ID boş ola bilməz.';
        } else {
            // Check duplicate
            $exists = array_filter($skybot_knowledge, fn($e) => ($e['id'] ?? '') === $newId);
            if ($exists) {
                $msg = "❌ \"$newId\" artıq mövcuddur.";
            } else {
                $keywords = array_map('trim', explode(',', $_POST['new_keywords'] ?? ''));
                $keywords = array_filter($keywords, fn($k) => $k !== '');
                $linksRaw = trim($_POST['new_links'] ?? '');
                $links = [];
                if ($linksRaw !== '') {
                    $decoded = json_decode($linksRaw, true);
                    if (is_array($decoded)) $links = $decoded;
                }
                $skybot_knowledge[] = [
                    'id'       => $newId,
                    'topic'    => trim($_POST['new_topic'] ?? $newId),
                    'keywords' => array_values($keywords),
                    'langs'    => [
                        'az' => $_POST['new_lang_az'] ?? '',
                        'en' => $_POST['new_lang_en'] ?? '',
                        'ru' => $_POST['new_lang_ru'] ?? '',
                        'tr' => $_POST['new_lang_tr'] ?? '',
                    ],
                    'links' => $links,
                ];
                saveKnowledge($skybot_knowledge);
                $msg = "✅ \"$newId\" əlavə edildi.";
            }
        }
    }
}

// ── Reload after save ─────────────────────────────────────────────────────────
require_once KNOWLEDGE_FILE;

showAdmin($skybot_knowledge, $msg);

// ═════════════════════════════════════════════════════════════════════════════
// FUNCTIONS
// ═════════════════════════════════════════════════════════════════════════════

function saveKnowledge(array $data): void
{
    $export = "<?php\n/**\n * SkyBot Knowledge Base\n * Structured knowledge for SkyWeb.az intelligent chatbot\n * Auto-updated by Admin Panel\n */\n\n\$skybot_knowledge = ";
    $export .= prettyVarExport($data);
    $export .= ";\n";
    file_put_contents(KNOWLEDGE_FILE, $export);
    // Invalidate opcache if available
    if (function_exists('opcache_invalidate')) {
        opcache_invalidate(KNOWLEDGE_FILE, true);
    }
}

function prettyVarExport($val, int $depth = 0): string
{
    $pad = str_repeat('    ', $depth);
    $pad1 = str_repeat('    ', $depth + 1);
    if (is_array($val)) {
        if (empty($val)) return '[]';
        $isList = array_keys($val) === range(0, count($val) - 1);
        $lines = [];
        foreach ($val as $k => $v) {
            $key = $isList ? '' : var_export($k, true) . ' => ';
            $lines[] = $pad1 . $key . prettyVarExport($v, $depth + 1);
        }
        return "[\n" . implode(",\n", $lines) . ",\n$pad]";
    }
    return var_export($val, true);
}

function showLogin(string $error): void
{
    ?>
<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>SkyBot Admin – Giriş</title>
<style>
  *{box-sizing:border-box;margin:0;padding:0}
  body{min-height:100vh;display:flex;align-items:center;justify-content:center;background:#020d14;font-family:system-ui,sans-serif}
  .card{background:rgba(0,229,255,.05);border:1px solid rgba(0,229,255,.25);border-radius:14px;padding:40px 36px;width:360px;box-shadow:0 0 40px rgba(0,229,255,.1)}
  h1{color:#00e5ff;font-size:22px;margin-bottom:24px;text-align:center}
  label{color:#94a3b8;font-size:13px;display:block;margin-bottom:6px}
  input[type=password]{width:100%;padding:10px 14px;background:rgba(0,229,255,.07);border:1px solid rgba(0,229,255,.25);border-radius:8px;color:#e2e8f0;font-size:15px;outline:none}
  input[type=password]:focus{border-color:#00e5ff}
  button{margin-top:18px;width:100%;padding:11px;background:linear-gradient(135deg,#00b8d9,#c084fc);border:none;border-radius:8px;color:#fff;font-size:15px;font-weight:600;cursor:pointer}
  .err{color:#f87171;font-size:13px;margin-top:10px;text-align:center}
</style>
</head>
<body>
<div class="card">
  <h1>🤖 SkyBot Admin</h1>
  <form method="post">
    <label>Şifrə</label>
    <input type="password" name="password" autofocus>
    <button type="submit">Daxil ol</button>
    <?php if ($error): ?><p class="err"><?= htmlspecialchars($error) ?></p><?php endif; ?>
  </form>
</div>
</body>
</html>
    <?php
}

function showAdmin(array $knowledge, string $msg): void
{
    ?>
<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>SkyBot Admin Panel</title>
<style>
  *{box-sizing:border-box;margin:0;padding:0}
  body{background:#020d14;color:#e2e8f0;font-family:system-ui,sans-serif;font-size:14px}
  a{color:#00e5ff;text-decoration:none}
  .topbar{background:rgba(0,229,255,.06);border-bottom:1px solid rgba(0,229,255,.18);padding:14px 24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
  .topbar h1{color:#00e5ff;font-size:18px}
  .topbar-right{display:flex;gap:12px;align-items:center;flex-wrap:wrap}
  .note{background:rgba(0,229,255,.07);border-left:3px solid #00e5ff;padding:10px 16px;border-radius:0 8px 8px 0;color:#94a3b8;font-size:12px}
  .msg{padding:10px 16px;border-radius:8px;margin:16px 24px 0;font-size:13px;background:rgba(74,222,128,.1);border:1px solid rgba(74,222,128,.3);color:#4ade80}
  .container{padding:20px 24px}
  /* Table */
  .tbl-wrap{overflow-x:auto}
  table{width:100%;border-collapse:collapse;min-width:700px}
  th{background:rgba(0,229,255,.1);color:#00e5ff;font-size:12px;padding:9px 12px;text-align:left;border-bottom:1px solid rgba(0,229,255,.15)}
  td{padding:9px 12px;border-bottom:1px solid rgba(255,255,255,.05);vertical-align:middle}
  tr:hover td{background:rgba(0,229,255,.03)}
  .badge{display:inline-block;padding:2px 8px;border-radius:99px;font-size:11px;background:rgba(0,229,255,.12);color:#00e5ff;border:1px solid rgba(0,229,255,.2)}
  .kw-list{font-size:11px;color:#94a3b8;max-width:200px;line-height:1.6}
  /* Buttons */
  .btn{padding:6px 14px;border-radius:7px;border:none;font-size:12px;font-weight:600;cursor:pointer;transition:.15s}
  .btn-edit{background:rgba(96,165,250,.15);color:#60a5fa;border:1px solid rgba(96,165,250,.3)}
  .btn-edit:hover{background:rgba(96,165,250,.3)}
  .btn-del{background:rgba(248,113,113,.1);color:#f87171;border:1px solid rgba(248,113,113,.25)}
  .btn-del:hover{background:rgba(248,113,113,.25)}
  .btn-save{background:linear-gradient(135deg,#00b8d9,#c084fc);color:#fff;border:none}
  .btn-logout{background:rgba(248,113,113,.15);color:#f87171;border:1px solid rgba(248,113,113,.3)}
  /* Modal */
  .overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:999;align-items:center;justify-content:center}
  .overlay.show{display:flex}
  .modal{background:#0a1a24;border:1px solid rgba(0,229,255,.25);border-radius:14px;padding:28px;width:680px;max-width:95vw;max-height:90vh;overflow-y:auto}
  .modal h2{color:#00e5ff;font-size:16px;margin-bottom:20px}
  .form-group{margin-bottom:14px}
  label{display:block;color:#94a3b8;font-size:12px;margin-bottom:5px}
  input[type=text],textarea{width:100%;padding:8px 12px;background:rgba(0,229,255,.05);border:1px solid rgba(0,229,255,.2);border-radius:7px;color:#e2e8f0;font-size:13px;outline:none;resize:vertical;font-family:inherit}
  input[type=text]:focus,textarea:focus{border-color:#00e5ff}
  .tabs{display:flex;gap:4px;margin-bottom:8px}
  .tab-btn{padding:4px 12px;border-radius:6px;border:1px solid rgba(0,229,255,.2);background:transparent;color:#94a3b8;font-size:12px;cursor:pointer}
  .tab-btn.active{background:rgba(0,229,255,.15);color:#00e5ff}
  .tab-pane{display:none}.tab-pane.show{display:block}
  .add-section{margin-top:32px;padding-top:24px;border-top:1px solid rgba(255,255,255,.07)}
  .add-section h2{color:#c084fc;font-size:15px;margin-bottom:18px}
  .modal-actions{display:flex;gap:10px;margin-top:18px}
  .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
  @media(max-width:600px){.grid-2{grid-template-columns:1fr}}
</style>
</head>
<body>

<div class="topbar">
  <h1>🤖 SkyBot Admin Panel</h1>
  <div class="topbar-right">
    <span class="note">ℹ️ knowledge.php-ni dəyişmək SkyBot-u dərhal yeniləyir</span>
    <form method="post" style="margin:0">
      <button class="btn btn-logout" name="logout" value="1">Çıxış</button>
    </form>
  </div>
</div>

<?php if ($msg): ?>
<div class="msg"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<div class="container">
  <div class="tbl-wrap">
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>ID / Topic</th>
        <th>Keywords</th>
        <th>Dillər</th>
        <th>Links</th>
        <th>Əməliyyat</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($knowledge as $i => $e): ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <td>
          <span class="badge"><?= htmlspecialchars($e['id'] ?? '') ?></span><br>
          <small style="color:#64748b"><?= htmlspecialchars($e['topic'] ?? '') ?></small>
        </td>
        <td><div class="kw-list"><?= htmlspecialchars(implode(', ', $e['keywords'] ?? [])) ?></div></td>
        <td>
          <?php foreach (['az','en','ru','tr'] as $l): ?>
            <?php if (!empty($e['langs'][$l])): ?>
              <span class="badge" style="margin-bottom:3px"><?= $l ?></span>
            <?php endif; ?>
          <?php endforeach; ?>
        </td>
        <td><?= count($e['links'] ?? []) ?></td>
        <td style="display:flex;gap:6px;flex-wrap:wrap">
          <button class="btn btn-edit" onclick='openEdit(<?= htmlspecialchars(json_encode($e, JSON_UNESCAPED_UNICODE), ENT_QUOTES) ?>)'>✏️ Düzəliş</button>
          <form method="post" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="entry_id" value="<?= htmlspecialchars($e['id'] ?? '') ?>">
            <button class="btn btn-del" type="submit">🗑️ Sil</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>

  <!-- ── Add new ── -->
  <div class="add-section">
    <h2>➕ Yeni Mövzu Əlavə Et</h2>
    <form method="post">
      <input type="hidden" name="action" value="add">
      <div class="grid-2">
        <div class="form-group">
          <label>ID (unikal, boşluqsuz)</label>
          <input type="text" name="new_id" placeholder="new_topic_id" required>
        </div>
        <div class="form-group">
          <label>Topic</label>
          <input type="text" name="new_topic" placeholder="new_topic">
        </div>
      </div>
      <div class="form-group">
        <label>Keywords (vergüllə ayrılmış)</label>
        <input type="text" name="new_keywords" placeholder="keyword1, keyword2, ...">
      </div>
      <div class="form-group">
        <label>Links (JSON array, məs: [{"label":"Demo","url":"/demo"}])</label>
        <input type="text" name="new_links" placeholder='[{"label":"Demo","url":"/demo"}]'>
      </div>
      <?php foreach (['az'=>'Azərbaycan','en'=>'English','ru'=>'Русский','tr'=>'Türkçe'] as $lc => $ln): ?>
      <div class="form-group">
        <label><?= $ln ?> (<?= $lc ?>)</label>
        <textarea name="new_lang_<?= $lc ?>" rows="4" placeholder="<?= $ln ?> cavabı..."></textarea>
      </div>
      <?php endforeach; ?>
      <button class="btn btn-save" type="submit">💾 Əlavə Et</button>
    </form>
  </div>
</div>

<!-- ── Edit Modal ── -->
<div class="overlay" id="edit-overlay" onclick="if(event.target===this)closeEdit()">
  <div class="modal">
    <h2>✏️ Mövzunu Düzəlt</h2>
    <form method="post" id="edit-form">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" name="entry_id" id="edit-id">
      <div class="grid-2">
        <div class="form-group">
          <label>ID</label>
          <input type="text" id="edit-id-display" disabled style="opacity:.5">
        </div>
        <div class="form-group">
          <label>Topic</label>
          <input type="text" name="topic" id="edit-topic">
        </div>
      </div>
      <div class="form-group">
        <label>Keywords (vergüllə ayrılmış)</label>
        <input type="text" name="keywords" id="edit-keywords">
      </div>
      <div class="form-group">
        <label>Links (JSON)</label>
        <input type="text" name="links" id="edit-links">
      </div>
      <!-- Lang tabs -->
      <div class="tabs">
        <?php foreach (['az','en','ru','tr'] as $li => $lc): ?>
          <button type="button" class="tab-btn <?= $li===0?'active':'' ?>" onclick="switchTab(event,'<?= $lc ?>')">
            <?= strtoupper($lc) ?>
          </button>
        <?php endforeach; ?>
      </div>
      <?php foreach (['az'=>'Azərbaycan','en'=>'English','ru'=>'Русский','tr'=>'Türkçe'] as $lc => $ln): ?>
      <div class="tab-pane <?= $lc==='az'?'show':'' ?>" id="tab-<?= $lc ?>">
        <div class="form-group">
          <label><?= $ln ?></label>
          <textarea name="lang_<?= $lc ?>" id="edit-lang-<?= $lc ?>" rows="6"></textarea>
        </div>
      </div>
      <?php endforeach; ?>
      <div class="modal-actions">
        <button class="btn btn-save" type="submit">💾 Yadda Saxla</button>
        <button class="btn btn-edit" type="button" onclick="closeEdit()">Ləğv et</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEdit(entry) {
  document.getElementById('edit-id').value         = entry.id || '';
  document.getElementById('edit-id-display').value  = entry.id || '';
  document.getElementById('edit-topic').value       = entry.topic || '';
  document.getElementById('edit-keywords').value    = (entry.keywords || []).join(', ');
  document.getElementById('edit-links').value       = JSON.stringify(entry.links || []);
  ['az','en','ru','tr'].forEach(function(l) {
    document.getElementById('edit-lang-' + l).value = (entry.langs && entry.langs[l]) ? entry.langs[l] : '';
  });
  document.getElementById('edit-overlay').classList.add('show');
}
function closeEdit() {
  document.getElementById('edit-overlay').classList.remove('show');
}
function switchTab(evt, lang) {
  document.querySelectorAll('.tab-pane').forEach(function(p){ p.classList.remove('show'); });
  document.querySelectorAll('.tab-btn').forEach(function(b){ b.classList.remove('active'); });
  document.getElementById('tab-' + lang).classList.add('show');
  evt.currentTarget.classList.add('active');
}
</script>
</body>
</html>
    <?php
}
