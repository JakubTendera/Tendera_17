<?php
require_once dirname(__FILE__) . '/../config.php';

// KONTROLER strony kantoru

// Ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie, gdy użytkownik jest niezalogowany
include _ROOT_PATH . '/app/security/check.php';

// Pobranie parametrów
function getParams(&$kwota, &$kierunek, &$kurs) {
    $kwota = isset($_REQUEST['kwota']) ? $_REQUEST['kwota'] : null;
    $kierunek = isset($_REQUEST['kierunek']) ? $_REQUEST['kierunek'] : null;
    $kurs = isset($_REQUEST['kurs']) ? $_REQUEST['kurs'] : null;
}

// Walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$kwota, &$kierunek, &$kurs, &$messages) {
    // Sprawdzenie, czy parametry zostały przekazane
    if (!isset($kwota) || !isset($kierunek) || !isset($kurs)) {
        return false;
    }

    // Sprawdzenie, czy potrzebne wartości zostały przekazane
    if ($kwota === "") {
        $messages[] = 'Nie podano kwoty do wymiany';
    }
    if ($kurs === "") {
        $messages[] = 'Nie podano kursu wymiany';
    }

    // Nie ma sensu walidować dalej, gdy brak parametrów
    if (count($messages) != 0) return false;

    // Sprawdzenie, czy kwota i kurs są liczbami
    if (!is_numeric($kwota)) {
        $messages[] = 'Kwota nie jest liczbą';
    }
    if (!is_numeric($kurs)) {
        $messages[] = 'Kurs nie jest liczbą';
    }

    // Sprawdzenie, czy kurs nie jest równy 0
    if ($kurs == 0) {
        $messages[] = 'Kurs nie może być równy 0';
    }

    // Sprawdzenie, czy kierunek wymiany jest poprawny
    if (!in_array($kierunek, ['pln_to_eur', 'eur_to_pln'])) {
        $messages[] = 'Nieprawidłowy kierunek wymiany';
    }

    return count($messages) === 0;
}

function process(&$kwota, &$kierunek, &$kurs, &$messages, &$wynik) {
    global $role; // Użycie zmiennej globalnej $role

    // Sprawdzenie, czy kierunek to 'eur_to_pln' i użytkownik nie jest zalogowany
    if ($kierunek == 'eur_to_pln' && $role == 'user') {
        $messages[] = 'Musisz być zalogowany, aby przeliczyć z EUR na PLN';
        return;
    }

    // Przeliczenie z użyciem kursu
    $wynik = $kwota * $kurs; // Obliczenie wyniku
}

// Definicja zmiennych kontrolera
$kwota = null;
$kierunek = null;
$kurs = null;
$wynik = null;
$messages = [];

// Pobierz parametry i wykonaj zadanie, jeśli wszystko w porządku
getParams($kwota, $kierunek, $kurs);
if (validate($kwota, $kierunek, $kurs, $messages)) { // gdy brak błędów
    process($kwota, $kierunek, $kurs, $messages, $wynik);
}

// Wywołanie widoku z przekazaniem zmiennych
include 'calc_view.php';
?>
