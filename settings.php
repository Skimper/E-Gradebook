<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit;
    }
    
    require('./api/sql.php');
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
        $_SESSION['theme'] = 1; // Motyw wraca do standardowego, bo po co komu te kolory jak używa wysokiego kontrastu
        setcookie('theme', $_SESSION['theme'], time() + (86400 * 30), "/");
        $_SESSION['color'] = 0; // Rip dla tego kto będzie testował jak to działa ;)
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

    <link rel="stylesheet" href="./styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="./styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">

    <script src="./js/accessibility.js"></script>
    <script src="./js/theme.js"></script>

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
        <img alt="Twoje zdjęcie profilowe" src="./profile/<?php echo $_SESSION['id']; ?>.jpeg" class="avatar"></img>
        <p><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></p>
        <p><?php echo $_SESSION['class'] ?></p>
    </div>
    <a href="panel.php">Panel</a>
    <a href="grades.php">Oceny</a>
    <a href="attendance.php">Frekwencja</a>
    <a href="timetable.php">Plan lekcji</a>
    <a href="exams.php">Sprawdziany</a>
    <a href="meetings.php">Wydarzenia</a>
    <a href="topics.php">Tematy</a>
    <a href="comments.php">Uwagi</a>

    <a class="bottom active" href="settings.php">Ustawienia</a>
</nav>
<section>
    <header>
        <h1 class="settings_header">Ustawienia</h1>
    </header>
    <div class="settings">
        <div class="p1">
            <div class="settings_label">
                <p class="title">Ułatwienia dostępu</p>
                <p class="description">Dostosuj kontrast i wielkość czcionki</p>
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
                <a href="?action=color&color=1"><div class="theme_box theme_dark"></div></a>
            </div>
        </div>
        <div class="p3">
            <div class="settings_label">
                <p class="title">Zestaw kolorów</p>
                <p class="description">Wybierz kolorystykę dziennika</p>
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
<script src="./js/keyborad.js"></script>
</body>
</html>