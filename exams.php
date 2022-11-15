<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit;
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
    <table class="attendance" border="5" cellspacing="0" align="center">
        <tr>
            <td class="day" align="center" height="50"
                width="100">
                <b>Dzień /<br>Lekcja</b></br>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>2022-01-01<br>Poniedziałek</b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>2022-01-01<br>Wtorek</b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>2022-01-01<br>Śrdoa</b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>2022-01-01<br>Czwartek</b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>2022-01-01<br>Piątek</b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>2022-01-01<br>Sobota</b>
            </td>
            <td class="day" align="center" height="50"
                width="100">
                <b>2022-01-01<br>Niedziela</b>
            </td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>1<br>7:45-8:30</b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>2<br>8:35-9:20</b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>3<br>9:25-10:10</b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>4<br>10:15-11:00</b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>5<br>11:15-12:00</b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>6<br>12:15-13:00</b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>7<br>13:05-13:50</b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>8<br>14:05-14:50</b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>9<br>14:55-15:40</b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>10<br>15:45-16:30</b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>11<br>16:35-17:20</b>
            </td>
            <td align="center" height="50"></td>
            <td align="center" height="50"></td>
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