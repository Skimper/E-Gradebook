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
            <p><b>Wychowawca:</b> <?php echo $_SESSION['class']; ?></p>
            <a href="profile.php"><p class="profile_button">Profil ucznia</p></a>
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
                        $day = "mon";
                        echo "<h3>Najbliższe lekcje</h3>";
                        break;
                    case 1:
                        if (getdate()['hours'] < 16){
                            $day = 'mon';
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Jutrzejsze lekcje</h3>";
                            $day = 'tue';
                        }
                        break; 
                    case 2:
                        if (getdate()['hours'] < 16){
                            $day = 'wue';
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Jutrzejsze lekcje</h3>";
                            $day = 'wed';
                        }
                        break; 
                    case 3:
                        if (getdate()['hours'] < 16){
                            $day = 'wed';
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Jutrzejsze lekcje</h3>";
                            $day = 'thu';
                        }
                        break;
                    case 4:
                        if (getdate()['hours'] < 16){
                            $day = 'thu';
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Jutrzejsze lekcje</h3>";
                            $day = 'fri';
                        }
                        break;
                    case 5:
                        if (getdate()['hours'] < 16){
                            $day = 'fri';
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Najbliższe lekcje</h3>";
                            $day = 'mon';
                        }
                        break;
                    case 6:
                        $day = 'mon';
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
    </div>
</section>
<script src="../js/keyborad.js"></script>
</body>
</html>