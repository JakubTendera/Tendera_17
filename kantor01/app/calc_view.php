<?php require_once dirname(__FILE__) .'/../config.php'; ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator</title>
</head>
<body>
    <br>

<form action="<?php print(_APP_URL);?>/app/calc.php" method="post">
    <label for="id_kwota">Kwota: </label>
    <input id="id_kwota" type="text" name="kwota" value="<?php echo isset($kwota) ? $kwota : ''; ?>" /><br />
    
    <label for="id_kurs">Kurs: </label>
    <input id="id_kurs" type="text" name="kurs" value="<?php echo isset($kurs) ? $kurs : ''; ?>" /><br />

    <label for="id_op">Przeliczanie z: </label> <br>
    <input type="radio" id="zloty_na_euro" name="op" value="zleur" checked <?php echo (isset($operation) && $operation === 'zleur') ? 'checked' : ''; ?>>
    <label for="zloty_na_euro">Zł => €</label><br>
    
    <input type="radio" id="euro_na_zloty" name="op" value="eurzl" <?php echo (isset($operation) && $operation === 'eurzl') ? 'checked' : ''; ?>>
    <label for="euro_na_zloty">€ => Zł</label><br>
    
    <input type="submit" value="Przelicz" />
</form>    

<?php
//wyświetlenie listy błędów, jeśli istnieją
if (isset($messages)) {
    if (count($messages) > 0) {
        echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
        foreach ($messages as $key => $msg) {
            echo '<li>'.$msg.'</li>';
        }
        echo '</ol>';
    }
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Kwota po przeliczeniu: '.$result; ?>
</div>
<?php } ?>

</body>
</html>
