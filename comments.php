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
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,  user-scalable=no">
    <title>Uwagi i osiągnięcia</title>

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
    <a href="timetable.php">Plan lekcji</a>
    <a href="exams.php">Sprawdziany</a>
    <a href="meetings.php">Wydarzenia</a>
    <a href="topics.php">Tematy</a>
    <a class="active" href="comments.php">Uwagi</a>

    <a class="bottom" href="settings.php">Ustawienia</a>
</nav>
<section>
    <header>
        <h1 class="grades" id="coments_title">Uwagi</h1>
    </header>
    <div class="comments_holder">
        <p class="comments_button" onclick="changeComment('c')">Uwagi</p>
        <p class="comments_button" onclick="changeComment('p')">Osiągnięcia</p>
    </div>
    <?php
        $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
        mysqli_set_charset($conn, DB['charset']);
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $comments = array(
            'comment' => array(),
            'praise' => array()
        );

        $result = mysqli_query($conn, "
        SELECT `comments`.*, `comments`.type, `teachers`.`first_name`
        FROM `comments` 
        	LEFT JOIN `teachers` ON `comments`.`teachers_id` = `teachers`.`id`
        WHERE `comments`.`students_id` = '".$_SESSION['id']."';
        ");

        while ($row = mysqli_fetch_array($result)) {
            array_push($comments[$row['type']], array($row['topic'], $row['description'], $row['first_name'], $row['date']));
        }
    ?>
    <table class="comments" id="comments" border="5" cellspacing="0" align="center" style="display: table;">
        <tr>
            <td class="day" align="center" height="50" style="width: 20px;"><b>Nauczyciel</b></td>
            <td class="day" align="center" height="50" style="width: 20px;"><b>Data</b></td>
            <td class="day" align="center" height="50" style="width: 200px;"><b>Opis</b></td>
        </tr>
        <?php
            for ($i=0; $i < count($comments['comment']); $i++) { 
                echo "<tr>";
                    echo "<td align='center' height='50'>".$comments['comment'][$i][2]."</td>";
                    echo "<td align='center' height='50'>".$comments['comment'][$i][3]."</td>";
                    echo "<td align='center' height='50'>".$comments['comment'][$i][0]."<br />". $comments['comment'][$i][1] ."</td>";
                echo "</tr>";
            }
        ?>
    </table>
    <table class="comments" id="praise" border="5" cellspacing="0" align="center" style="display: none;">
        <tr>
            <td class="day" align="center" height="50" style="width: 20px;"><b>Nauczyciel</b></td>
            <td class="day" align="center" height="50" style="width: 20px;"><b>Data</b></td>
            <td class="day" align="center" height="50" style="width: 200px;"><b>Opis</b></td>
        </tr>
        <?php
            for ($i=0; $i < count($comments['praise']); $i++) { 
                echo "<tr>";
                    echo "<td align='center' height='50'>".$comments['praise'][$i][2]."</td>";
                    echo "<td align='center' height='50'>".$comments['praise'][$i][3]."</td>";
                    echo "<td align='center' height='50'>".$comments['praise'][$i][0]."<br />". $comments['praise'][$i][1] ."</td>";
                echo "</tr>";
            }
        ?>
    </table>
</section>
<script src="./js/commentspraise.js"></script>
<script src="./js/keyborad.js"></script>
</body>
</html>