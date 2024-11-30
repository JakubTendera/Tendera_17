<?php
function validate($kwota, $kierunek, $kurs) {
    $messages = [];

    if (!$kwota || !$kierunek || !$kurs) {
        $messages[] = "Wszystkie pola są wymagane!";
    }

    if (!is_numeric($kwota) || $kwota <= 0) {
        $messages[] = "Kwota musi być liczbą dodatnią!";
    }

    if (!is_numeric($kurs) || $kurs <= 0) {
        $messages[] = "Kurs wymiany musi być liczbą dodatnią!";
    }

    if (!in_array($kierunek, ['pln_to_eur', 'eur_to_pln'])) {
        $messages[] = "Wybrano nieprawidłowy kierunek przeliczenia!";
    }

    return $messages;
}

function calculate($kwota, $kierunek, $kurs) {
    if ($kierunek === 'pln_to_eur') {
        return $kwota / $kurs;
    } elseif ($kierunek === 'eur_to_pln') {
        return $kwota * $kurs;
    }
    return null;
}
?>
