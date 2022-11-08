<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit;
    }

    require('./api/sql.php');
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
    <a href="panel.php">Panel</a>
    <a class="active" href="grades.php">Oceny</a>
    <a href="attendance.php">Frekwencja</a>
    <a href="timetable.php">Plan lekcji</a>
    <a href="#">Sprawdziany</a>
    <a href="#">Wydarzenia</a>
    <a href="#">Tematy</a>
</nav>
<section>
    <h1 class="grades">Oceny</h1>
    <div>
        <table class="grades_table">
            <tr class="table_top">
                <th>Przedmiot</th>
                <td><b>Oceny</b></td>
            </tr>
            <?php // Całe generowanie tablel z ocenami
                $conn = mysqli_connect(CONN['host'], CONN['user'], CONN['password'], CONN['database']);
                mysqli_set_charset($conn, CONN['charset']);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $subject = array();

                $result1 = mysqli_query($conn, "SELECT `subject`.* FROM `subject`;");

                $polski = array();
                $result2 = mysqli_query($conn, "SELECT * FROM `grades` WHERE `subject_id`=3 AND `students_id`=601;");
                while ($row2 = mysqli_fetch_array($result2)) {
                    array_push($polski, $row2['grade']);
                }
                mysqli_free_result($result2);

                $angielski = array();
                $result3 = mysqli_query($conn, "SELECT * FROM `grades` WHERE `subject_id`=4 AND `students_id`=601;");
                while ($row3 = mysqli_fetch_array($result3)) {
                    array_push($angielski, $row3['grade']);
                }
                mysqli_free_result($result3);

                $niemiecki = array();
                $result4 = mysqli_query($conn, "SELECT * FROM `grades` WHERE `subject_id`=5 AND `students_id`=601;");
                while ($row4 = mysqli_fetch_array($result4)) {
                    echo $row4['grade'];
                    array_push($niemiecki, $row4['grade']);
                }
                mysqli_free_result($result4);

                $matematyka = array();
                $result5 = mysqli_query($conn, "SELECT * FROM `grades` WHERE `subject_id`=6 AND `students_id`=601;");
                while ($row5 = mysqli_fetch_array($result5)) {
                    echo $row5['grade'];
                    array_push($matematyka, $row5['grade']);
                }
                mysqli_free_result($result5);

                $informatyka = array();
                $result6 = mysqli_query($conn, "SELECT * FROM `grades` WHERE `subject_id`=7 AND `students_id`=601;");
                while ($row6 = mysqli_fetch_array($result6)) {
                    echo $row6['grade'];
                    array_push($informatyka, $row6['grade']);
                }
                mysqli_free_result($result6);

                $historia = array();
                $result7 = mysqli_query($conn, "SELECT * FROM `grades` WHERE `subject_id`=8 AND `students_id`=601;");
                while ($row7 = mysqli_fetch_array($result7)) {
                    echo $row7['grade'];
                    array_push($historia, $row7['grade']);
                }
                mysqli_free_result($result7);

                $hit = array();
                $result8 = mysqli_query($conn, "SELECT * FROM `grades` WHERE `subject_id`=9 AND `students_id`=601;");
                while ($row8 = mysqli_fetch_array($result8)) {
                    echo $row8['grade'];
                    array_push($hit, $row8['grade']);
                }
                mysqli_free_result($result8);

                $wf = array();
                $result9 = mysqli_query($conn, "SELECT * FROM `grades` WHERE `subject_id`=10 AND `students_id`=601;");
                while ($row9 = mysqli_fetch_array($result9)) {
                    echo $row9['grade'];
                    array_push($wf, $row9['grade']);
                }
                mysqli_free_result($result9);

                $muzyka = array();
                $result10 = mysqli_query($conn, "SELECT * FROM `grades` WHERE `subject_id`=11 AND `students_id`=601;");
                while ($row10 = mysqli_fetch_array($result10)) {
                    echo $row10['grade'];
                    array_push($muzyka, $row10['grade']);
                }
                mysqli_free_result($result10);

                $plastyka = array();
                $result11 = mysqli_query($conn, "SELECT * FROM `grades` WHERE `subject_id`=12 AND `students_id`=601;");
                while ($row11 = mysqli_fetch_array($result11)) {
                    echo $row11['grade'];
                    array_push($plastyka, $row11['grade']);
                }
                mysqli_free_result($result11);

                $biologia = array();
                $result12 = mysqli_query($conn, "SELECT * FROM `grades` WHERE `subject_id`=13 AND `students_id`=601;");
                while ($row12 = mysqli_fetch_array($result12)) {
                    echo $row12['grade'];
                    array_push($biologia, $row12['grade']);
                }
                mysqli_free_result($result12);

                $geografia = array();
                $result13 = mysqli_query($conn, "SELECT * FROM `grades` WHERE `subject_id`=14 AND `students_id`=601;");
                while ($row13 = mysqli_fetch_array($result13)) {
                    echo $row13['grade'];
                    array_push($geografia, $row13['grade']);
                }
                mysqli_free_result($result13);

                $chemia = array();
                $result14 = mysqli_query($conn, "SELECT * FROM `grades` WHERE `subject_id`=15 AND `students_id`=601;");
                while ($row14 = mysqli_fetch_array($result14)) {
                    echo $row14['grade'];
                    array_push($geografia, $row14['grade']);
                }
                mysqli_free_result($result14);

                if (mysqli_num_rows($result1) > 0) {
                    while ($row1 = mysqli_fetch_array($result1)) {
                        echo "<tr>";
                        echo "<th>" . $row1['name'] . "</th>";
                        array_push($subject, $row1['name']);
                        switch ($row1['name']) {
                            case "Język polski":
                                echo "<td>";
                                for ($i=0; $i < count($polski); $i++) { 
                                    echo $polski[$i] . ", ";
                                }
                                echo "</td>";
                                break;
                            case "Język angielski":
                                echo "<td>";
                                for ($i=0; $i < count($angielski); $i++) { 
                                    echo $angielski[$i] . ", ";
                                }
                                echo "</td>";
                                break;
                            case "Język niemiecki":
                                echo "<td>";
                                for ($i=0; $i < count($niemiecki); $i++) { 
                                    echo $niemiecki[$i] . ", ";
                                }
                                echo "</td>";
                                break;
                            case "Matematyka":
                                echo "<td>";
                                for ($i=0; $i < count($matematyka); $i++) { 
                                    echo $matematyka[$i] . ", ";
                                }
                                echo "</td>";
                                break;
                            case "Informatyka":
                                echo "<td>";
                                for ($i=0; $i < count($informatyka); $i++) { 
                                    echo $informatyka[$i] . ", ";
                                }
                                echo "</td>";
                                break;
                            case "Historia":
                                echo "<td>";
                                for ($i=0; $i < count($historia); $i++) { 
                                    echo $historia[$i] . ", ";
                                }
                                echo "</td>";
                                break;
                            case "Historia i teraźniejszość":
                                echo "<td>";
                                for ($i=0; $i < count($hit); $i++) { 
                                    echo $hit[$i] . ", ";
                                }
                                echo "</td>";
                                break;
                            case "Wychowanie fizyczne":
                                echo "<td>";
                                for ($i=0; $i < count($wf); $i++) { 
                                    echo $wf[$i] . ", ";
                                }
                                echo "</td>";
                                break;
                            case "Muzyka":
                                echo "<td>";
                                for ($i=0; $i < count($muzyka); $i++) { 
                                    echo $muzyka[$i] . ", ";
                                }
                                echo "</td>";
                                break;
                            case "Plastyka":
                                echo "<td>";
                                for ($i=0; $i < count($plastyka); $i++) { 
                                    echo $plastyka[$i] . ", ";
                                }
                                echo "</td>";
                                break;
                            case "Biologia":
                                echo "<td>";
                                for ($i=0; $i < count($biologia); $i++) { 
                                    echo $biologia[$i] . ", ";
                                }
                                echo "</td>";
                                break;
                            case "Geografia":
                                echo "<td>";
                                for ($i=0; $i < count($geografia); $i++) { 
                                    echo $geografia[$i] . ", ";
                                }
                                echo "</td>";
                                break;
                            case "Chemia":
                                echo "<td>";
                                for ($i=0; $i < count($chemia); $i++) { 
                                    echo $chemia[$i] . ", ";
                                }
                                echo "</td>";
                                break;
                        };
                    }
                } else {
                    die("Nie udało się odczytać danych");
                }
                mysqli_free_result($result1);
            ?>
        </table>
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