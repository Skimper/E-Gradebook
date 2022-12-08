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
    <title>Panel</title>

    <link rel="stylesheet" href="./styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="./styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</head>
<body>
<nav class="sidenav">
    <div class="profile">
        <img alt="Twoje zdjęcie profilowe" src="./img/avatar.jpeg" class="avatar"></img>
        <p><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></p>
        <p><?php echo $_SESSION['class']; ?></p>
    </div>
    <a href="panel.php">Panel</a>
    <a href="grades.php">Oceny</a>
    <a href="attendance.php">Frekwencja</a>
    <a href="timetable.php">Plan lekcji</a>
    <a href="exams.php">Sprawdziany</a>
    <a href="meetings.php">Wydarzenia</a>
    <a href="topics.php">Tematy</a>
    <a href="comments.php">Uwagi</a>

    <a class="bottom" href="settings.php">Ustawienia</a>
</nav>
<section>
    <header>
        <h1 class="grades">Profil ucznia</h1>
    </header>
    <div class="profile_panel">
        <?php
            $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
            mysqli_set_charset($conn, DB['charset']);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $result = mysqli_query($conn, "
            SELECT `students`.*, `students`.`id`
            FROM `students`
            WHERE `students`.`id` = '".$_SESSION['id']."';
            ");
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            }
            mysqli_free_result($result);

            $result2 = mysqli_query($conn, "
            SELECT `schools`.*, `users_students`.`students_id`
            FROM `schools` 
            	LEFT JOIN `users_students` ON `users_students`.`schools_id` = `schools`.`id`
            WHERE `users_students`.`students_id` = '".$_SESSION['id']."';
            ");
            if (mysqli_num_rows($result2) > 0) {
                $row2 = mysqli_fetch_assoc($result2);
            }
            mysqli_free_result($result2);

        ?>
        <div class="p1">
            <div>
                <h3>Profil ucznia</h3>
                <img class="avatar" alt="Twoje zdjęcie profilowe" src="./img/avatar.jpeg" />
                <p><b>Imię i nazwisko:</b> <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></p>
                <p><b>Klasa: </b> <?php echo $_SESSION['class']; ?></p>
                <p><b>Email:</b> <?php echo $_SESSION['email']; ?></p>
            </div>
        </div>
        <div class="p2">
            <div>
                <h3>Dane ucznia</h3>

                <p><b>Imię i nazwisko:</b> <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></p>
                <p><b>Płeć: </b> <?php echo $row['gender'] == 'male' ? "Mężczyzna" : "Kobieta"; ?></p>
                <p><b>Email:</b> <?php echo $_SESSION['email']; ?></p>
                <p><b>Adres:</b> <?php echo $row['address_street'] . " " . $row['address_number']; ?></p>
                <p><b>Miasto:</b> <?php echo $row['address_city'];?></p>
                <p><b>Miasto urodzenia:</b> <?php echo $row['birth_city'];?></p>
                <p><b>Data urodzenia:</b> <?php echo $row['birth_date'];?></p>
                <p><b>Pesel:</b> <?php echo $row['pesel'];?></p>
                <p><b>Numer telefonu:</b> <?php echo $row['mobile'];?></p>
                <p><b>Numer telefonu matki:</b> <?php echo $row['mobile_m'];?></p>
                <p><b>Numer telefonu ojca:</b> <?php echo $row['mobile_d'];?></p>
                <p><b>Obywatelstwo:</b> <?php echo $row['citizenship'];?></p>
            </div>
        </div>
        <div class="p3">
            <div>
                <h3>Dane szkoły</h3>

                <p><b>Nazwa:</b> <?php echo $row2['name'] ?></p>
                <p><b>Adres:</b> <?php echo $row2['adress'] ?></p>
                <p><b>Dyrekcja:</b> </p>
                <p><b>Numer telefonu:</b> <?php echo $row2['mobile'] ?></p>
                <p><b>NIP:</b> <?php echo $row2['nip'] ?></p>
                <p><b>REGON:</b> <?php echo $row2['regon'] ?></p>
                <p><b>Strona internetowa:</b> <?php echo $row2['page'] ?></p>
            </div>
        </div>
        <div class="p4">
            <div>
                <h3>Ważne informacje</h3>

                <p><b>Nazwa:</b> </p>
                <p><b>Adres:</b> </p>
                <p><b>Dyrekcja:</b> </p>
                <p><b>Numer telefonu:</b> </p>
                <p><b>NIP:</b> </p>
                <p><b>REGON:</b> </p>
                <p><b>Strona internetowa:</b> </p>
            </div>
        </div>
        <div class="p5">
            <div>
                <h3>Ważne informacje</h3>
            </div>
        </div>
        <div class="p6">
            <div>
                <h3>Ważne informacje</h3>
            </div>
        </div>
</section>
<?php
    if (isset($_GET['action']) && $_GET['action'] == "logout")
        Logout();
    if (isset($_GET['action']) && $_GET['action'] == "avatar")  
        ChangeAvatar();

    function ChangeAvatar() {
        
    }

    function Logout() {
        $_SESSION = array();

        session_destroy();
        header("Location: http://localhost/infprojectpage/index.php");
    }
?>
<script src="./js/keyborad.js"></script>
</body>
</html>