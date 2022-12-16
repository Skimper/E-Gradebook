<?php
    session_start();

    if(isset($_SESSION['attendance_i'])) $_SESSION['attendance_i'] = 0;
    if (isset($_SESSION['timetable_i'])) $_SESSION['timetable_i'] = 0;

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
    if (isset($_GET['action']) && $_GET['action'] == "avatar")  
        ChangeAvatar();

    if (isset($_POST['password']) && $_POST['passwordc'])  
        ChangePassword($_POST['password'], $_POST['passwordc']);
    if (isset($_FILES['avatar']))
        UpdateAvatar();


    function UpdateAvatar() {
        $target_dir = "profile/";
        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $uploadOk = true;
        
        $check = getimagesize($_FILES["avatar"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = true;
        } else {
            echo "File is not an image.";
            $uploadOk = false;
        }
        if ($_FILES["avatar"]["size"] > 1000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = false;
        }
        if($imageFileType != "jpg" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG, & GIF files are allowed.";
            $uploadOk = false;
        } 

        if ($uploadOk) {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_dir . $_SESSION['id'] . ".jpeg")) {
                return;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, your file was not uploaded.";
        }
    }

    function ChangePassword($pass, $passc) {
        $newpass = hash('sha256', $pass);
        $newpassc = hash('sha256', $passc);

        if($newpass === $newpassc) {
            $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
            mysqli_set_charset($conn, DB['charset']);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $result = mysqli_query($conn, "
            UPDATE `users_students` SET `password` = '".$newpassc."', `last_pass` = '".date("Y-m-d")."' WHERE `users_students`.`students_id` = ".$_SESSION['id'].";
            ");
        } else {
            trigger_error("Hasła nie są takie same!", E_USER_NOTICE);
        }
    }

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

    <link rel="stylesheet" href="./styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="./styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <script src="./js/profile.js"></script>

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
                <div class="avatar_hover" onclick="document.getElementById('new_avatar').click()">
                    <img class="avatar_icon" alt="Zmień swoje zdjęcie profilowe" src="./img/icons/<?php echo ($_SESSION['color'] == '2') ? '0' : $_SESSION['color'];?>/edit_settings_regular_icon.png"></img>
                </div>
                <img class="avatar" alt="Twoje zdjęcie profilowe" src="./profile/<?php if(is_readable('./profile/'.$_SESSION['id'] . '.jpeg')) {echo $_SESSION['id'];} else {echo "default";} ?>.jpeg" />
                
                <form method="POST" enctype="multipart/form-data" style="display: none; position:absolute;">
                    <input id="new_avatar" name="avatar" type="file" accept="image/jpeg" onchange="this.form.submit();">
                </form>

                <div id="profile">
                    <p><b>Imię i nazwisko:</b> <span><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></p>
                    <p><b>Email:</b> <?php echo $_SESSION['email']; ?></p>
                    <p><b>Klasa: </b> <?php echo $_SESSION['class']; ?></p>
                </div>
            </div>
        </div>
        <div class="p2">
            <div>
                <h3>Dane ucznia</h3>
                <div class="left">
                    <p><b>Imię i nazwisko:</b> <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></p>
                    <p><b>Płeć: </b> <?php echo $row['gender'] == 'male' ? "Mężczyzna" : "Kobieta"; ?></p>
                    <p><b>Email:</b> <?php echo $_SESSION['email']; ?></p>
                    <p><b>Adres zamieszkania:</b> <?php echo $row['address_street'] . " " . $row['address_number']; ?></p>
                    <p><b>Adres zameldowania:</b> </p>
                    <p><b>Miasto:</b> <?php echo $row['address_city'];?></p>
                    <p><b>Miasto urodzenia:</b> <?php echo $row['birth_city'];?></p>
                    <p><b>Data urodzenia:</b> <?php echo $row['birth_date'];?></p>
                    <p><b>Pesel:</b> <?php echo $row['pesel'];?></p>
                    <p><b>Obywatelstwo:</b> <?php echo $row['citizenship'];?></p>
                </div>
                <div class="right">
                <p><b>Numer telefonu:</b> <?php echo $row['mobile'];?></p>
                    <p><b>Numer telefonu matki:</b> <?php echo $row['mobile_m'];?></p>
                    <p><b>Numer telefonu ojca:</b> <?php echo $row['mobile_d'];?></p>
                    <p><b>Imię matki:</b> <?php echo ''?></p>
                    <p><b>Imię ojca:</b> <?php echo ''?></p>
                </div>
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
        <div class="p5">
            <?php
                $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
                mysqli_set_charset($conn, DB['charset']);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $result = mysqli_query($conn, "
                SELECT `users_students`.*, `users_students`.`students_id`
                FROM `users_students`
                WHERE `users_students`.`students_id` = '".$_SESSION['id']."';
                ");
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                }
                mysqli_free_result($result);
            ?>
            <div class="top">
                <h3>Bezpieczeństwo</h3>
            </div>
            <div class="left">
                <p class="security"><b>Adres email:</b></p>
                <form class="security" method="POST">
                    <input type="email" value="<?php echo $_SESSION['email']; ?>">
                </form>
                <p><b>Hasło:</b> </p>
                <form class="security" action="profile.php" method="POST">
                    <p class="security">Nowe hasło: </p>
                    <input type="password" name="password"><br />
                    <p class="security">Potwierdź nowe hasło: </p>
                    <input type="password" name="passwordc">
                    <button>Zmień hasło</button>
                </form>
            </div>
            <div class="right">
                <p>Ostatnie logowanie: <?php echo $row['last_login'] . " (" . $row['ip'] . ")" ?></p>
                <p>Ostatnia zmiana hasła: <?php echo $row['last_pass'] ?></p>
            </div>
        </div>
        <div class="p6">
            <div>
                <h3>Informacje</h3>
                <p id="browser_version"></p>
                <p id="app_version">Wersja aplikacji: 1.0.0</p>
                <a href="./privacypolicy.php"><p>Polityka prywatności</p></a>
                <a href="./cookiespolicy.php"><p>Polityka plików cookie</p></a>
            </div>
        </div>
</section>
<script src="./js/debuginfo.js"></script>
<script src="./js/keyborad.js"></script>
<script>
    get_browser();
</script>
</body>
</html>