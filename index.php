<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>

    <link rel="stylesheet" href="./styles/normalize.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <header>
        <h1>ZALOGU SIĘ DO ...</h1>
    </header>
    <div class="login_panel">
        <form class="login_form" method="post" action="login.php">
            <label class="login_label" for="username">Adres e-mail lub nazwa użytkownika</label><br />
            <input class="login_input" type="text" name="username" minlength="3" maxlength="64" required><br />
            <label class="login_label" for="password">Hasło</label><br />
            <input class="login_input" type="password" name="password" minlength="3" maxlength="64" required><br /><br />
            
            <button class="login_button" type="submit">Zaloguj</button>
        </form>
    </div>
</body>
</html>