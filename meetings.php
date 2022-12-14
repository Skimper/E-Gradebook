<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit;
    } else {
        switch ($_SESSION['loggedin']) {
            case "student":
                break;
            case "teacher":
                header('Location: teacher/panel.php');
                break;
            default:
                break;
        }
    }

    if(!isset($_SESSION['attendance_i'])) $_SESSION['attendance_i'] = 0;
    if (isset($_SESSION['timetable_i'])) $_SESSION['timetable_i'] = 0;
    
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
    <title>Wydarzenia</title>

    
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

    <link rel="stylesheet" href="./styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="./styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">
    
    <script src="./js/gradeinfo.js"></script>

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
    setColor(<?php echo $_SESSION['color']; ?>);
    setTheme(<?php echo $_SESSION['theme']; ?>);
    accessibilityFont(<?php echo $_SESSION['font']; ?>);
    accessibilityContrast(<?php echo $_SESSION['contrast']; ?>);
</script>
<nav class="sidenav">
    <div class="profile">
        <img alt="Twoje zdjęcie profilowe" src="./profile/<?php if(is_readable('./profile/'.$_SESSION['id'] . '.jpeg')) {echo $_SESSION['id'];} else {echo "default";} ?>.jpeg" class="avatar"></img>
        <p><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></p>
        <p><?php echo $_SESSION['class']; ?></p>
        <div class="logout_holder" onclick="window.location.href='panel.php?action=logout'">
            <img class="logout" alt="Wyloguj się" src="./img/icons/<?php echo ($_SESSION['color'] == '2') ? '0' : $_SESSION['color'];?>/shutdown_switch_icon.png">
        </div>
    </div>
    <a href="panel.php">Panel</a>
    <a href="grades.php">Oceny</a>
    <a href="attendance.php">Frekwencja</a>
    <a href="timetable.php">Plan lekcji</a>
    <a href="exams.php">Sprawdziany</a>
    <a class="active" href="meetings.php">Wydarzenia</a>
    <a href="topics.php">Tematy</a>
    <a href="comments.php">Uwagi</a>

    <a class="bottom" href="settings.php">Ustawienia</a>
</nav>
<section>
    <header>
        <h1 class="grades" id="grades_title">Wydarzenia</h1>
    </header>
    <?php
        $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
        mysqli_set_charset($conn, DB['charset']);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $day = date('w')-1;
        $day1 = date('Y-m-d', strtotime('-'.$day.' days'));
        $day2 = date('Y-m-d', strtotime('+'.(1-$day).' days'));
        $day3 = date('Y-m-d', strtotime('+'.(2-$day).' days'));
        $day4 = date('Y-m-d', strtotime('+'.(3-$day).' days'));
        $day5 = date('Y-m-d', strtotime('+'.(4-$day).' days'));
        $day6 = date('Y-m-d', strtotime('+'.(5-$day).' days'));
        $day7 = date('Y-m-d', strtotime('+'.(6-$day).' days'));
        $day8 = date('Y-m-d', strtotime('+'.(7-$day).' days'));
        $day14 = date('Y-m-d', strtotime('+'.(13-$day).' days'));
        $day15 = date('Y-m-d', strtotime('+'.(14-$day).' days'));
        $day21 = date('Y-m-d', strtotime('+'.(20-$day).' days'));
        $day22 = date('Y-m-d', strtotime('+'.(21-$day).' days'));
        $day27 = date('Y-m-d', strtotime('+'.(27-$day).' days'));

        $result = mysqli_query($conn, "
        SELECT `meetings`.*, `meetings`.`classes_id`
        FROM `meetings`
        WHERE `meetings`.`date` >= '".$day1."' AND `meetings`.`date` <= '".$day27."' AND `meetings`.`classes_id` = '".$_SESSION['class']."';
        ");

        $timetable = array(
            $day1 => array(
                0 => array(),
                1 => array(),
                2 => array(),
                3 => array(),
                4 => array(),
                5 => array(),
            ),
            $day8 => array(
                0 => array(),
                1 => array(),
                2 => array(),
                3 => array(),
                4 => array(),
                5 => array(),
            ),
            $day14 => array(
                0 => array(),
                1 => array(),
                2 => array(),
                3 => array(),
                4 => array(),
                5 => array(),
            ),
            $day22 => array(
                0 => array(),
                1 => array(),
                2 => array(),
                3 => array(),
                4 => array(),
                5 => array(),
            ),
        );

        while ($row = mysqli_fetch_array($result)) {
            $wday = date('w', strtotime($row['date']));
            if ($row['date'] >= $day1 || $row['date'] <= $day7){
                //$timetable[$day1][date('w', strtotime($row['date']))] = array($row['name'], $row['topic'], $row['description'], $row['date'], $row['from']);
                array_push($timetable[$day1][$wday], array($row['topic'], $row['description'], $row['date']));
                //array_push($timetable[$day1][0], array('cock', 'xx'));
                //array_push($timetable[$day1][date('w', strtotime($row['date']))], array($row['name'], $row['topic'], $row['description'], $row['date'], $row['from']));
            } 
            else if ($row['date'] >= $day8 || $row['date'] <= $day14)
                $timetable[$day8][date('w', strtotime($row['date']))] = array($row['topic'], $row['description'], $row['date']);
            else if ($row['date'] >= $day8|| $row['date'] <= $day21)
                $timetable[$day8][date('w', strtotime($row['date']))] = array($row['topic'], $row['description'], $row['date']);
            else if ($row['date'] >= $day22 || $row['date'] <= $day27)
                $timetable[$day22][date('w', strtotime($row['date']))] = array($row['topic'], $row['description'], $row['date']);
        }
        mysqli_free_result($result);
    ?>
    <table class="events" id="exams" border="5" cellspacing="0" align="center" style="display: table;">
        <tr>
            <td class="day" align="center" height="50"
                width="100">
                <b>Tydzień /<br>Dzień</b></br>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>Poniedziałek</b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>Wtorek</b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>Śrdoa</b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>Czwartek</b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>Piątek</b>
            </td>
        </tr>
        <tr> <!-- To by trzeba zrobić w pętli bo to rozwiązanie ma swoje problemy. Ale teraz mi sie nie chce -->
            <td align="center" height="50">
                <b><?php echo $day1 ?><br><?php echo $day7 ?></b>
            </td>
            <td align="center" height="50">
                <?php // Ja kurwa nie wiem czemu tak musi być, ale jebać tak zostaje
                    if(isset($timetable[$day1][1][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][1][0][0]."', '".$timetable[$day1][1][0][1]."', '".$timetable[$day1][1][0][2]."');\">".$timetable[$day1][1][0][0]."</p>"; 
                    if(isset($timetable[$day1][1][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][1][1][0]."', '".$timetable[$day1][1][1][1]."', '".$timetable[$day1][1][1][2]."');\">".$timetable[$day1][1][1][0]."</p>"; 
                    if(isset($timetable[$day1][1][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][1][2][0]."', '".$timetable[$day1][1][2][1]."', '".$timetable[$day1][1][2][2]."');\">".$timetable[$day1][1][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day1][2][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][2][0][0]."', '".$timetable[$day1][2][0][1]."', '".$timetable[$day1][2][0][2]."');\">".$timetable[$day1][2][0][0]."</p>"; 
                    if(isset($timetable[$day1][2][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][2][1][0]."', '".$timetable[$day1][2][1][1]."', '".$timetable[$day1][2][1][2]."');\">".$timetable[$day1][2][1][0]."</p>"; 
                    if(isset($timetable[$day1][2][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][2][2][0]."', '".$timetable[$day1][2][2][1]."', '".$timetable[$day1][2][2][2]."');\">".$timetable[$day1][2][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day1][3][0][0]))
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][3][0][0]."','".$timetable[$day1][3][0][1]."', '".$timetable[$day1][3][0][2]."');\">".$timetable[$day1][3][0][0]."</p>"; 
                    if(isset($timetable[$day1][3][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][3][1][0]."', '".$timetable[$day1][3][1][1]."', '".$timetable[$day1][3][1][2]."');\">".$timetable[$day1][3][1][0]."</p>"; 
                    if(isset($timetable[$day1][3][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][3][2][0]."', '".$timetable[$day1][3][2][1]."', '".$timetable[$day1][3][2][2]."');\">".$timetable[$day1][3][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day1][4][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][4][0][0]."', '".$timetable[$day1][4][0][1]."', '".$timetable[$day1][4][0][2]."');\">".$timetable[$day1][4][0][0]."</p>"; 
                    if(isset($timetable[$day1][4][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][4][1][0]."', '".$timetable[$day1][4][1][1]."', '".$timetable[$day1][4][1][2]."');\">".$timetable[$day1][4][1][0]."</p>"; 
                    if(isset($timetable[$day1][4][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][4][2][0]."', '".$timetable[$day1][4][2][1]."', '".$timetable[$day1][4][2][2]."');\">".$timetable[$day1][4][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day1][5][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][5][0][0]."', '".$timetable[$day1][5][0][1]."', '".$timetable[$day1][5][0][2]."');\">".$timetable[$day1][5][0][0]."</p>"; 
                    if(isset($timetable[$day1][5][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][5][1][0]."', '".$timetable[$day1][5][1][1]."', '".$timetable[$day1][5][1][2]."');\">".$timetable[$day1][5][1][0]."</p>"; 
                    if(isset($timetable[$day1][5][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day1][5][2][0]."', '".$timetable[$day1][5][2][1]."', '".$timetable[$day1][5][2][2]."');\">".$timetable[$day1][5][2][0]."</p>"; 
                ?>
            </td>
        </tr>
        <tr>
            <td align="center" height="50">
            <b><?php echo $day8 ?><br><?php echo $day14 ?></b>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day8][1][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][1][0][0]."', '".$timetable[$day8][1][0][1]."', '".$timetable[$day8][1][0][2]."');\">".$timetable[$day8][1][0][0]."</p>"; 
                    if(isset($timetable[$day8][1][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][1][1][0]."', '".$timetable[$day8][1][1][1]."', '".$timetable[$day8][1][1][2]."');\">".$timetable[$day8][1][1][0]."</p>"; 
                    if(isset($timetable[$day8][1][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][1][2][0]."', '".$timetable[$day8][1][2][1]."', '".$timetable[$day8][1][2][2]."');\">".$timetable[$day8][1][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day8][2][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][2][0][0]."', '".$timetable[$day8][2][0][1]."', '".$timetable[$day8][2][0][2]."');\">".$timetable[$day8][2][0][0]."</p>"; 
                    if(isset($timetable[$day8][2][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][2][1][0]."', '".$timetable[$day8][2][1][1]."', '".$timetable[$day8][2][1][2]."');\">".$timetable[$day8][2][1][0]."</p>"; 
                    if(isset($timetable[$day8][2][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][2][2][0]."', '".$timetable[$day8][2][2][1]."', '".$timetable[$day8][2][2][2]."');\">".$timetable[$day8][2][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day8][3][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][3][0][0]."', '".$timetable[$day8][3][0][1]."', '".$timetable[$day8][3][0][2]."');\">".$timetable[$day8][3][0][0]."</p>"; 
                    if(isset($timetable[$day8][3][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][3][1][0]."', '".$timetable[$day8][3][1][1]."', '".$timetable[$day8][3][1][2]."');\">".$timetable[$day8][3][1][0]."</p>"; 
                    if(isset($timetable[$day8][3][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][3][2][0]."', '".$timetable[$day8][3][2][1]."', '".$timetable[$day8][3][2][2]."');\">".$timetable[$day8][3][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day8][4][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][4][0][0]."', '".$timetable[$day8][4][0][1]."', '".$timetable[$day8][4][0][2]."');\">".$timetable[$day8][4][0][0]."</p>"; 
                    if(isset($timetable[$day8][4][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][4][1][0]."', '".$timetable[$day8][4][1][1]."', '".$timetable[$day8][4][1][2]."');\">".$timetable[$day8][4][1][0]."</p>"; 
                    if(isset($timetable[$day8][4][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][4][2][0]."', '".$timetable[$day8][4][2][1]."', '".$timetable[$day8][4][2][2]."');\">".$timetable[$day8][4][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day8][5][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][5][0][0]."', '".$timetable[$day8][5][0][1]."', '".$timetable[$day8][5][0][2]."');\">".$timetable[$day8][5][0][0]."</p>"; 
                    if(isset($timetable[$day8][5][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][5][1][0]."', '".$timetable[$day8][5][1][1]."', '".$timetable[$day8][5][1][2]."');\">".$timetable[$day8][5][1][0]."</p>"; 
                    if(isset($timetable[$day8][5][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day8][5][2][0]."', '".$timetable[$day8][5][2][1]."', '".$timetable[$day8][5][2][2]."');\">".$timetable[$day8][5][2][0]."</p>"; 
                ?>
            </td>
        </tr>
        <tr>
            <td align="center" height="50">
            <b><?php echo $day15 ?><br><?php echo $day21 ?></b>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day14][1][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][1][0][0]."', '".$timetable[$day14][1][0][1]."', '".$timetable[$day14][1][0][2]."');\">".$timetable[$day14][1][0][0]."</p>"; 
                    if(isset($timetable[$day14][1][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][1][1][0]."', '".$timetable[$day14][1][1][1]."', '".$timetable[$day14][1][1][2]."');\">".$timetable[$day14][1][1][0]."</p>"; 
                    if(isset($timetable[$day14][1][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][1][2][0]."', '".$timetable[$day14][1][2][1]."', '".$timetable[$day14][1][2][2]."');\">".$timetable[$day14][1][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day14][2][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][2][0][0]."', '".$timetable[$day14][2][0][1]."', '".$timetable[$day14][2][0][2]."');\">".$timetable[$day14][2][0][0]."</p>"; 
                    if(isset($timetable[$day14][2][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][2][1][0]."', '".$timetable[$day14][2][1][1]."', '".$timetable[$day14][2][1][2]."');\">".$timetable[$day14][2][1][0]."</p>"; 
                    if(isset($timetable[$day14][2][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][2][2][0]."', '".$timetable[$day14][2][2][1]."', '".$timetable[$day14][2][2][2]."');\">".$timetable[$day14][2][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day14][3][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][3][0][0]."', '".$timetable[$day14][3][0][1]."', '".$timetable[$day14][3][0][2]."');\">".$timetable[$day14][3][0][0]."</p>"; 
                    if(isset($timetable[$day14][3][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][3][1][0]."', '".$timetable[$day14][3][1][1]."', '".$timetable[$day14][3][1][2]."');\">".$timetable[$day14][3][1][0]."</p>"; 
                    if(isset($timetable[$day14][3][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][3][2][0]."', '".$timetable[$day14][3][2][1]."', '".$timetable[$day14][3][2][2]."');\">".$timetable[$day14][3][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day14][4][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][4][0][0]."', '".$timetable[$day14][4][0][1]."', '".$timetable[$day14][4][0][2]."');\">".$timetable[$day14][4][0][0]."</p>"; 
                    if(isset($timetable[$day14][4][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][4][1][0]."', '".$timetable[$day14][4][1][1]."', '".$timetable[$day14][4][1][2]."');\">".$timetable[$day14][4][1][0]."</p>"; 
                    if(isset($timetable[$day14][4][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][4][2][0]."', '".$timetable[$day14][4][2][1]."', '".$timetable[$day14][4][2][2]."');\">".$timetable[$day14][4][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day14][5][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][5][0][0]."', '".$timetable[$day14][5][0][1]."', '".$timetable[$day14][5][0][2]."');\">".$timetable[$day14][5][0][0]."</p>"; 
                    if(isset($timetable[$day14][5][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][5][1][0]."', '".$timetable[$day14][5][1][1]."', '".$timetable[$day14][5][1][2]."');\">".$timetable[$day14][5][1][0]."</p>"; 
                    if(isset($timetable[$day14][5][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day14][5][2][0]."', '".$timetable[$day14][5][2][1]."', '".$timetable[$day14][5][2][2]."');\">".$timetable[$day14][5][2][0]."</p>"; 
                ?>
            </td>
        </tr>
        <tr>
            <td align="center" height="50">
            <b><?php echo $day22 ?><br><?php echo $day27 ?></b>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day22][1][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][1][0][0]."', '".$timetable[$day22][1][0][1]."', '".$timetable[$day22][1][0][2]."');\">".$timetable[$day22][1][0][0]."</p>"; 
                    if(isset($timetable[$day22][1][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][1][1][0]."', '".$timetable[$day22][1][1][1]."', '".$timetable[$day22][1][1][2]."');\">".$timetable[$day22][1][1][0]."</p>"; 
                    if(isset($timetable[$day22][1][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][1][2][0]."', '".$timetable[$day22][1][2][1]."', '".$timetable[$day22][1][2][2]."');\">".$timetable[$day22][1][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day22][2][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][2][0][0]."', '".$timetable[$day22][2][0][1]."', '".$timetable[$day22][2][0][2]."');\">".$timetable[$day22][2][0][0]."</p>"; 
                    if(isset($timetable[$day22][2][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][2][1][0]."', '".$timetable[$day22][2][1][1]."', '".$timetable[$day22][2][1][2]."');\">".$timetable[$day22][2][1][0]."</p>"; 
                    if(isset($timetable[$day22][2][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][2][2][0]."', '".$timetable[$day22][2][2][1]."', '".$timetable[$day22][2][2][2]."');\">".$timetable[$day22][2][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day22][3][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][3][0][0]."', '".$timetable[$day22][3][0][1]."', '".$timetable[$day22][3][0][2]."');\">".$timetable[$day22][3][0][0]."</p>"; 
                    if(isset($timetable[$day22][3][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][3][1][0]."', '".$timetable[$day22][3][1][1]."', '".$timetable[$day22][3][1][2]."');\">".$timetable[$day22][3][1][0]."</p>"; 
                    if(isset($timetable[$day22][3][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][3][2][0]."', '".$timetable[$day22][3][2][1]."', '".$timetable[$day22][3][2][2]."');\">".$timetable[$day22][3][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day22][4][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][4][0][0]."', '".$timetable[$day22][4][0][1]."', '".$timetable[$day22][4][0][2]."');\">".$timetable[$day22][4][0][0]."</p>"; 
                    if(isset($timetable[$day22][4][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][4][1][0]."', '".$timetable[$day22][4][1][1]."', '".$timetable[$day22][4][1][2]."');\">".$timetable[$day22][4][1][0]."</p>"; 
                    if(isset($timetable[$day22][4][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][4][2][0]."', '".$timetable[$day22][4][2][1]."', '".$timetable[$day22][4][2][2]."');\">".$timetable[$day22][4][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($timetable[$day22][5][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][5][0][0]."', '".$timetable[$day22][5][0][1]."', '".$timetable[$day22][5][0][2]."');\">".$timetable[$day22][5][0][0]."</p>"; 
                    if(isset($timetable[$day22][5][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][5][1][0]."', '".$timetable[$day22][5][1][1]."', '".$timetable[$day22][5][1][2]."');\">".$timetable[$day22][5][1][0]."</p>"; 
                    if(isset($timetable[$day22][5][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showMeetInfo('".$timetable[$day22][5][2][0]."', '".$timetable[$day22][5][2][1]."', '".$timetable[$day22][5][2][2]."');\">".$timetable[$day22][5][2][0]."</p>"; 
                ?>
            </td>
        </tr>
    </table>
</section>
<section>
    <div class="meetinfo" id="meetinfo" style="display: none;">
        <div class="subject">
            <h4 id="subject">Język polski</h4>
        </div>
        <div class="otherinfo">
            <p id="title">Tytuł spotkania</p>
            <p id="date">Termin</p>
        </div>
    </div>
</section>
<script src="./js/meetinfo.js"></script>
<script src="./js/keyborad.js"></script>
</body>
</html>