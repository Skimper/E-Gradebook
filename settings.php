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
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zrealizowane tematy</title>

    <link rel="stylesheet" href="./styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="./styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">

    <script src="./js/accessibility.js"></script>
</head>
<body>
<nav class="sidenav">
    <div class="profile">
        <img alt="Twoje zdjęcie profilowe" src="./img/avatar.jpeg" class="avatar"></img>
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
                <a href="?action=font&size=0"><p class="font_button">A</p></a>
                <a href="?action=font&size=1"><p class="font_button">A+</p></a>
                <a href="?action=font&size=2"><p class="font_button">A++</p></a>
                <a href="?action=contrast&contrast=false"><p id="normal" class="contrast_button normal">Abc</p></a>
                <a href="?action=contrast&contrast=true"><p class="contrast_button contrast">Abc</p></a>
            </div>
        </div>
        <div class="p2">
            <div class="settings_label">
                <p class="title">Motyw</p>
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
        <div class="p3">
            
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
<?php
    if (isset($_GET['action']) && $_GET['action'] == "logout")
        Logout();
    if (isset($_GET['action']) && $_GET['action'] == "font")
        SetFont($_GET['size']); 
    if (isset($_GET['action']) && $_GET['action'] == "contrast")
        SetContrast($_GET['contrast']);
    if (isset($_GET['action']) && $_GET['action'] == "theme")
        SetTheme($_GET['theme']);

    function SetFont($size){
        $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
        mysqli_set_charset($conn, DB['charset']);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_query($conn, "UPDATE `users_students` SET `theme` = '".$size."' WHERE `users_students`.`students_id` = ".$_SESSION['id'].";");
    }

    function SetContrast($contrast){
        $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
        mysqli_set_charset($conn, DB['charset']);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

    }

    function SetTheme($theme){
        $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
        mysqli_set_charset($conn, DB['charset']);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

    }

    function Logout() {
        $_SESSION = array();

        session_destroy();
        header("Location: http://localhost/infprojectpage/index.php");
    }
?>
<script src="./js/keyborad.js"></script>
</body>
</html>