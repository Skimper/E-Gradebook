<?php
    session_start();

    if(isset($_SESSION['attendance_i'])) $_SESSION['attendance_i'] = 0;
    if (isset($_SESSION['timetable_i'])) $_SESSION['timetable_i'] = 0;

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
    <title>Panel</title>

    <link rel="canonical" href="https://iiproject.ddns.net" />

    <meta name="language" content="pl" />
    <meta name="title" content="Dziennik elektroniczny" />
    <meta name="description" content="Dziennik elektroniczny dla szkół ponadpodstawowych." />

    <meta name="author" content="Kacper Kostera, skimpertm@o2.pl, Skimper" />
    <meta name="copyright" content="Copyright &copy; 2022 by Kacper Kostera" />
    <meta name="keywords" content="dziennik, elektroniczny, szkoła" />
    <meta name="subject" content="Dziennik elektroniczny" />
    <meta name="revisit-after" content="1 days" />

    <link rel="icon" href="./img/browser/icon180.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="img/browser/icon180.ico" type="image/x-icon" />

    <meta property="og:url" content="https://iiproject.ddns.net" />
    <meta property="og:title" content="E-Dziennik" />
    <meta name="og:site_name" content="Dziennik elektroniczny" />
    <meta name="og:type" content="website" />
    <meta name="og:description" content="Zaloguj się do panelu" />
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
    setColor(<?php echo $_SESSION['color']; ?>);
    setTheme(<?php echo $_SESSION['theme']; ?>);
    accessibilityFont(<?php echo $_SESSION['font']; ?>);
    accessibilityContrast(<?php echo $_SESSION['contrast']; ?>);
</script>
<nav class="sidenav">
    <div class="profile">
        <img alt="Twoje zdjęcie profilowe" src="../profile/<?php if(is_readable('../profile/'.$_SESSION['id'] . '.jpeg')) {echo $_SESSION['id'];} else {echo "default";} ?>.jpeg" class="avatar"></img>
        <p><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></p>
        <div class="logout_holder" onclick="window.location.href='panel.php?action=logout'">
            <img class="logout" alt="Wyloguj się" src="../img/icons/<?php echo ($_SESSION['color'] == '2') ? '0' : $_SESSION['color'];?>/shutdown_switch_icon.png">
        </div>
    </div>
    <a class="active" href="panel.php">Panel</a>
    <a href="">Aktualna lekcja</a>
    <a href="timetable.php">Plan lekcji</a>

    <a class="bottom" href="settings.php">Ustawienia</a>
</nav>
<section>
    <header>
        <h1 class="grades">Panel</h1>
    </header>
    <div class="panel">
        <div class="p1">
            <h3>Dane nauczyciela</h3>
            <p><b>Imię i nazwisko:</b> <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></p>
            <p><b>Email:</b> <?php echo $_SESSION['email']; ?></p>
            <p><b>Przedmiot:</b> <?php echo $_SESSION['subject']; ?></p>
            <p><b>Wychowawca:</b> <?php echo $_SESSION['class']; ?></p>
            <a href="profile.php"><p class="profile_button teacher">Profil nauczyciela</p></a>
        </div>
        <div class="p2">
            <?php // Podgląd najbliższego planu lekcji (Penie i tak trzeba będzie to zmienić)
                $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
                mysqli_set_charset($conn, DB['charset']);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                switch (getdate()['wday']){
                    case 0:
                        $day = date("Y-m-d");
                        echo "<h3>Najbliższe lekcje</h3>";
                        break;
                    case 1:
                        if (getdate()['hours'] < 16){
                            $day = date("Y-m-d");
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Jutrzejsze lekcje</h3>";
                            $day = date("Y-m-d");
                        }
                        break; 
                    case 2:
                        if (getdate()['hours'] < 16){
                            $day = date("Y-m-d");
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Jutrzejsze lekcje</h3>";
                            $day = date("Y-m-d");
                        }
                        break; 
                    case 3:
                        if (getdate()['hours'] < 16){
                            $day = date("Y-m-d");
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Jutrzejsze lekcje</h3>";
                            $day = date("Y-m-d");
                        }
                        break;
                    case 4:
                        if (getdate()['hours'] < 16){
                            $day = date("Y-m-d");
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Jutrzejsze lekcje</h3>";
                            $day = date("Y-m-d");
                        }
                        break;
                    case 5:
                        if (getdate()['hours'] < 16){
                            $day = date("Y-m-d");
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Najbliższe lekcje</h3>";
                            $day = date("Y-m-d");
                        }
                        break;
                    case 6:
                        $day = date("Y-m-d");
                        echo "<h3>Najbliższe lekcje</h3>";
                        break;
                }

                $result = mysqli_query($conn, "
                SELECT `timetable`.*, `subject`.`name`
                FROM `timetable` 
                	LEFT JOIN `subject` ON `timetable`.`subject_id` = `subject`.`id`
                WHERE `timetable`.`teacher_id` = '".$_SESSION['id']."' AND `timetable`.`day` = '".$day."'
                ORDER BY `timetable`.`lesson`;
                ");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p><b>" . $row['lesson'] . ".</b> " . $row['classes_id'] . " - " . $row['classroom'] . " (" . $row['name'] . ")</p>";
                }
                mysqli_free_result($result);
            ?>
        </div>
        <div class="p3">
            <h3>Najbliższe sprawdziany</h3>
            <?php
                $result = mysqli_query($conn, "
                SELECT `exams`.*
                FROM `exams`
                    WHERE `exams`.`teacher_id` = '".$_SESSION['id']."' AND `exams`.`date` >= '".date('Y-m-d')."'
                LIMIT 7;
                ");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p><b>" . $row['classes_id'] . ".</b> " . $row['topic'] . " - " . $row['date'];
                }
                mysqli_free_result($result);
            ?>
        </div>
        <div class="p3">
            <h3>Najbliższe prace domowe</h3>
            <?php
                $result = mysqli_query($conn, "
                SELECT `homework`.*
                FROM `homework`
                    WHERE `homework`.`teacher_id` = '".$_SESSION['id']."' AND `homework`.`date` >= '".date('Y-m-d')."' 
                LIMIT 7;
                ");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p><b>" . $row['classes_id'] . ".</b> " . $row['topic'] . " - " . $row['date'];
                }
                mysqli_free_result($result);
            ?>
        </div>
        <div class="p4">
            <h3>Klasy</h3>
            <div class="class_holder">
            <?php
                $result = mysqli_query($conn, "
                SELECT `classes`.*
                FROM `classes`;
                ");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<div class='class'>".$row['id']."</div>";
                }
                mysqli_free_result($result);
            ?>
            </div>
        </div>
    </div>
</section>
<script src="../js/keyborad.js"></script>
</body>
</html>