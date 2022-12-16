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
    <title>Oceny</title>

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
    <a class="active" href="grades.php">Oceny</a>
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
        <h1 class="grades">Oceny</h1>
    </header>
    <div>
        <table class="grades_table">
        <?php // Całe generowanie tablel z ocenami
                $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
                mysqli_set_charset($conn, DB['charset']);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

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
                $avg = array();
                $result = mysqli_query($conn, "
                SELECT `grades`.*, `grades`.`students_id`
                FROM `grades`
                WHERE `grades`.`students_id` = '".$_SESSION['id']."'
                ORDER BY `grades`.`subject_id`;
                ");
                while ($row = mysqli_fetch_array($result)) {
                    array_push($grades[$row['subject_id']], array($row['grade'], $row['weight'], $row['color'], $row['title'], $row['description'], $row['date']));
                }
                mysqli_free_result($result);
            ?>
            <tr class="table_top">
                <th style="width:30%">Przedmiot</th>
                <td><b>Oceny</b></td>
                <td style="width:10%"><b>Średnia</b></td>
            </tr>
            <tr>
                <th>Język polski</th>
                <td>
                    <?php 
                        if(isset($grades[3])) {
                            for ($i=0; $i < count($grades[3]); $i++) { 
                                if (isset($grades[3][$i][2])){
                                    echo "<span class='grade' style='color: ".$grades[3][$i][0].";' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[3][$i][0] . ", ";
                                } else { 
                                    echo "<span class='grade' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[3][$i][0] . ", ";
                                }
                                echo "
                                <div class='grade_info' style='display: none;'>
                                    <p>Waga: " . $grades[3][$i][1] . "</p>
                                    <p>Tytuł: " . $grades[3][$i][3] . "</p>
                                    <p>Opis: " . $grades[3][$i][4] . "</p>
                                    <p>Data: " . $grades[3][$i][5] . "</p>
                                </div>
                                ";
                                echo "</span>";

                                for ($j=0; $j < $grades[3][$i][1]; $j++) { 
                                    array_push($avg, $grades[3][$j][0]);
                                }
                            }
                        }
                    ?>
                </td> 
                <td>
                    <?php 
                    if (isset($avg[0])){
                        $tmp = array_sum($avg)/count($avg);
                        echo number_format((float)$tmp, 2, '.', '');
                        $avg = array();
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Język angielski</th>
                <td>
                    <?php 
                        if(isset($grades[4])) {
                            for ($i=0; $i < count($grades[4]); $i++) { 
                                if (isset($grades[4][$j][2])){
                                    echo "<span class='grade' style='color: ".$grades[4][$i][0].";' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[4][$i][0] . ", ";
                                } else { 
                                    echo "<span class='grade' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[4][$i][0] . ", ";
                                }
                                echo "
                                <div class='grade_info' style='display: none;'>
                                    <p>Waga: " . $grades[4][$i][1] . "</p>
                                    <p>Tytuł: " . $grades[4][$i][3] . "</p>
                                    <p>Opis: " . $grades[4][$i][4] . "</p>
                                    <p>Data: " . $grades[4][$i][5] . "</p>
                                </div>
                                ";
                                echo "</span>";

                                for ($j=0; $j < $grades[4][$i][1]; $j++) { 
                                    array_push($avg, $grades[4][$i][0]);
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php 
                    if (isset($avg[0])){
                        $tmp = array_sum($avg)/count($avg);
                        echo number_format((float)$tmp, 2, '.', '');
                        $avg = array();
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Język niemiecki</th>
                <td>
                    <?php 
                        if(isset($grades[5])) {
                            for ($i=0; $i < count($grades[5]); $i++) { 
                                if (isset($grades[5][$j][2])){
                                    echo "<span class='grade' style='color: ".$grades[5][$i][0].";' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[5][$i][0] . ", ";
                                } else { 
                                    echo "<span class='grade' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[5][$i][0] . ", ";
                                }
                                echo "
                                <div class='grade_info' style='display: none;'>
                                    <p>Waga: " . $grades[5][$i][1] . "</p>
                                    <p>Tytuł: " . $grades[5][$i][3] . "</p>
                                    <p>Opis: " . $grades[5][$i][4] . "</p>
                                    <p>Data: " . $grades[5][$i][5] . "</p>
                                </div>
                                ";
                                echo "</span>";

                                for ($j=0; $j < $grades[5][$i][1]; $j++) { 
                                    array_push($avg, $grades[5][$i][0]);
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php 
                    if (isset($avg[0])){
                        $tmp = array_sum($avg)/count($avg);
                        echo number_format((float)$tmp, 2, '.', '');
                        $avg = array();
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Matematyka</th>
                <td>
                    <?php 
                        if(isset($grades[6])) {
                            for ($i=0; $i < count($grades[6]); $i++) { 
                                if (isset($grades[6][$j][2])){
                                    echo "<span class='grade' style='color: ".$grades[6][$i][0].";' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[6][$i][0] . ", ";
                                } else { 
                                    echo "<span class='grade' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[6][$i][0] . ", ";
                                }
                                echo "
                                <div class='grade_info' style='display: none;'>
                                    <p>Waga: " . $grades[6][$i][1] . "</p>
                                    <p>Tytuł: " . $grades[6][$i][3] . "</p>
                                    <p>Opis: " . $grades[6][$i][4] . "</p>
                                    <p>Data: " . $grades[6][$i][5] . "</p>
                                </div>
                                ";
                                echo "</span>";

                                for ($j=0; $j < $grades[6][$i][1]; $j++) { 
                                    array_push($avg, $grades[6][$i][0]);
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php 
                    if (isset($avg[0])){
                        $tmp = array_sum($avg)/count($avg);
                        echo number_format((float)$tmp, 2, '.', '');
                        $avg = array();
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Informatyka</th>
                <td>
                    <?php 
                        if(isset($grades[7])) {
                            for ($i=0; $i < count($grades[7]); $i++) { 
                                if (isset($grades[7][$j][2])){
                                    echo "<span class='grade' style='color: ".$grades[7][$i][0].";' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[7][$i][0] . ", ";
                                } else { 
                                    echo "<span class='grade' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[7][$i][0] . ", ";
                                }
                                echo "
                                <div class='grade_info' style='display: none;'>
                                    <p>Waga: " . $grades[7][$i][1] . "</p>
                                    <p>Tytuł: " . $grades[7][$i][3] . "</p>
                                    <p>Opis: " . $grades[7][$i][4] . "</p>
                                    <p>Data: " . $grades[7][$i][5] . "</p>
                                </div>
                                ";
                                echo "</span>";

                                for ($j=0; $j < $grades[7][$i][1]; $j++) { 
                                    array_push($avg, $grades[7][$i][0]);
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php 
                    if (isset($avg[0])){
                        $tmp = array_sum($avg)/count($avg);
                        echo number_format((float)$tmp, 2, '.', '');
                        $avg = array();
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Historia</th>
                <td>
                <?php 
                        if(isset($grades[8])) {
                            for ($i=0; $i < count($grades[8]); $i++) { 
                                if (isset($grades[8][$j][2])){
                                    echo "<span class='grade' style='color: ".$grades[8][$i][0].";' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[8][$i][0] . ", ";
                                } else { 
                                    echo "<span class='grade' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[8][$i][0] . ", ";
                                }
                                echo "
                                <div class='grade_info' style='display: none;'>
                                    <p>Waga: " . $grades[8][$i][1] . "</p>
                                    <p>Tytuł: " . $grades[8][$i][3] . "</p>
                                    <p>Opis: " . $grades[8][$i][4] . "</p>
                                    <p>Data: " . $grades[8][$i][5] . "</p>
                                </div>
                                ";
                                echo "</span>";

                                for ($j=0; $j < $grades[8][$i][1]; $j++) { 
                                    array_push($avg, $grades[8][$i][0]);
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php 
                    if (isset($avg[0])){
                        $tmp = array_sum($avg)/count($avg);
                        echo number_format((float)$tmp, 2, '.', '');
                        $avg = array();
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Historia i teraźniejszość</th>
                <td>
                <?php 
                        if(isset($grades[9])) {
                            for ($i=0; $i < count($grades[9]); $i++) { 
                                if (isset($grades[9][$j][2])){
                                    echo "<span class='grade' style='color: ".$grades[9][$i][0].";' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[9][$i][0] . ", ";
                                } else { 
                                    echo "<span class='grade' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[9][$i][0] . ", ";
                                }
                                echo "
                                <div class='grade_info' style='display: none;'>
                                    <p>Waga: " . $grades[9][$i][1] . "</p>
                                    <p>Tytuł: " . $grades[9][$i][3] . "</p>
                                    <p>Opis: " . $grades[9][$i][4] . "</p>
                                    <p>Data: " . $grades[9][$i][5] . "</p>
                                </div>
                                ";
                                echo "</span>";

                                for ($j=0; $j < $grades[9][$i][1]; $j++) { 
                                    array_push($avg, $grades[9][$i][0]);
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php 
                    if (isset($avg[0])){
                        $tmp = array_sum($avg)/count($avg);
                        echo number_format((float)$tmp, 2, '.', '');
                        $avg = array();
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Wychowanie fizyczne</th>
                <td>
                <?php 
                        if(isset($grades[10])) {
                            for ($i=0; $i < count($grades[10]); $i++) { 
                                if (isset($grades[10][$j][2])){
                                    echo "<span class='grade' style='color: ".$grades[10][$i][0].";' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[10][$i][0] . ", ";
                                } else { 
                                    echo "<span class='grade' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[10][$i][0] . ", ";
                                }
                                echo "
                                <div class='grade_info' style='display: none;'>
                                    <p>Waga: " . $grades[10][$i][1] . "</p>
                                    <p>Tytuł: " . $grades[10][$i][3] . "</p>
                                    <p>Opis: " . $grades[10][$i][4] . "</p>
                                    <p>Data: " . $grades[10][$i][5] . "</p>
                                </div>
                                ";
                                echo "</span>";

                                for ($j=0; $j < $grades[10][$i][1]; $j++) { 
                                    array_push($avg, $grades[10][$i][0]);
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php 
                    if (isset($avg[0])){
                        $tmp = array_sum($avg)/count($avg);
                        echo number_format((float)$tmp, 2, '.', '');
                        $avg = array();
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Muzyka</th>
                <td>
                    <?php 
                        if(isset($grades[11])) {
                            for ($i=0; $i < count($grades[11]); $i++) { 
                                if (isset($grades[11][$j][2])){
                                    echo "<span class='grade' style='color: ".$grades[11][$i][0].";' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[11][$i][0] . ", ";
                                } else { 
                                    echo "<span class='grade' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[11][$i][0] . ", ";
                                }
                                echo "
                                <div class='grade_info' style='display: none;'>
                                    <p>Waga: " . $grades[11][$i][1] . "</p>
                                    <p>Tytuł: " . $grades[11][$i][3] . "</p>
                                    <p>Opis: " . $grades[11][$i][4] . "</p>
                                    <p>Data: " . $grades[11][$i][5] . "</p>
                                </div>
                                ";
                                echo "</span>";

                                for ($j=0; $j < $grades[11][$i][1]; $j++) { 
                                    array_push($avg, $grades[11][$i][0]);
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php 
                    if (isset($avg[0])){
                        $tmp = array_sum($avg)/count($avg);
                        echo number_format((float)$tmp, 2, '.', '');
                        $avg = array();
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Plastyka</th>
                <td>
                    <?php 
                        if(isset($grades[12])) {
                            for ($i=0; $i < count($grades[12]); $i++) { 
                                if (isset($grades[12][$j][2])){
                                    echo "<span class='grade' style='color: ".$grades[12][$i][0].";' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[12][$i][0] . ", ";
                                } else { 
                                    echo "<span class='grade' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[12][$i][0] . ", ";
                                }
                                echo "
                                <div class='grade_info' style='display: none;'>
                                    <p>Waga: " . $grades[12][$i][1] . "</p>
                                    <p>Tytuł: " . $grades[12][$i][3] . "</p>
                                    <p>Opis: " . $grades[12][$i][4] . "</p>
                                    <p>Data: " . $grades[12][$i][5] . "</p>
                                </div>
                                ";
                                echo "</span>";

                                for ($j=0; $j < $grades[12][$i][1]; $j++) { 
                                    array_push($avg, $grades[12][$i][0]);
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php 
                    if (isset($avg[0])){
                        $tmp = array_sum($avg)/count($avg);
                        echo number_format((float)$tmp, 2, '.', '');
                        $avg = array();
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Biologia</th>
                <td>
                    <?php 
                        if(isset($grades[13])) {
                            for ($i=0; $i < count($grades[13]); $i++) { 
                                if (isset($grades[13][$j][2])){
                                    echo "<span class='grade' style='color: ".$grades[13][$i][0].";' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[13][$i][0] . ", ";
                                } else { 
                                    echo "<span class='grade' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[13][$i][0] . ", ";
                                }
                                echo "
                                <div class='grade_info' style='display: none;'>
                                    <p>Waga: " . $grades[13][$i][1] . "</p>
                                    <p>Tytuł: " . $grades[13][$i][3] . "</p>
                                    <p>Opis: " . $grades[13][$i][4] . "</p>
                                    <p>Data: " . $grades[13][$i][5] . "</p>
                                </div>
                                ";
                                echo "</span>";

                                for ($j=0; $j < $grades[13][$i][1]; $j++) { 
                                    array_push($avg, $grades[13][$i][0]);
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php 
                    if (isset($avg[0])){
                        $tmp = array_sum($avg)/count($avg);
                        echo number_format((float)$tmp, 2, '.', '');
                        $avg = array();
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Geografia</th>
                <td>
                    <?php 
                        if(isset($grades[14])) {
                            for ($i=0; $i < count($grades[14]); $i++) { 
                                if (isset($grades[14][$j][2])){
                                    echo "<span class='grade' style='color: ".$grades[14][$i][0].";' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[14][$i][0] . ", ";
                                } else { 
                                    echo "<span class='grade' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[14][$i][0] . ", ";
                                }
                                echo "
                                <div class='grade_info' style='display: none;'>
                                    <p>Waga: " . $grades[14][$i][1] . "</p>
                                    <p>Tytuł: " . $grades[14][$i][3] . "</p>
                                    <p>Opis: " . $grades[14][$i][4] . "</p>
                                    <p>Data: " . $grades[14][$i][5] . "</p>
                                </div>
                                ";
                                echo "</span>";

                                for ($j=0; $j < $grades[14][$i][1]; $j++) { 
                                    array_push($avg, $grades[14][$i][0]);
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php 
                    if (isset($avg[0])){
                        $tmp = array_sum($avg)/count($avg);
                        echo number_format((float)$tmp, 2, '.', '');
                        $avg = array();
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Chemia</th>
                <td>
                    <?php 
                        if(isset($grades[15])) {
                            for ($i=0; $i < count($grades[15]); $i++) { 
                                if (isset($grades[15][$j][2])){
                                    echo "<span class='grade' style='color: ".$grades[15][$i][0].";' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[15][$i][0] . ", ";
                                } else { 
                                    echo "<span class='grade' onmouseover='GradeInfo(this);' onmouseout='HideGrade(this);'>". $grades[15][$i][0] . ", ";
                                }
                                echo "
                                <div class='grade_info' style='display: none;'>
                                    <p>Waga: " . $grades[15][$i][1] . "</p>
                                    <p>Tytuł: " . $grades[15][$i][3] . "</p>
                                    <p>Opis: " . $grades[15][$i][4] . "</p>
                                    <p>Data: " . $grades[15][$i][5] . "</p>
                                </div>
                                ";
                                echo "</span>";

                                for ($j=0; $j < $grades[15][$i][1]; $j++) { 
                                    array_push($avg, $grades[15][$i][0]);
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php 
                    if (isset($avg[0])){
                        $tmp = array_sum($avg)/count($avg);
                        echo number_format((float)$tmp, 2, '.', '');
                        $avg = array();
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
</section>
<script src="./js/grade.js"></script>
<script src="./js/keyborad.js"></script>
</body>
</html>