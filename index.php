<?php
    session_start();

    if (isset($_SESSION['loggedin'])) {
        header('Location: panel.php');
        exit;
    }

    define('CONN', array('localhost', 'root', '', 'infproject', 'utf8mb4'));
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>

    <link rel="stylesheet" href="./styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="./styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">
</head>
<body>
    <header>
        <img class="logo_img" src="">
        <h1>ZALOGU SIĘ DO ...</h1>
    </header>
    <div class="login_panel">
        <form class="login_form" method="post" action="">
            <label class="login_label" for="username">Adres e-mail lub nazwa użytkownika</label><br />
            <input class="login_input" type="text" name="username" minlength="3" maxlength="64" required><br /><br />
            <label class="login_label" for="password">Hasło</label><br />
            <input class="login_input" type="password" name="password" minlength="3" maxlength="64" required><br /><br />
            
            <button class="login_button" type="submit">Zaloguj</button>
        </form>
        <p>
            <?php
                if ( isset($_POST['username']) && isset($_POST['password']) ) {
                    $username = $_POST['username'];
                    $password = hash('sha256', $_POST['password']);
                    Login($username, $password);
                }
            
                function Login($username, $password) {
                    $conn = mysqli_connect(CONN[0], CONN[1], CONN[2], CONN[3]);
                    mysqli_set_charset($conn, CONN[4]);

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                
                    $result = mysqli_query($conn, "SELECT id, email, username, password, rights FROM users WHERE email='".$username."' OR username='".$username."' AND password='". $password ."';");
                    mysqli_close($conn);
                
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        if($row['password'] === $password) {
                            session_regenerate_id();
                            $_SESSION['loggedin'] = true;
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['id'] = $row['id'];
                            $_SESSION['rights'] = $row['rights'];

                            header("Location: http://localhost/infprojectpage/panel.php");
                        } else {
                            die("Błędne hasło!");
                        };
                    } else {
                        echo "Błędny login lub hasło!";
                    }
                }
            ?>
        </p>
    </div>
</body>
</html>