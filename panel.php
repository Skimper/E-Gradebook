<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit;
    }

    define('CONN', array('localhost', 'root', '', 'infproject'));
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>

    <link rel="stylesheet" href="./styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="./styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">

    <script src="./js/profile.js" type="text/javascript"></script>
</head>
<body>
    <nav class="menu">
        <a href="#" class="menu_item menu_item_disabled" onclick="ProfileControler();">
            <img class="menu_profile_image" src="">
        </a>
        <a href="#" class="menu_item menu_info menu_active"" data-tooltip="xxx">
            <i class="material-icons">x</i>
        </a>
        <a href="#" class="menu_item menu_info" data-tooltip="xxx">
            <i class="material-icons">x</i>
        </a>
        <a href="#" class="menu_item menu_info" data-tooltip="xxx">
            <i class="material-icons">x</i>
        </a>
        <a href="#" class="menu_item menu_info" data-tooltip="xxx">
            <i class="material-icons">x</i>
        </a>
        <a href="?menu=logout" class="menu_bottom menu_info menu_item" data-tooltip="Wyloguj">
            <i class="material-icons">x</i>
        </a>
    </nav>
    
    <div class="menu_profile" id="profile" style="display: none;">
        <p><?php echo $_SESSION['username']; ?></p>
        <p><?php echo $_SESSION['email']; ?></p>
        <p><?php echo $_SERVER['REMOTE_ADDR']; ?></p>
    </div>
<?php
    if (isset($_GET['menu']) && $_GET['menu'] == "logout")
        Logout();

    function Logout() {
        $_SESSION = array();

        session_destroy();
        header("Location: http://localhost/infprojectpage/index.php");
    }
?>
</body>
</html>