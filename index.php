<?php
    session_start();

    if (isset($_SESSION['loggedin'])) {
        header('Location: panel.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,  user-scalable=no">
    <title>Logowanie</title>

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

    <link rel="stylesheet" href="./styles/normalize.css" type="text/css" />
    <link rel="stylesheet" href="./styles/webkit.css" type="text/css" />
    <link rel="stylesheet" href="./styles/style.css" type="text/css" />

    <script src="./js/accessibility.js"></script>
    <script src="./js/theme.js"></script>

    <noscript>
        <div class="noscript"> 
            <p>Aby dziennik mógł działać poprawnie, wymagana jest obsługa JavaScript.</p>
            <a class="tutorial" target="_blank" href="https://www.geeksforgeeks.org/how-to-enable-javascript-in-my-browser/">W przypadku problemów skorzystaj z tego poradnika!</a>
        </div>
    </noscript>
</head>
<body style="margin-left: -200px;">
<script>
    accessibilityContrast(<?php if(isset($_COOKIE['contrast'])) echo $_COOKIE['contrast']; ?>);
    setColor(<?php if(isset($_COOKIE['color'])) echo $_COOKIE['color']; ?>);
    setTheme(<?php if(isset($_COOKIE['theme'])) echo $_COOKIE['theme']; ?>);
    accessibilityFont(<?php if(isset($_COOKIE['font'])) echo $_COOKIE['font']; ?>);
</script>
    <header>
        <img class="logo_img" src="">
        <h1>ZALOGU SIĘ DO DZIENIKA</h1>
    </header>
    <div class="login_panel">
        <form class="login_form" method="post" action="">
            <label class="login_label" for="username">Adres e-mail lub nazwa użytkownika</label><br />
            <input class="login_input" type="text" name="username" minlength="3" maxlength="64" required><br /><br />
            <label class="login_label" for="password">Hasło</label><br />
            <input class="login_input" type="password" name="password" minlength="3" maxlength="64" required><br /><br />
            
            <div class="buttons">
                <input label="Uczeń" type="radio" name="type" value="student" checked>
                <input label="Nauczyciel" type="radio" name="type" value="teacher">
            </div>
            
            <button class="login_button" type="submit">Zaloguj</button>
        </form>
        <p>
            <?php
                if ( isset($_POST['username']) && isset($_POST['password']) && isset($_POST['type']) ) {
                    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
                    $password = hash('sha256', htmlspecialchars($_POST['password'], ENT_QUOTES));
                    Login($username, $password);
                }
            
                function Login($email, $password) {
                    $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
                    mysqli_set_charset($conn, DB['charset']);

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                
                    switch ($_POST['type']){
                        case "student":
                            $result = mysqli_query($conn, "
                            SELECT `users_students`.*, `students`.`id`, `students`.`classes_id`, `students`.`first_name`, `students`.`last_name`
                            FROM `users_students` 
                                LEFT JOIN `students` ON `users_students`.`students_id` = `students`.`id`
                            WHERE `users_students`.`email` = '".$email."' AND `users_students`.`password` = '".$password."';
                            ");
                            mysqli_close($conn);

                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                if($row['password'] === $password) {
                                    session_regenerate_id();
                                    $_SESSION['loggedin'] = true;
                                    $_SESSION['who'] = "student";
                                    $_SESSION['email'] = $row['email'];
        
                                    $_SESSION['id'] = $row['id'];
                                    $_SESSION['class'] = $row['classes_id'];
                                    $_SESSION['first_name'] = $row['first_name'];
                                    $_SESSION['last_name'] = $row['last_name'];
        
                                    $_SESSION['theme'] = $row['theme'];
                                    $_SESSION['contrast'] = $row['contrast'];
                                    $_SESSION['font'] = $row['font'];
                                    $_SESSION['color'] = $row['color'];
        
                                    $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
                                    mysqli_query($conn, "
                                    UPDATE `users_students` SET `last_login` = '".date("Y-m-d")."', `ip` = '".$_SERVER['REMOTE_ADDR']."' WHERE `users_students`.`students_id` = ".$_SESSION['id']."; 
                                    ");
                                    mysqli_close($conn);
        
                                    setcookie('theme', $_SESSION['theme'], time() + (86400 * 30), "/");
                                    setcookie('contrast', $_SESSION['contrast'], time() + (86400 * 30), "/");
                                    setcookie('font', $_SESSION['font'], time() + (86400 * 30), "/");
                                    setcookie('color', $_SESSION['color'], time() + (86400 * 30), "/");
        
                                    header("Location: panel.php");
                                } else {
                                    die("Błędne hasło!");
                                };
                            } else {
                                echo "Błędny login lub hasło!";
                            }
                        break;
                        case "teacher":
                            $result = mysqli_query($conn, "
                            SELECT `users_teachers`.*, `teachers`.`classes_id`, `teachers`.`Name`
                            FROM `users_teachers` 
                            	LEFT JOIN `teachers` ON `users_teachers`.`teachers_id` = `teachers`.`id`
                            WHERE `users_teachers`.`email` = '".$email."' AND `users_teachers`.`password` = '".$password."';
                            ");
                            mysqli_close($conn);

                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                if($row['password'] === $password) {
                                    session_regenerate_id();
                                    $_SESSION['loggedin'] = true;
                                    $_SESSION['who'] = "teacher";
                                    $_SESSION['email'] = $row['email'];
        
                                    $_SESSION['id'] = $row['teachers_id'];
                                    $_SESSION['class'] = $row['classes_id'];
                                    $_SESSION['Name'] = $row['Name'];
        
                                    $_SESSION['theme'] = $row['theme'];
                                    $_SESSION['contrast'] = $row['contrast'];
                                    $_SESSION['font'] = $row['font'];
                                    $_SESSION['color'] = $row['color'];
        
                                    $conn = mysqli_connect(DB['host'], DB['user'], DB['password'], DB['database']);
                                    mysqli_query($conn, "
                                    UPDATE `users_teachers` SET `last_login` = '".date("Y-m-d")."', `ip` = '".$_SERVER['REMOTE_ADDR']."' WHERE `users_teachers`.`teachers_id` = ".$_SESSION['id']."; 
                                    ");
                                    mysqli_close($conn);
        
                                    setcookie('theme', $_SESSION['theme'], time() + (86400 * 30), "/");
                                    setcookie('contrast', $_SESSION['contrast'], time() + (86400 * 30), "/");
                                    setcookie('font', $_SESSION['font'], time() + (86400 * 30), "/");
                                    setcookie('color', $_SESSION['color'], time() + (86400 * 30), "/");
        
                                    header("Location: teacher/panel.php");
                                } else {
                                    die("Błędne hasło!");
                                };
                            } else {
                                echo "Błędny login lub hasło!";
                            }
                        break;
                        default: break;
                    }
                }
            ?>
        </p>
    </div>
</body>
</html>