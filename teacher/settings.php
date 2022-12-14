<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit;
    } else {
        switch ($_SESSION['loggedin']) {
            case "student":
                header('Location: panel.php');
                break;
            case "teacher":
                break;
            default:
                break;
        }
    }

    if(!isset($_SESSION['attendance_i'])) $_SESSION['attendance_i'] = 0;
    if (isset($_SESSION['timetable_i'])) $_SESSION['timetable_i'] = 0;
    
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
    if (isset($_GET['action']) && $_GET['action'] == "font")
        SetFont($_GET['font']); 
    if (isset($_GET['action']) && $_GET['action'] == "contrast")
        SetContrast($_GET['contrast']);
    if (isset($_GET['action']) && $_GET['action'] == "theme")
        SetTheme($_GET['theme']);
    if (isset($_GET['action']) && $_GET['action'] == "color")
        SetColor($_GET['color']);

    function SetFont($font){
        $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
        mysqli_set_charset($conn, DB['charset']);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_query($conn, "UPDATE `users_students` SET `font` = '".$font."' WHERE `users_students`.`students_id` = ".$_SESSION['id'].";");
        mysqli_close($conn);
        $_SESSION['font'] = $font;
        setcookie('font', $_SESSION['font'], time() + (86400 * 30), "/");
    }

    function SetContrast($contrast){
        $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
        mysqli_set_charset($conn, DB['charset']);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_query($conn, "UPDATE `users_students` SET `contrast` = '".$contrast."' WHERE `users_students`.`students_id` = ".$_SESSION['id'].";");
        mysqli_close($conn);
        $_SESSION['contrast'] = $contrast;
        setcookie('contrast', $_SESSION['contrast'], time() + (86400 * 30), "/");
        $_SESSION['theme'] = 1; //! Motyw wraca do standardowego, bo po co komu te kolory jak u??ywa wysokiego kontrastu
        setcookie('theme', $_SESSION['theme'], time() + (86400 * 30), "/");
        $_SESSION['color'] = 0; //! Rip dla tego kto b??dzie testowa?? jak to dzia??a ;)
        setcookie('color', $_SESSION['color'], time() + (86400 * 30), "/");
    }

    function SetTheme($theme){
        $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
        mysqli_set_charset($conn, DB['charset']);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_query($conn, "UPDATE `users_students` SET `theme` = '".$theme."' WHERE `users_students`.`students_id` = ".$_SESSION['id'].";");
        $_SESSION['theme'] = $theme;
        setcookie('theme', $_SESSION['theme'], time() + (86400 * 30), "/");
    }
    function SetColor($color){
        $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
        mysqli_set_charset($conn, DB['charset']);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_query($conn, "UPDATE `users_students` SET `color` = '".$color."' WHERE `users_students`.`students_id` = ".$_SESSION['id'].";");
        $_SESSION['color'] = $color;
        setcookie('color', $_SESSION['color'], time() + (86400 * 30), "/");
    }

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
    <title>Zrealizowane tematy</title>

    
    <link rel="canonical" href="https://iiproject.ddns.net" />

    <meta name="language" content="pl" />
    <meta name="title" content="Dziennik elektroniczny" />
    <meta name="description" content="Dziennik elektroniczny dla szk???? ponadpodstawowych." />

    <meta name="author" content="Kacper Kostera, skimpertm@o2.pl, Skimper" />
    <meta name="copyright" content="Copyright &copy; 2022 by Kacper Kostera" />
    <meta name="keywords" content="dziennik, elektroniczny, szko??a" />
    <meta name="subject" content="Dziennik elektroniczny" />
    <meta name="revisit-after" content="1 days" />

    <link rel="icon" href="../img/browser/icon180.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="img/browser/icon180.ico" type="image/x-icon" />

    <meta property="og:url" content="https://iiproject.ddns.net" />
    <meta property="og:title" content="E-Dziennik" />
    <meta name="og:site_name" content="Dziennik elektroniczny" />
    <meta name="og:type" content="website" />
    <meta name="og:description" content="Zaloguj si?? do panelu" />
    <meta name="og:image" content="img/browser/icon180.ico" />
    <meta property="og:image:height" content="250" />
    <meta property="og:image:width" content="250" />
    <meta property="og:image:alt" content="E-Dziennik" />
    <meta name="og:email" content="skimpertm@o2.pl" />
    <meta name="theme-color" content="#464646" />

    <meta name="robots" content="noindex,nofollow" />
    <meta name="googlebot" content="noindex,nofollow" />
    <meta name="fragment" content="!">
    <meta name="google" content="nositelinkssearchbox" />

    <meta name="pinterest" content="nopin" />

    <link rel="stylesheet" href="../styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="../styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="../styles/style.css" type="text/css">

    <script src="../js/accessibility.js"></script>
    <script src="../js/theme.js"></script>

    <noscript>
        <div class="noscript"> 
            <p>Aby dziennik m??g?? dzia??a?? poprawnie, wymagana jest obs??uga JavaScript.</p>
            <a class="tutorial" target="_blank" href="https://www.geeksforgeeks.org/how-to-enable-javascript-in-my-browser/">W przypadku problem??w skorzystaj z tego poradnika!</a>
        </div>
    </noscript>
</head>
<body>
<script>
    setColor(<?php echo $_SESSION['color']; ?>);
    setTheme(<?php echo $_SESSION['theme']; ?>);
    accessibilityFont(<?php echo $_SESSION['font']; ?>);
    accessibilityContrast(<?php echo $_SESSION['contrast']; ?>);
</script>
<nav class="sidenav">
    <div class="profile">
        <img alt="Twoje zdj??cie profilowe" src="../profile/<?php if(is_readable('../profile/'.$_SESSION['id'] . '.jpeg')) {echo $_SESSION['id'];} else {echo "default";} ?>.jpeg" class="avatar"></img>
        <p><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></p>
        <div class="logout_holder" onclick="window.location.href='panel.php?action=logout'">
            <img class="logout" alt="Wyloguj si??" src="../img/icons/<?php echo ($_SESSION['color'] == '2') ? '0' : $_SESSION['color'];?>/shutdown_switch_icon.png">
        </div>
    </div>
    <a href="panel.php">Panel</a>
    <a href="">Aktualna lekcja</a>
    <a class="active" href="timetable.php">Plan lekcji</a>

    <a class="bottom active" href="settings.php">Ustawienia</a>
</nav>
<section>
    <header>
        <h1 class="settings_header">Ustawienia</h1>
    </header>
    <div class="settings">
        <div class="p1">
            <div class="settings_label">
                <p class="title">U??atwienia dost??pu</p>
                <p class="description">Dostosuj kontrast i wielko???? czcionki</p>
            </div>
            <div class="settings_setup">
                <a href="?action=font&font=0"><p class="font_button">A</p></a>
                <a href="?action=font&font=1"><p class="font_button">A+</p></a>
                <a href="?action=font&font=2"><p class="font_button">A++</p></a>
                <a href="?action=contrast&contrast=0"><p id="normal" class="contrast_button normal">Abc</p></a>
                <a href="?action=contrast&contrast=1"><p class="contrast_button contrast">Abc</p></a>
            </div>
        </div>
        <div class="p2">
        <div class="settings_label">
                <p class="title">Motyw</p>
                <p class="description">Wybierz motyw dziennika</p>
            </div>
            <div class="settings_setup">
                <a href="?action=color&color=0"><div class="theme_box theme_white"></div></a>
                <a href="?action=color&color=2"><div class="theme_box theme_medium"></div></a>
                <a href="?action=color&color=1"><div class="theme_box theme_dark"></div></a>
            </div>
        </div>
        <div class="p3">
            <div class="settings_label">
                <p class="title">Zestaw kolor??w</p>
                <p class="description">Wybierz kolorystyk?? dziennika</p>
            </div>
            <div class="settings_setup">
                <a href="?action=theme&theme=1"><div class="theme_box theme1"></div></a>
                <a href="?action=theme&theme=2"><div class="theme_box theme2"></div></a>
                <a href="?action=theme&theme=3"><div class="theme_box theme3"></div></a>
                <a href="?action=theme&theme=4"><div class="theme_box theme4"></div></a>
                <a href="?action=theme&theme=5"><div class="theme_box theme5"></div></a>
                <a href="?action=theme&theme=6"><div class="theme_box theme6"></div></a>
                <a href="?action=theme&theme=7"><div class="theme_box theme7"></div></a>
                <a href="?action=theme&theme=8"><div class="theme_box theme8"></div></a>
                <a href="?action=theme&theme=9"><div class="theme_box theme9"></div></a>
                <a href="?action=theme&theme=10"><div class="theme_box theme10"></div></a>
                <a href="?action=theme&theme=11"><div class="theme_box theme11"></div></a>
                <a href="?action=theme&theme=12"><div class="theme_box theme12"></div></a>
                <a href="?action=theme&theme=13"><div class="theme_box theme13"></div></a>
                <a href="?action=theme&theme=14"><div class="theme_box theme14"></div></a>
            </div>
        </div>
        <div class="p4">
            
        </div>
        <div class="p5">
            
        </div>
        <div class="p6">
            
        </div>
        <div class="p7">
            
        </div>
    </div>
</section>
<script src="../js/keyborad.js"></script>
</body>
</html>