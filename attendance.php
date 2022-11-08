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
    <title>Attendance</title>

    <link rel="stylesheet" href="./styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="./styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">
</head>
<body>
<nav class="sidenav">
    <div class="profile">
        <img src="./img/avatar.jpg" class="avatar"></img>
        <p><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></p>
        <p><?php echo $_SESSION['class'] ?></p>
    </div>
    <a href="panel.php">Panel</a>
    <a href="grades.php">Oceny</a>
    <a class="active" href="#">Frekwencja</a>
    <a href="#">Plan lekcji</a>
    <a href="#">Sprawdziany</a>
    <a href="#">Wydarzenia</a>
    <a href="#">Tematy</a>
</nav>
<section>
    <h1 class="grades">Frekwencja</h1>
    <table class="attendance" border="5" cellspacing="0" align="center">
        <tr>
            <td class="day" align="center" height="50"
                width="100">
                <b>Dzień /<br>Lekcja</b></br>
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
                <b>1<br>9:30-10:20</b>
            </td>
            <td align="center" height="50">Eng</td>
            <td align="center" height="50">Mat</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>2<br>10:20-11:10</b>
            </td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Eng</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Mat</td>
            <td align="center" height="50">Che</td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>3<br>10:20-11:10</b>
            </td>
            <td align="center" height="50">Mat</td>
            <td align="center" height="50">phy</td>
            <td align="center" height="50">Eng</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>4<br>10:20-11:10</b>
            </td>
            <td align="center" height="50">Phy</td>
            <td align="center" height="50">Eng</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>5<br>10:20-11:10</b>
            </td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Mat</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Eng</td>
            <td align="center" height="50">Che</td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>7<br>10:20-11:10</b>
            </td>
            <td align="center" height="50">Mat</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>7<br>10:20-11:10</b>
            </td>
            <td align="center" height="50">Eng</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Mat</td>
            <td align="center" height="50">Mat</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Eng</td>
            <td align="center" height="50">Eng</td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>8<br>10:20-11:10</b>
            </td>
            <td align="center" height="50">Mat</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Eng</td>
            <td align="center" height="50">Mat</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Eng</td>
            <td align="center" height="50">Eng</td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>9<br>10:20-11:10</b>
            </td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Mat</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Eng</td>
            <td align="center" height="50">Eng</td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>10<br>10:20-11:10</b>
            </td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Mat</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Eng</td>
            <td align="center" height="50">Eng</td>
        </tr>
        <tr>
            <td align="center" height="50">
                <b>11<br>10:20-11:10</b>
            </td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Mat</td>
            <td align="center" height="50">Che</td>
            <td align="center" height="50">Eng</td>
            <td align="center" height="50">Eng</td>
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