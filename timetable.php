<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit;
    }

    require('./api/sql.php');
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan lekcji</title>

    <link rel="stylesheet" href="./styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="./styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">
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
    <a class="active" href="timetable.php">Plan lekcji</a>
    <a href="exams.php">Sprawdziany</a>
    <a href="#">Wydarzenia</a>
    <a href="#">Tematy</a>
    <a href="#">Uwagi</a>
</nav>
<section>
    <header>
        <h1 class="grades">Plan lekcji</h1>
    </header>
    <table class="attendance" border="5" cellspacing="0" align="center">
        <?php 
            $conn = mysqli_connect(CONN['host'], CONN['user'], CONN['password'], CONN['database']);
            mysqli_set_charset($conn, CONN['charset']);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $result = mysqli_query($conn, "
            SELECT `timetable`.`classes_id`, `timetable`.`lesson`, `timetable`.`day`, `subject`.`name`
                FROM `timetable` 
                    LEFT JOIN `subject` ON `timetable`.`subject_id` = `subject`.`id`
                WHERE `timetable`.`classes_id` = '".$_SESSION['class']."';
            ");

            $timetable = array(
                "mon" => array(
                    "0" => "Poniedziałek",
                ),
                "tue" => array(
                    "0" => "Wtorek",
                ),
                "wed" => array(
                    "0" => "Środa",
                ),
                "thu" => array(
                    "0" => "Czwartek",
                ),
                "fri" => array(
                    "0" => "Piątek",
                ),
            );

            while ($row = mysqli_fetch_array($result)) {
                array_push($timetable[$row['day']], $row['name']);
            }
            mysqli_free_result($result);
            /*
            print "<pre>";
            print_r($timetable);
            print "</pre>";
            */
        ?>
        <tr>
            <td class="day" align="center" height="50"
                width="100">
                <b>Dzień /<br>Lekcja</b></br>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b><?php echo $timetable['mon'][0]; ?></b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b><?php echo $timetable['tue'][0]; ?></b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b><?php echo $timetable['wed'][0]; ?></b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b><?php echo $timetable['thu'][0]; ?></b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b><?php echo $timetable['fri'][0]; ?></b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>Sobota</b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>Niedziela</b>
            </td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>1<br>7:45-8:30</b>
            </td>
            <td align="center" height="50"><?php if(isset($timetable['mon'][1])) echo $timetable['mon'][1]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['tue'][1])) echo $timetable['tue'][1]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['wed'][1])) echo $timetable['wed'][1]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['thu'][1])) echo $timetable['thu'][1]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['fri'][1])) echo $timetable['fri'][1]; ?></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>2<br>8:35-9:20</b>
            </td>
            <td align="center" height="50"><?php if(isset($timetable['mon'][2])) echo $timetable['mon'][2]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['tue'][2])) echo $timetable['tue'][2]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['wed'][2])) echo $timetable['wed'][2]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['thu'][2])) echo $timetable['thu'][2]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['fri'][2])) echo $timetable['fri'][2]; ?></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>3<br>9:25-10:10</b>
            </td>
            <td align="center" height="50"><?php if(isset($timetable['mon'][3])) echo $timetable['mon'][3]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['tue'][3])) echo $timetable['tue'][3]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['wed'][3])) echo $timetable['wed'][3]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['thu'][3])) echo $timetable['thu'][3]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['fri'][3])) echo $timetable['fri'][3]; ?></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>4<br>10:15-11:00</b>
            </td>
            <td align="center" height="50"><?php if(isset($timetable['mon'][4])) echo $timetable['mon'][4]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['tue'][4])) echo $timetable['tue'][4]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['wed'][4])) echo $timetable['wed'][4]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['thu'][4])) echo $timetable['thu'][4]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['fri'][4])) echo $timetable['fri'][4]; ?></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>5<br>11:15-12:00</b>
            </td>
            <td align="center" height="50"><?php if(isset($timetable['mon'][5])) echo $timetable['mon'][5]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['tue'][5])) echo $timetable['tue'][5]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['wed'][5])) echo $timetable['wed'][5]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['thu'][5])) echo $timetable['thu'][5]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['fri'][5])) echo $timetable['fri'][5]; ?></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>7<br>12:15-13:00</b>
            </td>
            <td align="center" height="50"><?php if(isset($timetable['mon'][6])) echo $timetable['mon'][6]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['tue'][6])) echo $timetable['tue'][6]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['wed'][6])) echo $timetable['wed'][6]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['thu'][6])) echo $timetable['thu'][6]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['fri'][6])) echo $timetable['fri'][6]; ?></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>7<br>13:05-13:50</b>
            </td>
            <td align="center" height="50"><?php if(isset($timetable['mon'][7])) echo $timetable['mon'][7]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['tue'][7])) echo $timetable['tue'][7]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['wed'][7])) echo $timetable['wed'][7]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['thu'][7])) echo $timetable['thu'][7]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['fri'][7])) echo $timetable['fri'][7]; ?></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>8<br>14:05-14:50</b>
            </td>
            <td align="center" height="50"><?php if(isset($timetable['mon'][8])) echo $timetable['mon'][8]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['tue'][8])) echo $timetable['tue'][8]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['wed'][8])) echo $timetable['wed'][8]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['thu'][8])) echo $timetable['thu'][8]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['fri'][8])) echo $timetable['fri'][8]; ?></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>9<br>14:55-15:40</b>
            </td>
            <td align="center" height="50"><?php if(isset($timetable['mon'][9])) echo $timetable['mon'][9]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['tue'][9])) echo $timetable['tue'][9]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['wed'][9])) echo $timetable['wed'][9]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['thu'][9])) echo $timetable['thu'][9]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['fri'][9])) echo $timetable['fri'][9]; ?></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>10<br>15:45-16:30</b>
            </td>
            <td align="center" height="50"><?php if(isset($timetable['mon'][10])) echo $timetable['mon'][10]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['tue'][10])) echo $timetable['tue'][10]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['wed'][10])) echo $timetable['wed'][10]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['thu'][10])) echo $timetable['thu'][10]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['fri'][10])) echo $timetable['fri'][10]; ?></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>11<br>16:35-17:20</b>
            </td>
            <td align="center" height="50"><?php if(isset($timetable['mon'][11])) echo $timetable['mon'][11]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['tue'][11])) echo $timetable['tue'][11]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['wed'][11])) echo $timetable['wed'][11]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['thu'][11])) echo $timetable['thu'][11]; ?></td>
            <td align="center" height="50"><?php if(isset($timetable['fri'][11])) echo $timetable['fri'][11]; ?></td>
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