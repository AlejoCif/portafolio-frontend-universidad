<?php
ob_start();
header ("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-Type: text/html; charset=utf-8");
session_start();
$_SESSION["loc"] = dirname($_SERVER['PHP_SELF']);
if($_SESSION["loc"]=="/") $_SESSION["loc"] = "";
$_SESSION["locr"] = dirname(__FILE__);
if($_SESSION["locr"]=="/") $_SESSION["locr"] = "";

require_once("globals.php");
require_once("db.php");

if (!isset($_GET["name"])) {
    if (ValidSession())
        DBLogOut($_SESSION["usertable"]["contestnumber"],
                 $_SESSION["usertable"]["usersitenumber"], $_SESSION["usertable"]["usernumber"],
                 $_SESSION["usertable"]["username"]=='admin');
    session_unset();
    session_destroy();
    session_start();
    $_SESSION["loc"] = dirname($_SERVER['PHP_SELF']);
    if($_SESSION["loc"]=="/") $_SESSION["loc"] = "";
    $_SESSION["locr"] = dirname(__FILE__);
    if($_SESSION["locr"]=="/") $_SESSION["locr"] = "";
}
if(isset($_GET["getsessionid"])) {
    echo session_id();
    exit;
}

$coo = array();
if(isset($_COOKIE['biscoitobocabombonera'])) {
    $coo = explode('-',$_COOKIE['biscoitobocabombonera']);
    if(count($coo) != 2 ||
       strlen($coo[1])!=strlen(myhash('xxx')) ||
       !is_numeric($coo[0]) ||
       !ctype_alnum($coo[1]))
        $coo = array();
}
if(count($coo) != 2)
    setcookie('biscoitobocabombonera',time() . '-' . myhash(time() . rand() . time() . rand()),time() + 240*3600);

ob_end_flush();
require_once('version.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOCA <?php echo $BOCAVERSION; ?> - Iniciar sesion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="boca-theme.css">
    <script src="sha256.js"></script>
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3a5f 0%, #152d4a 100%);
            display: flex; align-items: center; justify-content: center;
            padding: 20px; margin: 0;
        }
        .login-wrapper { width: 100%; max-width: 420px; }
        .login-logo { text-align: center; margin-bottom: 28px; }
        .login-logo .icono {
            width: 64px; height: 64px; background-color: #f39c12;
            border-radius: 16px; display: flex; align-items: center;
            justify-content: center; font-size: 1.8rem; font-weight: 800;
            color: #fff; margin: 0 auto 14px;
            box-shadow: 0 8px 24px rgba(243,156,18,0.35);
        }
        .login-logo h1 { color: #fff; font-size: 1.6rem; font-weight: 700; letter-spacing: 1px; }
        .login-logo p { color: rgba(255,255,255,0.55); font-size: 0.85rem; margin-top: 4px; }
        .login-card {
            background: #fff; border-radius: 14px; padding: 32px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
        }
        .login-card h2 { font-size: 1rem; font-weight: 600; color: #2c3e50; margin-bottom: 24px; }
        .input-icon { position: relative; }
        .input-icon i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #7f8c8d; }
        .input-icon input { padding-left: 36px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 0.82rem; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .form-group input, .form-group select {
            width: 100%; padding: 9px 12px; border: 1px solid #dce1e7;
            border-radius: 6px; font-size: 0.88rem; color: #2c3e50;
            box-sizing: border-box; font-family: inherit;
            transition: border-color 0.2s; outline: none;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #2980b9; box-shadow: 0 0 0 3px rgba(41,128,185,0.12);
        }
        .btn-login {
            width: 100%; padding: 11px; background-color: #2980b9; color: #fff;
            border: none; border-radius: 8px; font-size: 0.95rem; font-weight: 600;
            cursor: pointer; margin-top: 6px; display: flex; align-items: center;
            justify-content: center; gap: 8px; font-family: inherit;
            transition: all 0.2s;
        }
        .btn-login:hover { background-color: #2471a3; transform: translateY(-1px); }
        .alerta-error {
            background-color: rgba(231,76,60,0.08); border: 1px solid rgba(231,76,60,0.25);
            color: #e74c3c; border-radius: 8px; padding: 10px 14px;
            font-size: 0.84rem; margin-bottom: 16px;
            display: none; align-items: center; gap: 8px;
        }
        .login-footer { text-align: center; margin-top: 20px; color: rgba(255,255,255,0.4); font-size: 0.78rem; }
        .version-badge {
            display: inline-block; background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.5); padding: 2px 10px;
            border-radius: 10px; font-size: 0.72rem; margin-top: 6px;
        }
    </style>
    <script>
    function computeHASH() {
        var userHASH = document.form1.name.value;
        var passHASH = js_myhash(js_myhash(document.form1.password.value)+'<?php echo session_id(); ?>');
        document.form1.name.value = '';
        document.form1.password.value = '                                                                                 ';
        document.location = 'index.php?name='+userHASH+'&password='+passHASH;
    }
    </script>
</head>
<body onload="document.form1.name.focus()">
<?php
$loginError = false;
if(function_exists("globalconf") && function_exists("sanitizeVariables")) {
    if(isset($_GET["name"]) && $_GET["name"] != "") {
        $name = $_GET["name"];
        $password = $_GET["password"];
        $usertable = DBLogIn($name, $password);
        if(!$usertable) {
            $loginError = true;
        } else {
            if(($ct = DBContestInfo($_SESSION["usertable"]["contestnumber"])) == null)
                ForceLoad("index.php");
            if($ct["contestlocalsite"]==$ct["contestmainsite"]) $main=true; else $main=false;
            if(isset($_GET['action']) && $_GET['action'] == 'transfer') {
                echo "TRANSFER OK";
            } else {
                if($main && $_SESSION["usertable"]["usertype"] == 'site') {
                    MSGError('Direct login of this user is not allowed');
                    unset($_SESSION["usertable"]);
                    ForceLoad("index.php");
                    exit;
                }
                echo "<script>document.location='" . $_SESSION["usertable"]["usertype"] . "/index.php';</script>\n";
            }
            exit;
        }
    }
} else {
    echo "<script>alert('Unable to load config files. Possible file permission problem.');</script>\n";
}
?>

<div class="login-wrapper">
    <div class="login-logo">
        <div class="icono">B</div>
        <h1>BOCA</h1>
        <p>Online Contest Administrator</p>
        <span class="version-badge"><?php echo $BOCAVERSION; ?></span>
    </div>

    <div class="login-card">
        <h2>Iniciar sesion</h2>

        <?php if($loginError): ?>
        <div class="alerta-error" style="display:flex;">
            <i class="bi bi-exclamation-circle"></i>
            <span>Usuario o contrasena incorrectos.</span>
        </div>
        <?php endif; ?>

        <form name="form1" action="javascript:computeHASH()">
            <div class="form-group">
                <label>Usuario</label>
                <div class="input-icon">
                    <i class="bi bi-person"></i>
                    <input type="text" name="name" placeholder="Ingresa tu usuario" autocomplete="username">
                </div>
            </div>
            <div class="form-group">
                <label>Contrasena</label>
                <div class="input-icon">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" placeholder="Ingresa tu contrasena" autocomplete="current-password">
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                Ingresar
            </button>
        </form>
    </div>

    <div class="login-footer">
        BOCA Online Contest Administrator &mdash; Politecnico Grancolombiano
    </div>
</div>

<?php include('footnote.php'); ?>
</body>
</html>
