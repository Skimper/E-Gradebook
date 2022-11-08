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
    <title>Panel</title>

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
    <a class="active" href="panel.php">Panel</a>
    <a href="grades.php">Oceny</a>
    <a href="attendance.php">Frekwencja</a>
    <a href="timetable.php">Plan lekcji</a>
    <a href="#">Sprawdziany</a>
    <a href="#">Wydarzenia</a>
    <a href="#">Tematy</a>
</nav>
<section>
    <h1 class="grades">Panel</h1>
    <div class="panel">
        <div class="p1">
            <h3>Kutas</h3>
        </div>
        <div class="p2">x</div>
        <div class="p3">x</div>
        <div class="p4">x</div>
        <div class="p5">x</div>
        <div class="p6">x</div>
        <div class="p7">x</div>
        <div class="p8">x</div>
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
</body>
</html>