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

    function ChangeAvatar() {
        
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
            UPDATE `users_students` SET `password` = '".$newpassc."' WHERE `users_students`.`students_id` = ".$_SESSION['id'].";
            ");
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
    <title>Polityka plików cookie</title>

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
        <h1 class="grades">Polityka plików cookie</h1>
    </header>
    <div class="cookies_policy">
    <div class="cookies_policy">
        <h1>Polityka plików cookie dla IIProject</h1>

        <p>To jest Polityka plików cookie dla IIProject, dostępna pod iiproject.ddns.net</p>

        <p><strong>Czym są pliki cookie</strong></p>

        <p>Zgodnie z powszechną praktyką w przypadku prawie wszystkich profesjonalnych stron internetowych, ta strona używa plików cookie, które są małymi plikami pobieranymi na komputer, aby poprawić Twoje wrażenia. Na tej stronie opisano, jakie informacje gromadzą, w jaki sposób je wykorzystujemy i dlaczego czasami musimy przechowywać te pliki cookie. Podzielimy się również tym, w jaki sposób możesz zapobiec przechowywaniu tych plików cookie, jednak może to obniżyć lub "zepsuć" niektóre elementy funkcjonalności witryn.</p>

        <p><strong>Jak używamy plików cookie</strong></p>

        <p>Używamy plików cookie z różnych powodów opisanych poniżej. Niestety w większości przypadków nie ma standardowych w branży opcji wyłączania plików cookie bez całkowitego wyłączenia funkcjonalności i funkcji, które dodają do tej witryny. Zaleca się pozostawienie wszystkich plików cookie, jeśli nie masz pewności, czy ich potrzebujesz, czy nie, na wypadek, gdyby były one wykorzystywane do świadczenia usługi, z której korzystasz.</p>

        <p><strong>Wyłączanie plików cookie</strong></p>

        <p>Możesz zapobiec ustawianiu plików cookie, dostosowując ustawienia przeglądarki (zobacz Pomoc przeglądarki, aby dowiedzieć się, jak to zrobić). Należy pamiętać, że wyłączenie plików cookie wpłynie na funkcjonalność tej i wielu innych stron internetowych, które odwiedzasz. Wyłączenie plików cookie zazwyczaj powoduje również wyłączenie niektórych funkcji i funkcji tej witryny. Dlatego zaleca się, aby nie wyłączać plików cookie. Niniejsza Polityka Cookies została stworzona za pomocą <a href="https://www.cookiepolicygenerator.com/cookie-policy-generator/" _istranslated="1">Generatora Polityki Cookies</a>.</p>
        <p><strong>Pliki cookie, które ustawiamy</strong></p>

        <ul>
            <li>
                <p>Pliki cookie związane z kontem</p>
                <p>Jeśli utworzysz u nas konto, użyjemy plików cookie do zarządzania procesem rejestracji i ogólnej administracji. Te pliki cookie są zazwyczaj usuwane po wylogowaniu, jednak w niektórych przypadkach mogą pozostać później, aby zapamiętać preferencje witryny po wylogowaniu.</p>
            </li>

            <li>
                <p>Pliki cookie związane z logowaniem</p>
                <p>Używamy plików cookie, gdy jesteś zalogowany, abyśmy mogli zapamiętać ten fakt. Dzięki temu nie musisz logować się za każdym razem, gdy odwiedzasz nową stronę. Te pliki cookie są zazwyczaj usuwane lub czyszczone po wylogowaniu, aby zapewnić dostęp do ograniczonych funkcji i obszarów tylko po zalogowaniu.</p>
            </li>

            <li>
                <p">Pliki cookie związane z formularzami</p>
                <p>Kiedy przesyłasz dane za pośrednictwem formularza, takiego jak te znajdujące się na stronach kontaktowych lub formularzach komentarzy, pliki cookie mogą być ustawione tak, aby zapamiętać Twoje dane użytkownika do przyszłej korespondencji.</p>
            </li>

            <li>
                <p>Pliki cookie preferencji witryny</p>
                <p>Aby zapewnić Ci wspaniałe wrażenia z korzystania z tej witryny, zapewniamy funkcjonalność ustawienia preferencji dotyczących sposobu działania tej witryny podczas korzystania z niej. Aby zapamiętać Twoje preferencje, musimy ustawić pliki cookie, aby te informacje mogły być wywoływane za każdym razem, gdy interakcja ze stroną jest zależna od Twoich preferencji.</p>
            </li>
        </ul>

        <p><strong>Pliki cookie stron trzecich</strong></p>

        <p>W niektórych szczególnych przypadkach używamy również plików cookie dostarczanych przez zaufane strony trzecie. Poniższa sekcja zawiera szczegółowe informacje na temat plików cookie stron trzecich, które można napotkać za pośrednictwem tej witryny.</p>

        <ul>
            <li>
                <p>Od czasu do czasu testujemy nowe funkcje i wprowadzamy subtelne zmiany w sposobie dostarczania witryny. Gdy wciąż testujemy nowe funkcje, te pliki cookie mogą być wykorzystywane w celu zapewnienia spójnego doświadczenia podczas korzystania z witryny, jednocześnie upewniając się, że rozumiemy, które optymalizacje nasi użytkownicy doceniają najbardziej.</p>
            </li>
        </ul>

        <p><strong>Więcej informacji</strong></p>

        <p>Mamy nadzieję, że to wyjaśniło Ci sprawy i, jak wspomniano wcześniej, jeśli jest coś, czego nie jesteś pewien, czy potrzebujesz, czy nie, zwykle bezpieczniej jest pozostawić włączone pliki cookie na wypadek, gdyby wchodziły w interakcję z jedną z funkcji, z których korzystasz na naszej stronie.</p>

        <p>Aby uzyskać więcej ogólnych informacji na temat plików cookie, <a href="https://www.cookiepolicygenerator.com/sample-cookies-policy/">przeczytaj artykuł Polityka plików cookie</a>.</p>

        <p>Jeśli jednak nadal szukasz więcej informacji, możesz skontaktować się z nami za pomocą jednej z naszych preferowanych metod kontaktu:</p>

        <ul>
            <li>E-mail: </li>
            <li>Odwiedzając ten link: </li>
        </ul>
    </div>
    </div>
</section>
<script src="./js/keyborad.js"></script>
</body>
</html>