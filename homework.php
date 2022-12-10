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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sprawdziany i zadania</title>

    <link rel="stylesheet" href="./styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="./styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">
    
    <script src="./js/gradeinfo.js"></script>

    <script src="./js/accessibility.js"></script>
    <script src="./js/theme.js"></script>

    <script>
        if(typeof window.history.pushState == 'function') {
            window.history.pushState({}, "Hide", "settings.php");
        }
    </script>
    
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
        <img alt="Twoje zdjęcie profilowe" src="./img/avatar.jpeg" class="avatar"></img>
        <p><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></p>
        <p><?php echo $_SESSION['class'] ?></p>
    </div>
    <a href="panel.php">Panel</a>
    <a href="grades.php">Oceny</a>
    <a href="attendance.php">Frekwencja</a>
    <a href="timetable.php">Plan lekcji</a>
    <a class="active" href="exams.php">Sprawdziany</a>
    <a href="meetings.php">Wydarzenia</a>
    <a href="topics.php">Tematy</a>
    <a href="comments.php">Uwagi</a>

    <a class="bottom" href="settings.php">Ustawienia</a>
</nav>
<section>
    <header>
        <h1 class="grades">Sprawdziany</h1>
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
        $day8 = date('Y-m-d', strtotime('+'.(7-$day).' days'));
        $day14 = date('Y-m-d', strtotime('+'.(13-$day).' days'));
        $day8 = date('Y-m-d', strtotime('+'.(14-$day).' days'));
        $day21 = date('Y-m-d', strtotime('+'.(20-$day).' days'));
        $day22 = date('Y-m-d', strtotime('+'.(21-$day).' days'));
        $day27 = date('Y-m-d', strtotime('+'.(27-$day).' days'));
        $result2 = mysqli_query($conn, "
        SELECT `homework`.*, `subject`.`name`
        FROM `homework`
            LEFT JOIN `subject` ON `homework`.`subject_id` = `subject`.`id`
        WHERE `homework`.`date` >= '".$day1."' AND `homework`.`date` <= '".$day27."' AND `homework`.`classes_id` = '".$_SESSION['class']."';
        ");
        $homework = array(
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
        
        while ($row = mysqli_fetch_array($result2)) {
            $wday = date('w', strtotime($row['date']));
            if ($row['date'] >= $day1 || $row['date'] <= $day7){
                //$homework[$day1][date('w', strtotime($row['date']))] = array($row['name'], $row['topic'], $row['description'], $row['date'], $row['from']);
                array_push($homework[$day1][$wday], array($row['name'], $row['topic'], $row['description'], $row['date'], $row['from']));
                //array_push($homework[$day1][0], array('cock', 'xx'));
                //array_push($homework[$day1][date('w', strtotime($row['date']))], array($row['name'], $row['topic'], $row['description'], $row['date'], $row['from']));
            } 
            else if ($row['date'] >= $day8 || $row['date'] <= $day14)
                $homework[$day8][date('w', strtotime($row['date']))] = array($row['name'], $row['topic'], $row['description'], $row['date'], $row['from']);
            else if ($row['date'] >= $day8|| $row['date'] <= $day21)
                $homework[$day8][date('w', strtotime($row['date']))] = array($row['name'], $row['topic'], $row['description'], $row['date'], $row['from']);
            else if ($row['date'] >= $day22 || $row['date'] <= $day27)
                $homework[$day22][date('w', strtotime($row['date']))] = array($row['name'], $row['topic'], $row['description'], $row['date'], $row['from']);
        }
        mysqli_free_result($result2);


    ?>
    <table class="exams" id="homework" border="5" cellspacing="0" align="center">
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
                    if(isset($homework[$day1][1][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][1][0][0]."', '".$homework[$day1][1][0][1]."', '".$homework[$day1][1][0][2]."', '".$homework[$day1][1][0][3]."', '".$homework[$day1][1][0][4]."');\">".$homework[$day1][1][0][0]."</p>"; 
                    if(isset($homework[$day1][1][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][1][1][0]."', '".$homework[$day1][1][1][1]."', '".$homework[$day1][1][1][2]."', '".$homework[$day1][1][1][3]."', '".$homework[$day1][1][1][4]."');\">".$homework[$day1][1][1][0]."</p>"; 
                    if(isset($homework[$day1][1][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][1][2][0]."', '".$homework[$day1][1][2][1]."', '".$homework[$day1][1][2][2]."', '".$homework[$day1][1][2][3]."', '".$homework[$day1][1][2][4]."');\">".$homework[$day1][1][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day1][2][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo(".$homework[$day1][2][0][0].",".$homework[$day1][2][0][1].", '".$homework[$day1][2][0][2]."', '".$homework[$day1][2][0][3]."', '".$homework[$day1][2][0][4]."');\">".$homework[$day1][2][0][0]."</p>"; 
                    if(isset($homework[$day1][2][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][2][1][0]."', '".$homework[$day1][2][1][1]."', '".$homework[$day1][2][1][2]."', '".$homework[$day1][2][1][3]."', '".$homework[$day1][2][1][4]."');\">".$homework[$day1][2][1][0]."</p>"; 
                    if(isset($homework[$day1][2][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][2][2][0]."', '".$homework[$day1][2][2][1]."', '".$homework[$day1][2][2][2]."', '".$homework[$day1][2][2][3]."', '".$homework[$day1][2][2][4]."');\">".$homework[$day1][2][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day1][3][0][0]))
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][3][0][0]."','".$homework[$day1][3][0][1]."', '".$homework[$day1][3][0][2]."', '".$homework[$day1][3][0][3]."', '".$homework[$day1][3][0][4]."');\">".$homework[$day1][3][0][0]."</p>"; 
                    if(isset($homework[$day1][3][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][3][1][0]."', '".$homework[$day1][3][1][1]."', '".$homework[$day1][3][1][2]."', '".$homework[$day1][3][1][3]."', '".$homework[$day1][3][1][4]."');\">".$homework[$day1][3][1][0]."</p>"; 
                    if(isset($homework[$day1][3][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][3][2][0]."', '".$homework[$day1][3][2][1]."', '".$homework[$day1][3][2][2]."', '".$homework[$day1][3][2][3]."', '".$homework[$day1][3][2][4]."');\">".$homework[$day1][3][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day1][4][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][4][0][0]."', '".$homework[$day1][4][0][1]."', '".$homework[$day1][4][0][2]."', '".$homework[$day1][4][0][3]."', '".$homework[$day1][4][0][4]."');\">".$homework[$day1][4][0][0]."</p>"; 
                    if(isset($homework[$day1][4][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][4][1][0]."', '".$homework[$day1][4][1][1]."', '".$homework[$day1][4][1][2]."', '".$homework[$day1][4][1][3]."', '".$homework[$day1][4][1][4]."');\">".$homework[$day1][4][1][0]."</p>"; 
                    if(isset($homework[$day1][4][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][4][2][0]."', '".$homework[$day1][4][2][1]."', '".$homework[$day1][4][2][2]."', '".$homework[$day1][4][2][3]."', '".$homework[$day1][4][2][4]."');\">".$homework[$day1][4][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day1][5][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][5][0][0]."', '".$homework[$day1][5][0][1]."', '".$homework[$day1][5][0][2]."', '".$homework[$day1][5][0][3]."', '".$homework[$day1][5][0][4]."');\">".$homework[$day1][5][0][0]."</p>"; 
                    if(isset($homework[$day1][5][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][5][1][0]."', '".$homework[$day1][5][1][1]."', '".$homework[$day1][5][1][2]."', '".$homework[$day1][5][1][3]."', '".$homework[$day1][5][1][4]."');\">".$homework[$day1][5][1][0]."</p>"; 
                    if(isset($homework[$day1][5][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day1][5][2][0]."', '".$homework[$day1][5][2][1]."', '".$homework[$day1][5][2][2]."', '".$homework[$day1][5][2][3]."', '".$homework[$day1][5][2][4]."');\">".$homework[$day1][5][2][0]."</p>"; 
                ?>
            </td>
        </tr>
        <tr>
            <td align="center" height="50">
            <b><?php echo $day8 ?><br><?php echo $day14 ?></b>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day8][1][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][1][0][0]."', '".$homework[$day8][1][0][1]."', '".$homework[$day8][1][0][2]."', '".$homework[$day8][1][0][3]."', '".$homework[$day8][1][0][4]."');\">".$homework[$day8][1][0][0]."</p>"; 
                    if(isset($homework[$day8][1][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][1][1][0]."', '".$homework[$day8][1][1][1]."', '".$homework[$day8][1][1][2]."', '".$homework[$day8][1][1][3]."', '".$homework[$day8][1][1][4]."');\">".$homework[$day8][1][1][0]."</p>"; 
                    if(isset($homework[$day8][1][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][1][2][0]."', '".$homework[$day8][1][2][1]."', '".$homework[$day8][1][2][2]."', '".$homework[$day8][1][2][3]."', '".$homework[$day8][1][2][4]."');\">".$homework[$day8][1][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day8][2][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][2][0][0]."', '".$homework[$day8][2][0][1]."', '".$homework[$day8][2][0][2]."', '".$homework[$day8][2][0][3]."', '".$homework[$day8][2][0][4]."');\">".$homework[$day8][2][0][0]."</p>"; 
                    if(isset($homework[$day8][2][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][2][1][0]."', '".$homework[$day8][2][1][1]."', '".$homework[$day8][2][1][2]."', '".$homework[$day8][2][1][3]."', '".$homework[$day8][2][1][4]."');\">".$homework[$day8][2][1][0]."</p>"; 
                    if(isset($homework[$day8][2][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][2][2][0]."', '".$homework[$day8][2][2][1]."', '".$homework[$day8][2][2][2]."', '".$homework[$day8][2][2][3]."', '".$homework[$day8][2][2][4]."');\">".$homework[$day8][2][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day8][3][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][3][0][0]."', '".$homework[$day8][3][0][1]."', '".$homework[$day8][3][0][2]."', '".$homework[$day8][3][0][3]."', '".$homework[$day8][3][0][4]."');\">".$homework[$day8][3][0][0]."</p>"; 
                    if(isset($homework[$day8][3][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][3][1][0]."', '".$homework[$day8][3][1][1]."', '".$homework[$day8][3][1][2]."', '".$homework[$day8][3][1][3]."', '".$homework[$day8][3][1][4]."');\">".$homework[$day8][3][1][0]."</p>"; 
                    if(isset($homework[$day8][3][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][3][2][0]."', '".$homework[$day8][3][2][1]."', '".$homework[$day8][3][2][2]."', '".$homework[$day8][3][2][3]."', '".$homework[$day8][3][2][4]."');\">".$homework[$day8][3][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day8][4][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][4][0][0]."', '".$homework[$day8][4][0][1]."', '".$homework[$day8][4][0][2]."', '".$homework[$day8][4][0][3]."', '".$homework[$day8][4][0][4]."');\">".$homework[$day8][4][0][0]."</p>"; 
                    if(isset($homework[$day8][4][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][4][1][0]."', '".$homework[$day8][4][1][1]."', '".$homework[$day8][4][1][2]."', '".$homework[$day8][4][1][3]."', '".$homework[$day8][4][1][4]."');\">".$homework[$day8][4][1][0]."</p>"; 
                    if(isset($homework[$day8][4][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][4][2][0]."', '".$homework[$day8][4][2][1]."', '".$homework[$day8][4][2][2]."', '".$homework[$day8][4][2][3]."', '".$homework[$day8][4][2][4]."');\">".$homework[$day8][4][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day8][5][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][5][0][0]."', '".$homework[$day8][5][0][1]."', '".$homework[$day8][5][0][2]."', '".$homework[$day8][5][0][3]."', '".$homework[$day8][5][0][4]."');\">".$homework[$day8][5][0][0]."</p>"; 
                    if(isset($homework[$day8][5][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][5][1][0]."', '".$homework[$day8][5][1][1]."', '".$homework[$day8][5][1][2]."', '".$homework[$day8][5][1][3]."', '".$homework[$day8][5][1][4]."');\">".$homework[$day8][5][1][0]."</p>"; 
                    if(isset($homework[$day8][5][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day8][5][2][0]."', '".$homework[$day8][5][2][1]."', '".$homework[$day8][5][2][2]."', '".$homework[$day8][5][2][3]."', '".$homework[$day8][5][2][4]."');\">".$homework[$day8][5][2][0]."</p>"; 
                ?>
            </td>
        </tr>
        <tr>
            <td align="center" height="50">
            <b><?php echo $day14 ?><br><?php echo $day21 ?></b>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day14][1][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][1][0][0]."', '".$homework[$day14][1][0][1]."', '".$homework[$day14][1][0][2]."', '".$homework[$day14][1][0][3]."', '".$homework[$day14][1][0][4]."');\">".$homework[$day14][1][0][0]."</p>"; 
                    if(isset($homework[$day14][1][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][1][1][0]."', '".$homework[$day14][1][1][1]."', '".$homework[$day14][1][1][2]."', '".$homework[$day14][1][1][3]."', '".$homework[$day14][1][1][4]."');\">".$homework[$day14][1][1][0]."</p>"; 
                    if(isset($homework[$day14][1][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][1][2][0]."', '".$homework[$day14][1][2][1]."', '".$homework[$day14][1][2][2]."', '".$homework[$day14][1][2][3]."', '".$homework[$day14][1][2][4]."');\">".$homework[$day14][1][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day14][2][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][2][0][0]."', '".$homework[$day14][2][0][1]."', '".$homework[$day14][2][0][2]."', '".$homework[$day14][2][0][3]."', '".$homework[$day14][2][0][4]."');\">".$homework[$day14][2][0][0]."</p>"; 
                    if(isset($homework[$day14][2][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][2][1][0]."', '".$homework[$day14][2][1][1]."', '".$homework[$day14][2][1][2]."', '".$homework[$day14][2][1][3]."', '".$homework[$day14][2][1][4]."');\">".$homework[$day14][2][1][0]."</p>"; 
                    if(isset($homework[$day14][2][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][2][2][0]."', '".$homework[$day14][2][2][1]."', '".$homework[$day14][2][2][2]."', '".$homework[$day14][2][2][3]."', '".$homework[$day14][2][2][4]."');\">".$homework[$day14][2][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day14][3][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][3][0][0]."', '".$homework[$day14][3][0][1]."', '".$homework[$day14][3][0][2]."', '".$homework[$day14][3][0][3]."', '".$homework[$day14][3][0][4]."');\">".$homework[$day14][3][0][0]."</p>"; 
                    if(isset($homework[$day14][3][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][3][1][0]."', '".$homework[$day14][3][1][1]."', '".$homework[$day14][3][1][2]."', '".$homework[$day14][3][1][3]."', '".$homework[$day14][3][1][4]."');\">".$homework[$day14][3][1][0]."</p>"; 
                    if(isset($homework[$day14][3][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][3][2][0]."', '".$homework[$day14][3][2][1]."', '".$homework[$day14][3][2][2]."', '".$homework[$day14][3][2][3]."', '".$homework[$day14][3][2][4]."');\">".$homework[$day14][3][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day14][4][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][4][0][0]."', '".$homework[$day14][4][0][1]."', '".$homework[$day14][4][0][2]."', '".$homework[$day14][4][0][3]."', '".$homework[$day14][4][0][4]."');\">".$homework[$day14][4][0][0]."</p>"; 
                    if(isset($homework[$day14][4][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][4][1][0]."', '".$homework[$day14][4][1][1]."', '".$homework[$day14][4][1][2]."', '".$homework[$day14][4][1][3]."', '".$homework[$day14][4][1][4]."');\">".$homework[$day14][4][1][0]."</p>"; 
                    if(isset($homework[$day14][4][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][4][2][0]."', '".$homework[$day14][4][2][1]."', '".$homework[$day14][4][2][2]."', '".$homework[$day14][4][2][3]."', '".$homework[$day14][4][2][4]."');\">".$homework[$day14][4][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day14][5][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][5][0][0]."', '".$homework[$day14][5][0][1]."', '".$homework[$day14][5][0][2]."', '".$homework[$day14][5][0][3]."', '".$homework[$day14][5][0][4]."');\">".$homework[$day14][5][0][0]."</p>"; 
                    if(isset($homework[$day14][5][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][5][1][0]."', '".$homework[$day14][5][1][1]."', '".$homework[$day14][5][1][2]."', '".$homework[$day14][5][1][3]."', '".$homework[$day14][5][1][4]."');\">".$homework[$day14][5][1][0]."</p>"; 
                    if(isset($homework[$day14][5][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day14][5][2][0]."', '".$homework[$day14][5][2][1]."', '".$homework[$day14][5][2][2]."', '".$homework[$day14][5][2][3]."', '".$homework[$day14][5][2][4]."');\">".$homework[$day14][5][2][0]."</p>"; 
                ?>
            </td>
        </tr>
        <tr>
            <td align="center" height="50">
            <b><?php echo $day22 ?><br><?php echo $day27 ?></b>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day22][1][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][1][0][0]."', '".$homework[$day22][1][0][1]."', '".$homework[$day22][1][0][2]."', '".$homework[$day22][1][0][3]."', '".$homework[$day22][1][0][4]."');\">".$homework[$day22][1][0][0]."</p>"; 
                    if(isset($homework[$day22][1][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][1][1][0]."', '".$homework[$day22][1][1][1]."', '".$homework[$day22][1][1][2]."', '".$homework[$day22][1][1][3]."', '".$homework[$day22][1][1][4]."');\">".$homework[$day22][1][1][0]."</p>"; 
                    if(isset($homework[$day22][1][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][1][2][0]."', '".$homework[$day22][1][2][1]."', '".$homework[$day22][1][2][2]."', '".$homework[$day22][1][2][3]."', '".$homework[$day22][1][2][4]."');\">".$homework[$day22][1][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day22][2][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][2][0][0]."', '".$homework[$day22][2][0][1]."', '".$homework[$day22][2][0][2]."', '".$homework[$day22][2][0][3]."', '".$homework[$day22][2][0][4]."');\">".$homework[$day22][2][0][0]."</p>"; 
                    if(isset($homework[$day22][2][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][2][1][0]."', '".$homework[$day22][2][1][1]."', '".$homework[$day22][2][1][2]."', '".$homework[$day22][2][1][3]."', '".$homework[$day22][2][1][4]."');\">".$homework[$day22][2][1][0]."</p>"; 
                    if(isset($homework[$day22][2][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][2][2][0]."', '".$homework[$day22][2][2][1]."', '".$homework[$day22][2][2][2]."', '".$homework[$day22][2][2][3]."', '".$homework[$day22][2][2][4]."');\">".$homework[$day22][2][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day22][3][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][3][0][0]."', '".$homework[$day22][3][0][1]."', '".$homework[$day22][3][0][2]."', '".$homework[$day22][3][0][3]."', '".$homework[$day22][3][0][4]."');\">".$homework[$day22][3][0][0]."</p>"; 
                    if(isset($homework[$day22][3][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][3][1][0]."', '".$homework[$day22][3][1][1]."', '".$homework[$day22][3][1][2]."', '".$homework[$day22][3][1][3]."', '".$homework[$day22][3][1][4]."');\">".$homework[$day22][3][1][0]."</p>"; 
                    if(isset($homework[$day22][3][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][3][2][0]."', '".$homework[$day22][3][2][1]."', '".$homework[$day22][3][2][2]."', '".$homework[$day22][3][2][3]."', '".$homework[$day22][3][2][4]."');\">".$homework[$day22][3][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day22][4][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][4][0][0]."', '".$homework[$day22][4][0][1]."', '".$homework[$day22][4][0][2]."', '".$homework[$day22][4][0][3]."', '".$homework[$day22][4][0][4]."');\">".$homework[$day22][4][0][0]."</p>"; 
                    if(isset($homework[$day22][4][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][4][1][0]."', '".$homework[$day22][4][1][1]."', '".$homework[$day22][4][1][2]."', '".$homework[$day22][4][1][3]."', '".$homework[$day22][4][1][4]."');\">".$homework[$day22][4][1][0]."</p>"; 
                    if(isset($homework[$day22][4][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][4][2][0]."', '".$homework[$day22][4][2][1]."', '".$homework[$day22][4][2][2]."', '".$homework[$day22][4][2][3]."', '".$homework[$day22][4][2][4]."');\">".$homework[$day22][4][2][0]."</p>"; 
                ?>
            </td>
            <td align="center" height="50">
                <?php
                    if(isset($homework[$day22][5][0][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][5][0][0]."', '".$homework[$day22][5][0][1]."', '".$homework[$day22][5][0][2]."', '".$homework[$day22][5][0][3]."', '".$homework[$day22][5][0][4]."');\">".$homework[$day22][5][0][0]."</p>"; 
                    if(isset($homework[$day22][5][1][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][5][1][0]."', '".$homework[$day22][5][1][1]."', '".$homework[$day22][5][1][2]."', '".$homework[$day22][5][1][3]."', '".$homework[$day22][5][1][4]."');\">".$homework[$day22][5][1][0]."</p>"; 
                    if(isset($homework[$day22][5][2][0])) 
                        echo "<p class=\"exam\" onclick=\"showGradeInfo('".$homework[$day22][5][2][0]."', '".$homework[$day22][5][2][1]."', '".$homework[$day22][5][2][2]."', '".$homework[$day22][5][2][3]."', '".$homework[$day22][5][2][4]."');\">".$homework[$day22][5][2][0]."</p>"; 
                ?>
            </td>
        </tr>
    </table>
</section>
<section>
    <div class="examinfo" id="examinfo" style="display: none;">
        <div class="subject">
            <h4 id="subject">Język polski</h4>
        </div>
        <div class="otherinfo">
            <p id="title">Tytuł sprawdzianu</p>
            <p id="description">Opis</p>
            <p id="date">Termin</p>
            <p id="from">Zapowiedziano</p>
        </div>
    </div>
</section>
<script src="./js/keyborad.js"></script>
</body>
</html>