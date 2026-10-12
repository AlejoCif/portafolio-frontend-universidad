<?php
ob_start();
header ("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-Type: text/html; charset=utf-8");
session_start();
if(!isset($_POST['noflush']))
    ob_end_flush();

$loc = $locr = "..";
$runphp = "run.php";
$runeditphp = "runedit.php";

require_once("$locr/globals.php");
require_once("$locr/db.php");

if(!isset($_POST['noflush'])) {
    require_once("$locr/version.php");
    echo "<!DOCTYPE html>\n<html lang=\"es\">\n<head>\n";
    echo "<meta charset=\"utf-8\">\n";
    echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
    echo "<title>BOCA Admin</title>\n";
    echo "<link href=\"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css\" rel=\"stylesheet\">\n";
    echo "<link rel=\"stylesheet\" href=\"$loc/boca-theme.css\">\n";
    echo "<style>
        body { padding-top: 0; }
        .boca-content { font-family: 'Segoe UI', Arial, sans-serif; font-size: 0.88rem; }
        .boca-content table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
        .boca-content table td, .boca-content table th { padding: 8px 12px; border-bottom: 1px solid #f0f2f4; }
        .boca-content table th { background: #f8f9fa; font-weight: 600; color: #7f8c8d; font-size: 0.78rem; text-transform: uppercase; }
        .boca-content input[type=text], .boca-content input[type=password],
        .boca-content select, .boca-content textarea {
            padding: 7px 10px; border: 1px solid #dce1e7; border-radius: 6px;
            font-size: 0.85rem; font-family: inherit; outline: none;
        }
        .boca-content input[type=submit], .boca-content input[type=button] {
            background-color: #2980b9; color: #fff; border: none;
            padding: 7px 18px; border-radius: 6px; cursor: pointer;
            font-size: 0.85rem; font-family: inherit;
        }
        .boca-content input[type=submit]:hover { background-color: #2471a3; }
        .boca-content a { color: #2980b9; text-decoration: none; }
        .boca-content a:hover { text-decoration: underline; }
        .boca-content h1, .boca-content h2, .boca-content h3 { color: #2c3e50; }
    </style>\n";
}

if(!ValidSession()) {
    InvalidSession("admin/index.php");
    ForceLoad("$loc/index.php");
}
if($_SESSION["usertable"]["usertype"] != "admin") {
    IntrusionNotify("admin/index.php");
    ForceLoad("$loc/index.php");
}

if ((isset($_GET["Submit1"]) && $_GET["Submit1"] == "Transfer") ||
    (isset($_GET["Submit3"]) && $_GET["Submit3"] == "Transfer scores")) {
    echo "<meta http-equiv=\"refresh\" content=\"60\" />";
}

if(!isset($_POST['noflush'])) {
    list($clockstr,$clocktype) = siteclock();
    $username = $_SESSION["usertable"]["username"];
    $sitenum  = $_SESSION["usertable"]["usersitenumber"];
    $initials = strtoupper(substr($username, 0, 1));

    // Determinar pagina activa
    $current = basename($_SERVER['PHP_SELF']);

    echo "</head>\n<body>\n";
    echo "<aside class=\"sidebar\">\n";
    echo "  <div class=\"sidebar-brand\">\n";
    echo "    <div class=\"logo-icon\">B</div>\n";
    echo "    <div><span>BOCA</span><small>Panel admin</small></div>\n";
    echo "  </div>\n";
    echo "  <div class=\"sidebar-section\">Competencia</div>\n";
    echo "  <nav class=\"sidebar-nav\">\n";
    echo "    <a href=\"run.php\" " . ($current=='run.php'?'class="active"':'') . "><i class=\"bi bi-send\"></i> Runs</a>\n";
    echo "    <a href=\"score.php\" " . ($current=='score.php'?'class="active"':'') . "><i class=\"bi bi-bar-chart-line\"></i> Score</a>\n";
    echo "    <a href=\"clar.php\" " . ($current=='clar.php'?'class="active"':'') . "><i class=\"bi bi-chat-dots\"></i> Clarificaciones</a>\n";
    echo "    <a href=\"report.php\" " . ($current=='report.php'?'class="active"':'') . "><i class=\"bi bi-file-text\"></i> Reportes</a>\n";
    echo "  </nav>\n";
    echo "  <div class=\"sidebar-section\">Gestion</div>\n";
    echo "  <nav class=\"sidebar-nav\">\n";
    echo "    <a href=\"user.php\" " . ($current=='user.php'?'class="active"':'') . "><i class=\"bi bi-people\"></i> Usuarios</a>\n";
    echo "    <a href=\"problem.php\" " . ($current=='problem.php'?'class="active"':'') . "><i class=\"bi bi-file-code\"></i> Problemas</a>\n";
    echo "    <a href=\"contest.php\" " . ($current=='contest.php'?'class="active"':'') . "><i class=\"bi bi-trophy\"></i> Competencia</a>\n";
    echo "    <a href=\"language.php\" " . ($current=='language.php'?'class="active"':'') . "><i class=\"bi bi-code-slash\"></i> Lenguajes</a>\n";
    echo "    <a href=\"answer.php\" " . ($current=='answer.php'?'class="active"':'') . "><i class=\"bi bi-check-circle\"></i> Respuestas</a>\n";
    echo "    <a href=\"task.php\" " . ($current=='task.php'?'class="active"':'') . "><i class=\"bi bi-list-check\"></i> Tareas</a>\n";
    echo "    <a href=\"site.php\" " . ($current=='site.php'?'class="active"':'') . "><i class=\"bi bi-diagram-3\"></i> Sitio</a>\n";
    echo "  </nav>\n";
    echo "  <div class=\"sidebar-section\">Sistema</div>\n";
    echo "  <nav class=\"sidebar-nav\">\n";
    echo "    <a href=\"misc.php\" " . ($current=='misc.php'?'class="active"':'') . "><i class=\"bi bi-gear\"></i> Misc</a>\n";
    echo "    <a href=\"log.php\" " . ($current=='log.php'?'class="active"':'') . "><i class=\"bi bi-journal-text\"></i> Logs</a>\n";
    echo "    <a href=\"files.php\" " . ($current=='files.php'?'class="active"':'') . "><i class=\"bi bi-archive\"></i> Backups</a>\n";
    echo "    <a href=\"option.php\" " . ($current=='option.php'?'class="active"':'') . "><i class=\"bi bi-sliders\"></i> Opciones</a>\n";
    echo "    <a href=\"$loc/index.php\"><i class=\"bi bi-box-arrow-left\"></i> Cerrar sesion</a>\n";
    echo "  </nav>\n";
    echo "  <div class=\"sidebar-footer\">BOCA &mdash; Poli Grancolombiano</div>\n";
    echo "</aside>\n";

    echo "<div class=\"main-content\">\n";
    echo "  <div class=\"topbar\">\n";
    echo "    <span class=\"topbar-title\">" . htmlspecialchars(ucfirst(str_replace('.php','',$current))) . "</span>\n";
    echo "    <div class=\"topbar-right\">\n";
    echo "      <span style=\"font-size:0.82rem;color:#7f8c8d;\">" . $clockstr . "</span>\n";
    echo "      <div class=\"topbar-user\">\n";
    echo "        <div class=\"avatar\">" . $initials . "</div>\n";
    echo "        <span>" . htmlspecialchars($username) . " (site " . $sitenum . ")</span>\n";
    echo "      </div>\n";
    echo "      <a href=\"$loc/index.php\" class=\"btn-logout\"><i class=\"bi bi-box-arrow-right\"></i> Salir</a>\n";
    echo "    </div>\n";
    echo "  </div>\n";
    echo "  <div class=\"page-body boca-content\">\n";
}
?>
