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
    <script src="./js/gradeinfo.js"></script>
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
    <a href="exams.php">Sprawdziany</a>
    <a href="meetings.php">Wydarzenia</a>
    <a class="active" href="topics.php">Tematy</a>
    <a href="comments.php">Uwagi</a>

    <a class="bottom" href="settings.php">Ustawienia</a>
</nav>
<section>
    <header>
        <h1 class="grades">Zrealizowane tematy</h1>
    </header>
    <table class="topics" border="5" cellspacing="0" align="center">
        <?php
            $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
            mysqli_set_charset($conn, DB['charset']);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $result = mysqli_query($conn, "
            SELECT `topics`.*, `topics`.`classes_id`, `subject`.`name`
            FROM `topics` 
            	LEFT JOIN `subject` ON `topics`.`subject_id` = `subject`.`id`
            WHERE `topics`.`classes_id` = '4c'
            LIMIT 20;
            ");
        ?>
        <tr>
            <td class="day" align="center" height="50" style="width: 20px;"><b>Przedmiot</b></td>
            <td class="day" align="center" height="50" style="width: 20px;"><b>Data</b></td>
            <td class="day" align="center" height="50" style="width: 200px;"><b>Temat</b></td>
        </tr>
        <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td align='center' height='50'>".$row["name"]."</td>";
                echo "<td align='center' height='50'>".$row["date"]."</td>";
                echo "<td align='center' height='50'>".$row["description"]."</td>";
                echo "</tr>";
            }
        ?>
        <tr> 
            <td align="center" height="50">Język Polski</td>
            <td align="center" height="50">2022-11-20</td>
            <td align="center" height="50">Słowacki wielkim poetą był. Wielkim poetą był!</td>
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
<?php
    if (isset($_GET['menu']) && $_GET['menu'] == "logout")
        Logout();

    function Logout() {
        $_SESSION = array();

        session_destroy();
        header("Location: http://localhost/infprojectpage/index.php");
    }
?>
<script src="./js/keyborad.js"></script>
</body>
</html>