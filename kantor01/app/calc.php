<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$kwota = $_REQUEST['kwota'] ?? null;
$kurs = $_REQUEST['kurs'] ?? null;
$operation = $_REQUEST['op'] ?? null;

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if (!(isset($kwota) && isset($kurs) && isset($operation))) {
    // sytuacja wystąpi, kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
    $messages[] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ($kwota == "") {
    $messages[] = 'Nie podano kwoty';
}
if ($kurs == "") {
    $messages[] = 'Nie podano kursu';
}

// nie ma sensu walidować dalej gdy brak parametrów
if (empty($messages)) {
    
    // sprawdzenie, czy $kwota i $kurs są liczbami
    if (!is_numeric($kwota)) {
        $messages[] = 'Kwota nie jest liczbą';
    }
    
    if (!is_numeric($kurs)) {
        $messages[] = 'Kurs nie jest liczbą';
    }

    // sprawdzenie, czy kurs nie jest równy 0
    if ($kurs == 0) {
        $messages[] = 'Kurs nie może być równy 0!'; // Dodano komunikat o błędzie, gdy kurs wynosi 0
    }
}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty($messages)) { // gdy brak błędów
    
    // konwersja parametrów na float, jeśli kurs może być zmiennoprzecinkowy
    $kwota = floatval($kwota);
    $kurs = floatval($kurs);
    
    // wykonanie operacji
    switch ($operation) {
        case 'eurzl': // zamiana z € na Zł
            $result = $kwota * $kurs;
            break;
        case 'zleur': // zamiana z Zł na €
            $result = $kwota / $kurs;
            break;
       
        default:
            $messages[] = 'Nieznana operacja'; // na wypadek nieznanej operacji
            break;
    }

    // Formatowanie wyniku do dwóch miejsc po przecinku
    if (isset($result)) {
        $result = number_format($result, 2, '.', ''); // dwa miejsca po przecinku
    }
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages, $kwota, $kurs, $operation, $result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';
?>
