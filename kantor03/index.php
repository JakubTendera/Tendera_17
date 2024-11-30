<?php
require_once 'app/calc.php';
require_once 'app/security/check.php'; // Sprawdzanie logowania

$kwota = $kierunek = $kurs = null;
$messages = [];
$wynik = null;

// Pobierz rolę użytkownika z sesji
$role = $_SESSION['role'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kwota = $_POST['kwota'] ?? null;
    $kierunek = $_POST['kierunek'] ?? null;
    $kurs = $_POST['kurs'] ?? null;

    // Walidacja dla użytkownika "user"
    if ($role === 'user' && $kierunek === 'eur_to_pln') {
        $messages[] = "Nie masz uprawnień do przeliczania EUR na PLN.";
    } else {
        $messages = validate($kwota, $kierunek, $kurs);

        if (empty($messages)) {
            $wynik = calculate($kwota, $kierunek, $kurs);
        }
    }
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Kantor HELIOS</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    </head>
    <body class="homepage is-preload">
        <div id="page-wrapper">

            <!-- Header -->
            <div id="header">
                <div class="inner">
                    <header>
                        <h1><a href="index.php" id="logo">HELIOS</a></h1>
                        <hr />
                        <p>Najlepszy kantor pod słońcem</p>
                    </header>
                    <footer>
                        <a href="#banner" class="button circled scrolly">Start</a>
                    </footer>
                </div>
            </div>

            <!-- Banner -->
            <section id="banner">
                <header>
                    <h2>Witamy na stronie kantoru <strong>HELIOS</strong>.</h2>
                </header>
            </section>

            <!-- Logowanie/Wylogowanie -->
            <div style="text-align: right; padding: 10px;">
                <?php if (!empty($_SESSION['role'])) { ?>
                    <span>Zalogowany jako: <?php echo htmlspecialchars($_SESSION['role']); ?></span>
                    <a href="app/security/logout.php" class="button">Wyloguj</a>
                <?php } else { ?>
                    <a href="app/security/login.php" class="button">Zaloguj</a>
                <?php } ?>
            </div>

            <!-- Main -->
            <div class="wrapper style2">
                <article id="main" class="container special">
                    <header>
                        <h2>Kantor wymiany walut</h2>
                        <p>Skorzystaj z naszego kantoru, aby przeliczyć waluty.</p>
                    </header>

                    <!-- Formularz -->
                    <div style="width:100%; margin: 2em auto;">
                        <form action="index.php" method="post">
                            <fieldset>
                                <label for="id_kwota">Kwota: </label>
                                <input id="id_kwota" type="text" name="kwota" value="<?php echo htmlspecialchars($kwota ?? '') ?>" />

                                <label for="id_kierunek">Kierunek przeliczenia: </label>
                                <select name="kierunek" id="id_kierunek">
                                    <option value="pln_to_eur" <?php if ($kierunek == 'pln_to_eur') echo 'selected'; ?>>PLN na EUR</option>
                                    <?php if ($role !== 'user') { ?>
                                        <option value="eur_to_pln" <?php if ($kierunek == 'eur_to_pln') echo 'selected'; ?>>EUR na PLN</option>
                                    <?php } ?>
                                </select>

                                <label for="id_kurs">Kurs wymiany: </label>
                                <input id="id_kurs" type="text" name="kurs" value="<?php echo htmlspecialchars($kurs ?? '') ?>" />
                            </fieldset>
                            <input type="submit" value="Przelicz" class="pure-button pure-button-primary"/>
                        </form>    

                        <?php if (!empty($messages)) { ?>
                            <ol style="color: red;">
                                <?php foreach ($messages as $msg) { ?>
                                    <li><?php echo $msg; ?></li>
                                <?php } ?>
                            </ol>
                        <?php } ?>

                        <?php if (isset($wynik)) { ?>
                            <div style="color: green;">Wynik: <?php echo $wynik; ?></div>
                        <?php } ?>
                    </div>
                </article>
            </div>

            <!-- Footer -->
            <div id="footer">
                <div class="container">
                    <section class="contact">
                        <header>
                            <h3>Czytasz treść naszej stopki?</h3>
                        </header>
                        <p>I po co? <br> I tak nic tu nie ma</p>
                    </section>

                    <div class="copyright">
                        <ul class="menu">
                            <li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <!-- Scripts -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.dropotron.min.js"></script>
        <script src="assets/js/jquery.scrolly.min.js"></script>
        <script src="assets/js/jquery.scrollex.min.js"></script>
        <script src="assets/js/browser.min.js"></script>
        <script src="assets/js/breakpoints.min.js"></script>
        <script src="assets/js/util.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>
