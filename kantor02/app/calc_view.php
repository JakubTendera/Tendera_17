<?php
// Tu już nie ładujemy konfiguracji - sam widok nie będzie już punktem wejścia do aplikacji.
// Wszystkie żądania idą do kontrolera, a kontroler wywołuje skrypt widoku.
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Kantor wymiany walut</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
<body>

<div style="width:90%; margin: 2em auto;">
    <a href="<?php echo _APP_ROOT; ?>/app/security/<?php echo empty($role) ? 'login.php' : 'logout.php'; ?>" 
       class="pure-button">
       <?php echo empty($role) ? 'Zaloguj się' : 'Wyloguj'; ?>
    </a>
    <a href="<?php echo _APP_ROOT; ?>/app/inna_chroniona.php" class="pure-button">Kolejna chroniona strona</a>
</div>

<div style="width:90%; margin: 2em auto;">
    <form action="<?php echo _APP_ROOT; ?>/app/calc.php" method="post" class="pure-form pure-form-stacked">
        <legend>Kantor - Przeliczanie walut</legend>
        <fieldset>
            <label for="id_kwota">Kwota: </label>
            <input id="id_kwota" type="text" name="kwota" value="<?php echo htmlspecialchars($kwota ?? '') ?>" />

            <label for="id_kierunek">Kierunek przeliczenia: </label>
            <select name="kierunek" id="id_kierunek">
                <option value="pln_to_eur" <?php if ($kierunek == 'pln_to_eur') echo 'selected'; ?>>PLN na EUR</option>
                <?php if (!empty($role)) { ?>
                    <option value="eur_to_pln" <?php if ($kierunek == 'eur_to_pln') echo 'selected'; ?>>EUR na PLN</option>
                <?php } ?>
            </select>

            <!-- Nowe pole do wprowadzenia kursu wymiany -->
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

</body>
</html>
