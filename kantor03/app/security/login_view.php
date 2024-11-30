<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Logowanie</title>
    <!-- Wczytanie wspólnego pliku CSS -->
    <link rel="stylesheet" href="<?php echo _APP_URL; ?>/assets/css/main.css" />
    <style>
        /* Style specyficzne dla strony logowania */
        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-direction: column; /* Ustawienie formularzy jeden pod drugim */
            gap: 2em;
            height: 100vh;
            background: #f4f4f4;
            padding: 2em;
        }

        .form-container {
            background: white;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 auto;
        }

        .form-container h2 {
            margin-bottom: 1em;
            text-align: center;
        }

        .form-container input[type="text"],
        .form-container input[type="password"],
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Zmiana koloru przycisku logowania */
        .form-container input[type="submit"] {
            background-color: #FF8888; /* Kolor przycisku */
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container input[type="submit"]:hover {
            background-color: #FF6666; /* Ciemniejszy odcień po najechaniu */
        }

        /* Zmiana koloru przycisku wylogowania */
        .logged-in-info a {
            background-color: #28a745; /* Zielony kolor */
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
        }

        .logged-in-info a:hover {
            background-color: #218838; /* Ciemniejszy zielony po najechaniu */
        }

        .error-messages {
            padding: 10px;
            margin: 20px 0;
            background-color: #f88;
            border-radius: 5px;
            color: #fff;
            width: 250px; /* Zwężenie szerokości */
            text-align: left;
        }
    </style>
</head>
<body class="homepage is-preload">
    <div class="container">
        <!-- Formularz logowania -->
        <div class="form-container">
            <h2>Logowanie</h2>
            <form action="<?php print(_APP_ROOT); ?>/app/security/login.php" method="post">
                <fieldset>
                    <label for="id_login">Login:</label>
                    <input id="id_login" type="text" name="login" value="<?php out($form['login']); ?>" />

                    <label for="id_pass">Hasło:</label>
                    <input id="id_pass" type="password" name="pass" />
                </fieldset>
                <input type="submit" value="Zaloguj" class="pure-button pure-button-primary" />
            </form>

            <?php
            // Wyświetlenie listy błędów, jeśli istnieją
            if (isset($messages)) {
                if (count($messages) > 0) {
                    echo '<div class="error-messages">';
                    foreach ($messages as $msg) {
                        echo '<p>' . htmlspecialchars($msg) . '</p>';
                    }
                    echo '</div>';
                }
            }
            ?>
        </div>

        <!-- Jeśli użytkownik jest zalogowany -->
        <?php if (isset($_SESSION['user'])) { ?>
            <div class="form-container">
                <div class="logged-in-info">
                    <p>Jesteś zalogowany jako: <span><?php echo htmlspecialchars($_SESSION['user']); ?></span></p>
                    <a href="logout.php" class="pure-button pure-button-primary">Wyloguj się</a>
                </div>
            </div>
        <?php } ?>
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
