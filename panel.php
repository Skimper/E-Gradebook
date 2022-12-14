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
    <title>Panel</title>
    
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

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
    <a class="active" href="panel.php">Panel</a>
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
        <h1 class="grades">Panel</h1>
    </header>
    <div class="panel">
        <div class="p1">
            <h3>Dane ucznia</h3>
            <p><b>Imię i nazwisko:</b> <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></p>
            <p><b>Email:</b> <?php echo $_SESSION['email']; ?></p>
            <p><b>Klasa:</b> <?php echo $_SESSION['class']; ?></p>
            <a href="profile.php"><p class="profile_button">Profil ucznia</p></a>
        </div>
        <div class="p2">
            <h3>Ostatnie oceny</h3>
            <?php // No kto by pomyślał że tu jest skrypt od wyświetlania ostatnich ocen, miłego dnia ;)
                $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
                mysqli_set_charset($conn, DB['charset']);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $result = mysqli_query($conn, "
                SELECT `grades`.`grade`, `grades`.`color`, `subject`.`name`, `grades`.`students_id`
                FROM `grades` 
                	LEFT JOIN `subject` ON `grades`.`subject_id` = `subject`.`id`
                WHERE `grades`.`date` > ' ". date('Y-m-d',(strtotime ( '-7 day' , strtotime (date('Y-m-d'))))) ." ' AND `grades`.`students_id` = '" . $_SESSION['id'] . "';
                ");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p><b>" . $row['name'] . "</b>: " . $row['grade'] . "</p>";
                }
                mysqli_free_result($result);
            ?>
        </div>
        <div class="p3">
            <h3>Frekwencja</h3>
            <div class="attendance_chart" style="margin-left: auto; margin-right: auto; width:220px; height:220px;">
                <canvas id="myChart" width="100px" height="100px"></canvas>
            </div>
            <?php // A tu frekwencja, a raczej jej podgląd
                $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
                mysqli_set_charset($conn, DB['charset']);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $result = mysqli_query($conn, "
                SELECT `attendance`.`students_id`, COUNT(`attendance`.`type`) AS ob
                FROM `attendance`
                WHERE `attendance`.`students_id` = '" . $_SESSION['id'] . "' AND `attendance`.`type` = 'ob';
                ");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p><b>Obecność: </b>". $row['ob'] ."</p>";
                    $ob = $row['ob'];
                }
                mysqli_free_result($result);

                $result = mysqli_query($conn, "
                SELECT `attendance`.`students_id`, COUNT(`attendance`.`type`) AS nb
                FROM `attendance`
                WHERE `attendance`.`students_id` = '" . $_SESSION['id'] . "' AND `attendance`.`type` = 'no';
                ");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p><b>Nieobecność nieusprawiedliwiona:</b> ". $row['nb'] ."</p>";
                    $nb = $row['nb'];
                }
                mysqli_free_result($result);

                $result = mysqli_query($conn, "
                SELECT `attendance`.`students_id`, COUNT(`attendance`.`type`) AS nu
                FROM `attendance`
                WHERE `attendance`.`students_id` = '" . $_SESSION['id'] . "' AND `attendance`.`type` = 'nu';
                ");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p><b>Nieobecność usprawiedliwiona:</b> ". $row['nu'] ."</p>";
                    $nu = $row['nu'];
                }
                mysqli_free_result($result);
                mysqli_close($conn);
            ?>
            <script>
            function RenderChart(ob, nu, nb){
                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                    options: {
                        animation: false
                    },
                    labels: [
                        'Obecność',
                        'Nieobecność usprawiedliwiona',
                        'Nieobecność nieusprawiedliwiona'
                    ],
                    datasets: [{
                        label: 'My First Dataset',
                        data: [ob, nu, nb],
                        backgroundColor: [
                        'rgb(63, 172, 0)',
                        'rgb(121, 174, 0)',
                        'rgb(179, 0, 0)'
                      ],
                      hoverOffset: 1,
                      borderColor: 'black',
                      aspectRatio: 1 / 1,
                      responsive: true,
                      maintainAspectRatio: true,
                    }]
                }});
            }
            </script>
        </div>
        <div class="p4">
            <?php // Podgląd najbliższego planu lekcji (Penie i tak trzeba będzie to zmienić)
                $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
                mysqli_set_charset($conn, DB['charset']);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                switch (getdate()['wday']){
                    case 0:
                        $day = date("Y-m-d");
                        echo "<h3>Najbliższe lekcje</h3>";
                        break;
                    case 1:
                        if (getdate()['hours'] < 16){
                            $day = date("Y-m-d");
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Jutrzejsze lekcje</h3>";
                            $day = date("Y-m-d");
                        }
                        break; 
                    case 2:
                        if (getdate()['hours'] < 16){
                            $day = date("Y-m-d");
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Jutrzejsze lekcje</h3>";
                            $day = date("Y-m-d");
                        }
                        break; 
                    case 3:
                        if (getdate()['hours'] < 16){
                            $day = date("Y-m-d");
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Jutrzejsze lekcje</h3>";
                            $day = date("Y-m-d");
                        }
                        break;
                    case 4:
                        if (getdate()['hours'] < 16){
                            $day = date("Y-m-d");
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Jutrzejsze lekcje</h3>";
                            $day = date("Y-m-d");
                        }
                        break;
                    case 5:
                        if (getdate()['hours'] < 16){
                            $day = date("Y-m-d");
                            echo "<h3>Dzisiejsze lekcje</h3>";
                        } else {
                            echo "<h3>Najbliższe lekcje</h3>";
                            $day = date("Y-m-d");
                        }
                        break;
                    case 6:
                        $day = date("Y-m-d");
                        echo "<h3>Najbliższe lekcje</h3>";
                        break;
                }

                $result = mysqli_query($conn, "
                SELECT `timetable`.`classes_id`, `timetable`.`lesson`, `timetable`.`day`, `subject`.`name`
                FROM `timetable` 
                    LEFT JOIN `subject` ON `timetable`.`subject_id` = `subject`.`id`
                WHERE `timetable`.`classes_id` = '".$_SESSION['class']."' AND `timetable`.`day` = '".$day."'
                ORDER BY `timetable`.`lesson`;
                ");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p><b>" . $row['lesson'] . "</b>. " . $row['name'] . "</p>";
                }
                mysqli_free_result($result);
            ?>
        </div>
        <div class="p5">
            <h3>Nadchodzące sprawdziany</h3>
            <?php // Sprawdziany, pracy domowych tu chyba na razie nie będzie
                $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
                mysqli_set_charset($conn, DB['charset']);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $result = mysqli_query($conn, "
                SELECT `exams`.`topic`, `subject`.`name`, `exams`.`date`
                FROM `exams` 
                	LEFT JOIN `subject` ON `exams`.`subject_id` = `subject`.`id`
                WHERE `exams`.`classes_id` = '4c' AND `exams`.`date` > '".date("Y-m-d")."';
                ");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p><b>" . $row['name'] . "</b>: " . $row['topic'] . " (" . $row['date'] . ")" .  "</p>";
                }
                mysqli_free_result($result);
            ?>
        </div>
        <div class="p6">
            <h3>Zebrania i wydarzenia</h3>
            <?php // Zebrania i jakieś tam szkolne gówna
                $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
                mysqli_set_charset($conn, DB['charset']);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $result = mysqli_query($conn, "
                SELECT `meetings`.`topic`, `meetings`.`classes_id`, `meetings`.`date`
                FROM `meetings`
                WHERE `meetings`.`classes_id` = '".$_SESSION['class']."';
                ");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p><b>" . $row['date'] . "</b> - " . $row['topic'] . "</p>";
                }
                mysqli_free_result($result);
            ?>
        </div>
        <div class="p7">
            <h3>Zrealizowane tematy</h3>
            <?php // Ostatnie 6 tematów
                $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
                mysqli_set_charset($conn, DB['charset']);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $result = mysqli_query($conn, "
                SELECT `topics`.`description`, `topics`.`classes_id`, `topics`.`date`
                FROM `topics`
                WHERE `topics`.`classes_id` = '".$_SESSION['class']."'
                ORDER BY `topics`.`date` DESC
                LIMIT 6;
                ");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p><b>" . $row['date'] . "</b> " . $row['description'] . "</p>";
                }
                mysqli_free_result($result);
            ?>
        </div>
        <div class="p8">
            <h3>Podsumowanie</h3>
            <?php // Wszystko po trochu? Trzeba jeszcze zrobić te najwyższe średnie. DOKOŃCZYĆ TO! Haha no i dokończyłem zamiast usunąć
                $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
                mysqli_set_charset($conn, DB['charset']);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $result = mysqli_query($conn, "
                SELECT `grades`.`students_id`, AVG(`grades`.`grade`) AS `avg`, COUNT(`grades`.`grade`) AS `count`
                FROM `grades`
                WHERE `grades`.`students_id` = '".$_SESSION['id']."'
                ");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<p><b>Ilośc ocen:</b> " . $row['count'] . "</p>";
                    echo "<p><b>Średnia ocen:</b> " . number_format((float)$row['avg'], 2, '.', '') . "</p>";
                }
                mysqli_free_result($result);

                $grades = array(
                    "3" => array(),
                    "4" => array(),
                    "5" => array(),
                    "6" => array(),
                    "7" => array(),
                    "8" => array(),
                    "9" => array(),
                    "10" => array(),
                    "11" => array(),
                    "12" => array(),
                    "13" => array(),
                    "14" => array(),
                    "15" => array(),
                    "16" => array(),
                    "17" => array(),
                );

                $result = mysqli_query($conn, "
                SELECT `grades`.`grade`, `grades`.`weight`, `grades`.`students_id`, `grades`.`subject_id`
                FROM `grades`
                WHERE `grades`.`students_id` = '".$_SESSION['id']."'
                ORDER BY `grades`.`subject_id`;
                ");
                while ($row = mysqli_fetch_array($result)) {
                    array_push($grades[$row['subject_id']], array($row['grade'], $row['weight']));
                }
                mysqli_free_result($result);

                $avg = array();
                $result = mysqli_query($conn, "
                SELECT cast(sum(`grade` * `weight`) / sum(`weight`) as decimal(8, 2)) as `weight`, `grades`.`students_id`, `grades`.`subject_id`, `subject`.`name`
                FROM `grades`
                    LEFT JOIN `subject` ON `grades`.`subject_id` = `subject`.`id`
                WHERE `grades`.`students_id` = '".$_SESSION['id']."'
                GROUP BY `grades`.`subject_id`;
                ");
                while ($row = mysqli_fetch_array($result)) {
                    $avg[$row['name']] = $row['weight'];
                }
                mysqli_free_result($result);

                // Tutaj jest ostrzeżenie przy braku ocen.
                $max = array_keys($avg, max($avg));
                $min = array_keys($avg, min($avg));

                if(!empty($avg)){
                    echo "<p><b>Najwyższa średnia: </b>" . max($avg) . " (" . $max[0] . ")</p>";
                    echo "<p><b>Najniższa średnia: </b>" . min($avg) . " (" . $min[0] . ")</p>";
                } else {
                    echo "<p><b>Najwyższa średnia: </b></p>";
                    echo "<p><b>Najniższa średnia: </b></p>";
                }
            ?>
            <p><b>Najniższa frekwencja:</b> </p>
        </div>
    </div>
</section>
<script>
    RenderChart(<?php echo $ob . "," . $nb . "," . $nu; ?>);
</script>
<script src="./js/keyborad.js"></script>
</body>
</html>