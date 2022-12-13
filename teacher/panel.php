<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit;
    }

    require('../api/sql.php');
?>
<?php 
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
?>
<?php
    if (isset($_GET['action']) && $_GET['action'] == "logout")
        Logout();

    function Logout() {
        $_SESSION = array();

        session_destroy();
        header("Location: http://localhost/infprojectpage/index.php");
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,  user-scalable=no">
    <title>Panel nauczyciela</title>

    <link rel="stylesheet" href="../styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="../styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="../styles/style.css" type="text/css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <script src="../js/accessibility.js"></script>
    <script src="../js/theme.js"></script>
    
    <noscript>
        <div class="noscript"> 
            <p>Aby dziennik mógł działać poprawnie, wymagana jest obsługa JavaScript.</p>
            <a class="tutorial" target="_blank" href="https://www.geeksforgeeks.org/how-to-enable-javascript-in-my-browser/">W przypadku problemów skorzystaj z tego poradnika!</a>
        </div>
    </noscript>
</head>
<body>
<script>
    accessibilityContrast(<?php echo $_SESSION['contrast']; ?>);
    setColor(<?php echo $_SESSION['color']; ?>);
    setTheme(<?php echo $_SESSION['theme']; ?>);
    accessibilityFont(<?php echo $_SESSION['font']; ?>);
</script>
<nav class="sidenav">
    <div class="profile">
        <p><?php echo $_SESSION['Name']; ?></p>
    </div>
    <a class="active" href="panel.php">Panel</a>
    <a href="lekcja.php">Lekcja</a>
    <a href="panel.php">Plan lekcji</a>
    <a href="panel.php">Wycieczki</a>
    <a href="panel.php">Zebrania</a>
    <a href="panel.php">Korespondencja</a>

    <a href="#">Wychowawstwo</a>

    <a class="bottom" href="settings.php">Ustawienia</a>
</nav>
<section>
    <header>
        <h1 class="grades">Panel</h1>
    </header>
    <div class="panel">


    </div>
</section>
<script>
    RenderChart(<?php echo $ob . "," . $nb . "," . $nu; ?>);
</script>
<script src="./js/keyborad.js"></script>
</body>
</html>