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
    <title>Sprawdziany i zadania</title>

    <link rel="stylesheet" href="./styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="./styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">

    <script src="./js/keyborad.js"></script>
</head>
<body>
<nav class="sidenav">
    <div class="profile">
        <img src="./img/avatar.jpeg" class="avatar"></img>
        <p><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></p>
        <p><?php echo $_SESSION['class'] ?></p>
    </div>
    <a href="panel.php">Panel</a>
    <a href="grades.php">Oceny</a>
    <a href="attendance.php">Frekwencja</a>
    <a href="timetable.php">Plan lekcji</a>
    <a class="active" href="exams.php">Sprawdziany</a>
    <a href="#">Wydarzenia</a>
    <a href="#">Tematy</a>
    <a href="#">Uwagi</a>
</nav>
<section>
    <header>
        <h1 class="grades">Sprawdziany i zadania</h1>
    </header>
    <table class="exams" border="5" cellspacing="0" align="center">
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

            $day15 = date('Y-m-d', strtotime('+'.(14-$day).' days'));
            $day21 = date('Y-m-d', strtotime('+'.(20-$day).' days'));

            $day22 = date('Y-m-d', strtotime('+'.(21-$day).' days'));
            $day27 = date('Y-m-d', strtotime('+'.(27-$day).' days'));

            $result = mysqli_query($conn, "
            SELECT `exams`.*, `subject`.`name`
            FROM `exams`
                LEFT JOIN `subject` ON `exams`.`subject_id` = `subject`.`id`
            WHERE `exams`.`date` >= '".$day1."' AND `exams`.`date` <= '".$day27."' AND `exams`.`classes_id` = '".$_SESSION['class']."';
            ");

            $timetable = array(
                $day1 => array(
                ),
                $day8 => array(
                ),
                $day15 => array(
                ),
                $day22 => array(
                ),
            );

            while ($row = mysqli_fetch_array($result)) {
                if ($row['date'] >= $day1 || $row['date'] <= $day7)
                    $timetable[$day1][date('w', strtotime($row['date']))] = array($row['name'], $row['topic'], $row['description'], $row['date'], $row['from']);
                else if ($row['date'] >= $day8 || $row['date'] <= $day14)
                    $timetable[$day8][date('w', strtotime($row['date']))] = array($row['name'], $row['topic'], $row['description'], $row['date'], $row['from']);
                else if ($row['date'] >= $day15|| $row['date'] <= $day21)
                    $timetable[$day15][date('w', strtotime($row['date']))] = array($row['name'], $row['topic'], $row['description'], $row['date'], $row['from']);
                else if ($row['date'] >= $day22 || $row['date'] <= $day27)
                    $timetable[$day22][date('w', strtotime($row['date']))] = array($row['name'], $row['topic'], $row['description'], $row['date'], $row['from']);
            }
            mysqli_free_result($result); // TODO: Teraz te dane musze się wyświetlać w tabeli, ez.

            echo "<pre>";
            print_r($timetable);
            echo "</pre>";
        ?>
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
        <tr>
            <td align="center" height="50">
                <b><?php echo $day1 ?><br><?php echo $day7 ?></b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
            <b><?php echo $day8 ?><br><?php echo $day14 ?></b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
            <b><?php echo $day15 ?><br><?php echo $day21 ?></b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
            <b><?php echo $day22 ?><br><?php echo $day27 ?></b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
    </table>
</section>
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