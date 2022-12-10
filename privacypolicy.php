<?php
    session_start();

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>

    <link rel="stylesheet" href="./styles/normalize.css" type="text/css">
    <link rel="stylesheet" href="./styles/webkit.css" type="text/css">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="./js/profile.js"></script>

    <script src="./js/accessibility.js"></script>
    <script src="./js/theme.js"></script>

    <script>
        if(typeof window.history.pushState == 'function') {
            window.history.pushState({}, "Hide", "privacypolicy.php");
        }
    </script>
    
    <noscript>
        <div class="noscript"> 
            <p>Aby dziennik mógł działać poprawnie, wymagana jest obsługa JavaScript.</p>
            <a class="tutorial" target="_blank" href="https://www.geeksforgeeks.org/how-to-enable-javascript-in-my-browser/">W przypadku problemów skorzystaj z tego poradnika!</a>
        </div>
    </noscript>
</head>
<body>
<script>
    accessibilityContrast(<?php echo $_SESSION['contrast']; ?>);
    setColor(<?php echo $_SESSION['color']; ?>);
    setTheme(<?php echo $_SESSION['theme']; ?>);
    accessibilityFont(<?php echo $_SESSION['font']; ?>);
</script>
<nav class="sidenav">
    <div class="profile">
        <img alt="Twoje zdjęcie profilowe" src="./img/avatar.jpeg" class="avatar"></img>
        <p><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></p>
        <p><?php echo $_SESSION['class']; ?></p>
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
        <h1 class="grades">Polityka prywatności</h1>
    </header>
    <div class="privacy_policy">
        <h1>Polityka prywatności dla IIProject.ddns.net</h1>

        <p>W IIProject, dostępnym z IIProject.ddns.net, jednym z naszych głównych priorytetów jest prywatność naszych gości i użytkowników. Niniejszy dokument Polityki Prywatności zawiera rodzaje informacji, które są gromadzone i rejestrowane przez IIProject oraz sposób, w jaki je wykorzystujemy.</p>

        <p>Jeśli masz dodatkowe pytania lub potrzebujesz więcej informacji na temat naszej Polityki prywatności, nie wahaj się z nami skontaktować.</p>

        <p>Niniejsza Polityka prywatności dotyczy wyłącznie naszych działań online i jest ważna dla odwiedzających naszą stronę internetową w odniesieniu do informacji, które udostępnili i / lub zbierają w IIProject. Niniejsza polityka nie ma zastosowania do żadnych informacji gromadzonych offline lub za pośrednictwem kanałów innych niż ta strona internetowa. Nasza Polityka prywatności została stworzona za pomocą <a href="https://www.privacypolicygenerator.info/" _istranslated="1">Generatora Bezpłatnej Polityki Prywatności</a>.</p>
        
        <h2>Zgoda</h2>
        
        <p>Korzystając z naszej strony internetowej, niniejszym wyrażasz zgodę na naszą Politykę prywatności i zgadzasz się na jej warunki.</p>
        
        <h2>Informacje, które zbieramy</h2>
        
        <p>Dane osobowe, o których podanie jesteś proszony, oraz powody, dla których jesteś proszony o ich podanie, zostaną wyjaśnione w momencie, w którym poprosimy Cię o podanie danych osobowych.</p>
        <p>Jeśli skontaktujesz się z nami bezpośrednio, możemy otrzymać dodatkowe informacje o Tobie, takie jak imię i nazwisko, adres e-mail, numer telefonu, treść wiadomości i / lub załączników, które możesz nam wysłać, oraz wszelkie inne informacje, które możesz podać.</p>
        <p>Kiedy rejestrujesz Konto, możemy poprosić Cię o podanie danych kontaktowych, w tym takich elementów, jak imię i nazwisko, nazwa firmy, adres, adres e-mail i numer telefonu.</p>
        
        <h2>W jaki sposób wykorzystujemy Twoje dane</h2>
        
        <p>Wykorzystujemy gromadzone informacje na różne sposoby, w tym w celu:</p>
        
        <ul>
        <li>Dostarczanie, obsługa i utrzymanie naszej strony internetowej</li>
        <li>Ulepszanie, personalizowanie i rozszerzanie naszej strony internetowej</li>
        <li>Zrozum i przeanalizuj sposób, w jaki korzystasz z naszej strony internetowej</li>
        <li>Opracowywanie nowych produktów, usług, funkcji i funkcjonalności</li>
        <li>Komunikowania się z Tobą, bezpośrednio lub za pośrednictwem jednego z naszych partnerów, w tym w celu obsługi klienta, w celu dostarczania aktualizacji i innych informacji związanych ze stroną internetową oraz w celach marketingowych i promocyjnych</li>
        <li>Wysyłanie e-maili</li>
        <li>Znajdowanie oszustw i zapobieganie im</li>
        </ul>
        
        <h2>Pliki dziennika</h2>
        
        <p>IIProject postępuje zgodnie ze standardową procedurą korzystania z plików dziennika. Pliki te rejestrują odwiedzających, gdy odwiedzają strony internetowe. Wszystkie firmy hostingowe robią to i część analityki usług hostingowych. Informacje gromadzone przez pliki dziennika obejmują adresy protokołu internetowego (IP), typ przeglądarki, dostawcę usług internetowych (ISP), znacznik daty i godziny, strony odsyłające / wyjściowe i ewentualnie liczbę kliknięć. Nie są one powiązane z żadnymi informacjami umożliwiającymi identyfikację osób. Celem informacji jest analiza trendów, administrowanie witryną, śledzenie ruchu użytkowników na stronie internetowej i zbieranie informacji demograficznych.</p>
        
        <h2>Pliki cookie i sygnały nawigacyjne w sieci Web</h2>
        
        <p>Jak każda inna strona internetowa, IIProject używa plików cookie. Te pliki cookie służą do przechowywania informacji, w tym preferencji odwiedzających oraz stron w witrynie, do których użytkownik uzyskał dostęp lub które odwiedził. Informacje te są wykorzystywane do optymalizacji doświadczeń użytkowników poprzez dostosowanie zawartości naszej strony internetowej w oparciu o typ przeglądarki odwiedzających i / lub inne informacje.</p>
        
        
        
        <h2>Polityka prywatności partnerów reklamowych</h2>
        
        <p>Możesz zapoznać się z tą listą, aby znaleźć Politykę prywatności dla każdego z partnerów reklamowych IIProject.</p>
        
        <p>Zewnętrzne serwery reklamowe lub sieci reklamowe wykorzystują technologie takie jak pliki cookie, JavaScript lub sygnały nawigacyjne, które są używane w odpowiednich reklamach i linkach pojawiających się na IIProject, które są wysyłane bezpośrednio do przeglądarki użytkownika. Automatycznie otrzymują Twój adres IP, gdy to nastąpi. Technologie te są wykorzystywane do pomiaru skuteczności kampanii reklamowych i / lub personalizacji treści reklamowych, które widzisz na odwiedzanych stronach internetowych.</p>
        
        <p>Należy pamiętać, że IIProject nie ma dostępu ani kontroli nad tymi plikami cookie, które są używane przez reklamodawców zewnętrznych.</p>
        
        <h>Polityka prywatności stron trzecich</h2>
        
        <p>Polityka prywatności IIProject nie ma zastosowania do innych reklamodawców lub stron internetowych. W związku z tym zalecamy zapoznanie się z odpowiednimi Politykami prywatności tych zewnętrznych serwerów reklamowych w celu uzyskania bardziej szczegółowych informacji. Może to obejmować ich praktyki i instrukcje dotyczące rezygnacji z niektórych opcji. </p>
        
        <p>Możesz wyłączyć pliki cookie za pomocą indywidualnych opcji przeglądarki. Aby uzyskać bardziej szczegółowe informacje na temat zarządzania plikami cookie w określonych przeglądarkach internetowych, można je znaleźć na stronach internetowych poszczególnych przeglądarek.</p>
        
        <h2>Prawa do prywatności CCPA (nie sprzedawaj moich danych osobowych)</h2>
        
        <p>Zgodnie z CCPA, między innymi, konsumenci w Kalifornii mają prawo do:</p>
        <p>Zażądaj, aby firma, która zbiera dane osobowe konsumenta, ujawniła kategorie i konkretne dane osobowe, które firma zebrała na temat konsumentów.</p>
        <p>Zażądaj od firmy usunięcia wszelkich danych osobowych konsumenta, które zebrała firma.</p>
        <p>Zażądaj, aby firma, która sprzedaje dane osobowe konsumenta, nie sprzedawała danych osobowych konsumenta.</p>
        <p>Jeśli złożysz wniosek, mamy miesiąc na odpowiedź. Jeśli chcesz skorzystać z któregokolwiek z tych praw, skontaktuj się z nami.</p>
        
        <h2>Prawa do ochrony danych RODO</h2>
        
        <p>Chcielibyśmy mieć pewność, że jesteś w pełni świadomy wszystkich swoich praw do ochrony danych. Każdy użytkownik ma prawo do:</p>
        <p>Prawo dostępu – Masz prawo zażądać kopii swoich danych osobowych. Możemy pobrać niewielką opłatę za tę usługę.</p>
        <p>Prawo do sprostowania – Masz prawo zażądać od nas poprawienia wszelkich informacji, które uważasz za niedokładne. Masz również prawo zażądać od nas uzupełnienia informacji, które uważasz za niekompletne.</p>
        <p>Prawo do usunięcia – Masz prawo zażądać usunięcia Twoich danych osobowych pod pewnymi warunkami.</p>
        <p>Prawo do ograniczenia przetwarzania – Masz prawo zażądać ograniczenia przetwarzania Twoich danych osobowych, pod pewnymi warunkami.</p>
        <p>Prawo do sprzeciwu wobec przetwarzania – Masz prawo sprzeciwić się przetwarzaniu przez nas Twoich danych osobowych, pod pewnymi warunkami.</p>
        <p>Prawo do przenoszenia danych – Masz prawo zażądać od nas przeniesienia zebranych przez nas danych do innej organizacji lub bezpośrednio do Ciebie, pod pewnymi warunkami.</p>
        <p>Jeśli złożysz wniosek, mamy miesiąc na odpowiedź. Jeśli chcesz skorzystać z któregokolwiek z tych praw, skontaktuj się z nami.</p>
        
        <h2>Informacje dla dzieci</h2>
        
        <p>Kolejną częścią naszego priorytetu jest dodanie ochrony dzieci podczas korzystania z Internetu. Zachęcamy rodziców i opiekunów do obserwowania, uczestniczenia i/lub monitorowania i kierowania ich aktywnością online.</p>
        
        <p>IIProject nie zbiera świadomie żadnych danych osobowych od dzieci poniżej 13 roku życia. Jeśli uważasz, że Twoje dziecko podało tego rodzaju informacje na naszej stronie internetowej, gorąco zachęcamy do natychmiastowego skontaktowania się z nami, a my dołożymy wszelkich starań, aby niezwłocznie usunąć takie informacje z naszych rejestrów.</p>
    </div>
</section>
<script src="./js/keyborad.js"></script>
</body>
</html>