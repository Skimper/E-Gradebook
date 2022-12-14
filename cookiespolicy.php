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
    <title>Polityka plik??w cookie</title>

    <link rel="canonical" href="https://iiproject.ddns.net" />

    <meta name="language" content="pl" />
    <meta name="title" content="Dziennik elektroniczny" />
    <meta name="description" content="Dziennik elektroniczny dla szk???? ponadpodstawowych." />

    <meta name="author" content="Kacper Kostera, skimpertm@o2.pl, Skimper" />
    <meta name="copyright" content="Copyright &copy; 2022 by Kacper Kostera" />
    <meta name="keywords" content="dziennik, elektroniczny, szko??a" />
    <meta name="subject" content="Dziennik elektroniczny" />
    <meta name="revisit-after" content="1 days" />

    <link rel="icon" href="./img/browser/icon180.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="img/browser/icon180.ico" type="image/x-icon" />

    <meta property="og:url" content="https://iiproject.ddns.net" />
    <meta property="og:title" content="E-Dziennik" />
    <meta name="og:site_name" content="Dziennik elektroniczny" />
    <meta name="og:type" content="website" />
    <meta name="og:description" content="Zaloguj si?? do panelu" />
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
    <script src="./js/profile.js"></script>

    <script src="./js/accessibility.js"></script>
    <script src="./js/theme.js"></script>

    <noscript>
        <div class="noscript"> 
            <p>Aby dziennik m??g?? dzia??a?? poprawnie, wymagana jest obs??uga JavaScript.</p>
            <a class="tutorial" target="_blank" href="https://www.geeksforgeeks.org/how-to-enable-javascript-in-my-browser/">W przypadku problem??w skorzystaj z tego poradnika!</a>
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
        <img alt="Twoje zdj??cie profilowe" src="./profile/<?php if(is_readable('./profile/'.$_SESSION['id'] . '.jpeg')) {echo $_SESSION['id'];} else {echo "default";} ?>.jpeg" class="avatar"></img>
        <p><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></p>
        <p><?php echo $_SESSION['class']; ?></p>
        <div class="logout_holder" onclick="window.location.href='panel.php?action=logout'">
            <img class="logout" alt="Wyloguj si??" src="./img/icons/<?php echo ($_SESSION['color'] == '2') ? '0' : $_SESSION['color'];?>/shutdown_switch_icon.png">
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
        <h1 class="grades">Polityka plik??w cookie</h1>
    </header>
    <div class="cookies_policy">
    <div class="cookies_policy">
        <h1>Polityka plik??w cookie dla IIProject</h1>

        <p>To jest Polityka plik??w cookie dla IIProject, dost??pna pod iiproject.ddns.net</p>

        <p><strong>Czym s?? pliki cookie</strong></p>

        <p>Zgodnie z powszechn?? praktyk?? w przypadku prawie wszystkich profesjonalnych stron internetowych, ta strona u??ywa plik??w cookie, kt??re s?? ma??ymi plikami pobieranymi na komputer, aby poprawi?? Twoje wra??enia. Na tej stronie opisano, jakie informacje gromadz??, w jaki spos??b je wykorzystujemy i dlaczego czasami musimy przechowywa?? te pliki cookie. Podzielimy si?? r??wnie?? tym, w jaki spos??b mo??esz zapobiec przechowywaniu tych plik??w cookie, jednak mo??e to obni??y?? lub "zepsu??" niekt??re elementy funkcjonalno??ci witryn.</p>

        <p><strong>Jak u??ywamy plik??w cookie</strong></p>

        <p>U??ywamy plik??w cookie z r????nych powod??w opisanych poni??ej. Niestety w wi??kszo??ci przypadk??w nie ma standardowych w bran??y opcji wy????czania plik??w cookie bez ca??kowitego wy????czenia funkcjonalno??ci i funkcji, kt??re dodaj?? do tej witryny. Zaleca si?? pozostawienie wszystkich plik??w cookie, je??li nie masz pewno??ci, czy ich potrzebujesz, czy nie, na wypadek, gdyby by??y one wykorzystywane do ??wiadczenia us??ugi, z kt??rej korzystasz.</p>

        <p><strong>Wy????czanie plik??w cookie</strong></p>

        <p>Mo??esz zapobiec ustawianiu plik??w cookie, dostosowuj??c ustawienia przegl??darki (zobacz Pomoc przegl??darki, aby dowiedzie?? si??, jak to zrobi??). Nale??y pami??ta??, ??e wy????czenie plik??w cookie wp??ynie na funkcjonalno???? tej i wielu innych stron internetowych, kt??re odwiedzasz. Wy????czenie plik??w cookie zazwyczaj powoduje r??wnie?? wy????czenie niekt??rych funkcji i funkcji tej witryny. Dlatego zaleca si??, aby nie wy????cza?? plik??w cookie. Niniejsza Polityka Cookies zosta??a stworzona za pomoc?? <a href="https://www.cookiepolicygenerator.com/cookie-policy-generator/" _istranslated="1">Generatora Polityki Cookies</a>.</p>
        <p><strong>Pliki cookie, kt??re ustawiamy</strong></p>

        <ul>
            <li>
                <p>Pliki cookie zwi??zane z kontem</p>
                <p>Je??li utworzysz u nas konto, u??yjemy plik??w cookie do zarz??dzania procesem rejestracji i og??lnej administracji. Te pliki cookie s?? zazwyczaj usuwane po wylogowaniu, jednak w niekt??rych przypadkach mog?? pozosta?? p????niej, aby zapami??ta?? preferencje witryny po wylogowaniu.</p>
            </li>

            <li>
                <p>Pliki cookie zwi??zane z logowaniem</p>
                <p>U??ywamy plik??w cookie, gdy jeste?? zalogowany, aby??my mogli zapami??ta?? ten fakt. Dzi??ki temu nie musisz logowa?? si?? za ka??dym razem, gdy odwiedzasz now?? stron??. Te pliki cookie s?? zazwyczaj usuwane lub czyszczone po wylogowaniu, aby zapewni?? dost??p do ograniczonych funkcji i obszar??w tylko po zalogowaniu.</p>
            </li>

            <li>
                <p">Pliki cookie zwi??zane z formularzami</p>
                <p>Kiedy przesy??asz dane za po??rednictwem formularza, takiego jak te znajduj??ce si?? na stronach kontaktowych lub formularzach komentarzy, pliki cookie mog?? by?? ustawione tak, aby zapami??ta?? Twoje dane u??ytkownika do przysz??ej korespondencji.</p>
            </li>

            <li>
                <p>Pliki cookie preferencji witryny</p>
                <p>Aby zapewni?? Ci wspania??e wra??enia z korzystania z tej witryny, zapewniamy funkcjonalno???? ustawienia preferencji dotycz??cych sposobu dzia??ania tej witryny podczas korzystania z niej. Aby zapami??ta?? Twoje preferencje, musimy ustawi?? pliki cookie, aby te informacje mog??y by?? wywo??ywane za ka??dym razem, gdy interakcja ze stron?? jest zale??na od Twoich preferencji.</p>
            </li>
        </ul>

        <p><strong>Pliki cookie stron trzecich</strong></p>

        <p>W niekt??rych szczeg??lnych przypadkach u??ywamy r??wnie?? plik??w cookie dostarczanych przez zaufane strony trzecie. Poni??sza sekcja zawiera szczeg????owe informacje na temat plik??w cookie stron trzecich, kt??re mo??na napotka?? za po??rednictwem tej witryny.</p>

        <ul>
            <li>
                <p>Od czasu do czasu testujemy nowe funkcje i wprowadzamy subtelne zmiany w sposobie dostarczania witryny. Gdy wci???? testujemy nowe funkcje, te pliki cookie mog?? by?? wykorzystywane w celu zapewnienia sp??jnego do??wiadczenia podczas korzystania z witryny, jednocze??nie upewniaj??c si??, ??e rozumiemy, kt??re optymalizacje nasi u??ytkownicy doceniaj?? najbardziej.</p>
            </li>
        </ul>

        <p><strong>Wi??cej informacji</strong></p>

        <p>Mamy nadziej??, ??e to wyja??ni??o Ci sprawy i, jak wspomniano wcze??niej, je??li jest co??, czego nie jeste?? pewien, czy potrzebujesz, czy nie, zwykle bezpieczniej jest pozostawi?? w????czone pliki cookie na wypadek, gdyby wchodzi??y w interakcj?? z jedn?? z funkcji, z kt??rych korzystasz na naszej stronie.</p>

        <p>Aby uzyska?? wi??cej og??lnych informacji na temat plik??w cookie, <a href="https://www.cookiepolicygenerator.com/sample-cookies-policy/">przeczytaj artyku?? Polityka plik??w cookie</a>.</p>

        <p>Je??li jednak nadal szukasz wi??cej informacji, mo??esz skontaktowa?? si?? z nami za pomoc?? jednej z naszych preferowanych metod kontaktu:</p>

        <ul>
            <li>E-mail: </li>
            <li>Odwiedzaj??c ten link: </li>
        </ul>
    </div>
    </div>
</section>
<script src="./js/keyborad.js"></script>
</body>
</html>