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

    if(isset($_SESSION['attendance_i'])) $_SESSION['attendance_i'] = 0;
    if(!isset($_SESSION['timetable_i'])) $_SESSION['timetable_i'] = 0;

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
    <title>Plan lekcji</title>
    
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
    <a class="active" href="timetable.php">Plan lekcji</a>
    <a href="exams.php">Sprawdziany</a>
    <a href="meetings.php">Wydarzenia</a>
    <a href="topics.php">Tematy</a>
    <a href="comments.php">Uwagi</a>

    <a class="bottom" href="settings.php">Ustawienia</a>
    </nav>
    <section>
        <header>
            <h1 class="grades">Plan lekcji</h1>
        </header>
        <div>
            <form class="timetabel_holder" method="POST">
                <input class="timetabel_button" type="submit" value="<-- Tydzień" name="back" />
                <input class="timetabel_button" type="submit" value="Tydzień -->" name="forward" />
            </form>
        </div>
        <table class="attendance" border="5" cellspacing="0" align="center">
        <?php
            if (array_key_exists('back', $_POST)) {
                $_SESSION['timetable_i'] -= 7;
            }

            if (array_key_exists('forward', $_POST)) {
                $_SESSION['timetable_i'] += 7;
            }

            $day = date('w') - 1;
            $day1 = date('Y-m-d', strtotime('+' . ($_SESSION['timetable_i'] + $day) . ' days'));
            $day2 = date('Y-m-d', strtotime('+' . (($_SESSION['timetable_i'] + 1) + $day) . ' days'));
            $day3 = date('Y-m-d', strtotime('+' . (($_SESSION['timetable_i'] + 2) + $day) . ' days'));
            $day4 = date('Y-m-d', strtotime('+' . (($_SESSION['timetable_i'] + 3) + $day) . ' days'));
            $day5 = date('Y-m-d', strtotime('+' . (($_SESSION['timetable_i'] + 4) + $day) . ' days'));
            $day6 = date('Y-m-d', strtotime('+' . (($_SESSION['timetable_i'] + 5) + $day) . ' days'));
            $day7 = date('Y-m-d', strtotime('+' . (($_SESSION['timetable_i'] + 6) + $day) . ' days'));

            $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
            mysqli_set_charset($conn, DB['charset']);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $result = mysqli_query($conn, "
            SELECT `timetable`.`classes_id`, `timetable`.`lesson`, `timetable`.`day`, `subject`.`name`
                FROM `timetable` 
                    LEFT JOIN `subject` ON `timetable`.`subject_id` = `subject`.`id`
                WHERE `timetable`.`classes_id` = '" . $_SESSION['class'] . "' 
                AND `timetable`.`day` >= '" . $day1 . "'
                AND `timetable`.`day` <= '" . $day7 . "';
            ");

            $timetable = array(
                $day1 => array(
                    "0" => "Poniedziałek",
                ),
                $day2 => array(
                    "0" => "Wtorek",
                ),
                $day3 => array(
                    "0" => "Środa",
                ),
                $day4 => array(
                    "0" => "Czwartek",
                ),
                $day5 => array(
                    "0" => "Piątek",
                ),
                $day6 => array(
                    "0" => "Sobota",
                ),
                $day7 => array(
                    "0" => "Niedziela",
                ),
            );

            while ($row = mysqli_fetch_array($result)) {
                array_push($timetable[$row['day']], $row['name']);
            }
            mysqli_free_result($result);
            
            //print "<pre>";
            //print_r($timetable);
            //print "</pre>";
            
            ?>
            <tr>
                <td class="day" align="center" height="50" width="100">
                    <b>Dzień /<br>Lekcja</b></br>
                </td>
                <td class="day" align="center" height="50" width="100">
                    <b><?php echo $day1; ?></b><br>
                    <b><?php echo $timetable[$day1][0]; ?></b>
                </td>
                <td class="day" align="center" height="50" width="100">
                <b><?php echo $day2; ?></b><br>
                    <b><?php echo $timetable[$day2][0]; ?></b>
                </td>
                <td class="day" align="center" height="50" width="100">
                    <b><?php echo $day3; ?></b><br>
                    <b><?php echo $timetable[$day3][0]; ?></b>
                </td>
                <td class="day" align="center" height="50" width="100">
                    <b><?php echo $day4; ?></b><br>
                    <b><?php echo $timetable[$day4][0]; ?></b>
                </td>
                <td class="day" align="center" height="50" width="100">
                    <b><?php echo $day5; ?></b><br>
                    <b><?php echo $timetable[$day5][0]; ?></b>
                </td>
                <td class="day" align="center" height="50" width="100">
                    <b><?php echo $day6; ?></b><br>
                    <b>Sobota</b>
                </td>
                <td class="day" align="center" height="50" width="100">
                    <b><?php echo $day7; ?></b><br>
                    <b>Niedziela</b>
                </td>
            </tr>
            <tr>
                <td align="center" height="50">
                    <b>1<br>7:45-8:30</b>
                </td>
                <td align="center" height="50"><?php if (isset($timetable[$day1][1])) echo $timetable[$day1][1]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day2][1])) echo $timetable[$day2][1]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day3][1])) echo $timetable[$day3][1]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day4][1])) echo $timetable[$day4][1]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day5][1])) echo $timetable[$day5][1]; ?></td>
                <td align="center" height="50"></td>
                <td align="center" height="50"></td>
            </tr>
            <tr>
                <td align="center" height="50">
                    <b>2<br>8:35-9:20</b>
                </td>
                <td align="center" height="50"><?php if (isset($timetable[$day1][2])) echo $timetable[$day1][2]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day2][2])) echo $timetable[$day2][2]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day3][2])) echo $timetable[$day3][2]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day4][2])) echo $timetable[$day4][2]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day5][2])) echo $timetable[$day5][2]; ?></td>
                <td align="center" height="50"></td>
                <td align="center" height="50"></td>
            </tr>
            <tr>
                <td align="center" height="50">
                    <b>3<br>9:25-10:10</b>
                </td>
                <td align="center" height="50"><?php if (isset($timetable[$day1][3])) echo $timetable[$day1][3]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day2][3])) echo $timetable[$day2][3]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day3][3])) echo $timetable[$day3][3]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day4][3])) echo $timetable[$day4][3]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day5][3])) echo $timetable[$day5][3]; ?></td>
                <td align="center" height="50"></td>
                <td align="center" height="50"></td>
            </tr>
            <tr>
                <td align="center" height="50">
                    <b>4<br>10:15-11:00</b>
                </td>
                <td align="center" height="50"><?php if (isset($timetable[$day1][4])) echo $timetable[$day1][4]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day2][4])) echo $timetable[$day2][4]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day3][4])) echo $timetable[$day3][4]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day4][4])) echo $timetable[$day4][4]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day5][4])) echo $timetable[$day5][4]; ?></td>
                <td align="center" height="50"></td>
                <td align="center" height="50"></td>
            </tr>
            <tr>
                <td align="center" height="50">
                    <b>5<br>11:15-12:00</b>
                </td>
                <td align="center" height="50"><?php if (isset($timetable[$day1][5])) echo $timetable[$day1][5]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day2][5])) echo $timetable[$day2][5]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day3][5])) echo $timetable[$day3][5]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day4][5])) echo $timetable[$day4][5]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day5][5])) echo $timetable[$day5][5]; ?></td>
                <td align="center" height="50"></td>
                <td align="center" height="50"></td>
            </tr>
            <tr>
                <td align="center" height="50">
                    <b>6<br>12:15-13:00</b>
                </td>
                <td align="center" height="50"><?php if (isset($timetable[$day1][6])) echo $timetable[$day1][6]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day2][6])) echo $timetable[$day2][6]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day3][6])) echo $timetable[$day3][6]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day4][6])) echo $timetable[$day4][6]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day5][6])) echo $timetable[$day5][6]; ?></td>
                <td align="center" height="50"></td>
                <td align="center" height="50"></td>
            </tr>
            <tr>
                <td align="center" height="50">
                    <b>7<br>13:05-13:50</b>
                </td>
                <td align="center" height="50"><?php if (isset($timetable[$day1][7])) echo $timetable[$day1][7]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day2][7])) echo $timetable[$day2][7]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day3][7])) echo $timetable[$day3][7]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day4][7])) echo $timetable[$day4][7]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day5][7])) echo $timetable[$day5][7]; ?></td>
                <td align="center" height="50"></td>
                <td align="center" height="50"></td>
            </tr>
            <tr>
                <td align="center" height="50">
                    <b>8<br>14:05-14:50</b>
                </td>
                <td align="center" height="50"><?php if (isset($timetable[$day1][8])) echo $timetable[$day1][8]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day2][8])) echo $timetable[$day2][8]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day3][8])) echo $timetable[$day3][8]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day4][8])) echo $timetable[$day4][8]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day5][8])) echo $timetable[$day5][8]; ?></td>
                <td align="center" height="50"></td>
                <td align="center" height="50"></td>
            </tr>
            <tr>
                <td align="center" height="50">
                    <b>9<br>14:55-15:40</b>
                </td>
                <td align="center" height="50"><?php if (isset($timetable[$day1][9])) echo $timetable[$day1][9]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day2][9])) echo $timetable[$day2][9]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day3][9])) echo $timetable[$day3][9]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day4][9])) echo $timetable[$day4][9]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day5][9])) echo $timetable[$day5][9]; ?></td>
                <td align="center" height="50"></td>
                <td align="center" height="50"></td>
            </tr>
            <tr>
                <td align="center" height="50">
                    <b>10<br>15:45-16:30</b>
                </td>
                <td align="center" height="50"><?php if (isset($timetable[$day1][10])) echo $timetable[$day1][10]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day2][10])) echo $timetable[$day2][10]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day3][10])) echo $timetable[$day3][10]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day4][10])) echo $timetable[$day4][10]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day5][10])) echo $timetable[$day5][10]; ?></td>
                <td align="center" height="50"></td>
                <td align="center" height="50"></td>
            </tr>
            <tr>
                <td align="center" height="50">
                    <b>11<br>16:35-17:20</b>
                </td>
                <td align="center" height="50"><?php if (isset($timetable[$day1][11])) echo $timetable[$day1][11]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day2][11])) echo $timetable[$day2][11]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day3][11])) echo $timetable[$day3][11]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day4][11])) echo $timetable[$day4][11]; ?></td>
                <td align="center" height="50"><?php if (isset($timetable[$day5][11])) echo $timetable[$day5][11]; ?></td>
                <td align="center" height="50"></td>
                <td align="center" height="50"></td>
            </tr>
        </table>
    </section>
</body>

</html>