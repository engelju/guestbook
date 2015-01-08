<?php

//error_reporting(E_ALL);
//ini_set('display_errors', true);

header('Content-Type: text/html; charset=utf-8');
require_once('_classes/GbEntry.php');

/* handler */
if (!empty($_POST["submit"])) {
    # Formular wurde abgesendet, ist nicht leer !
    $author  = trim(strip_tags($_POST["author"]));
    $title   = trim(strip_tags($_POST["title"]));
    $text    = trim(strip_tags($_POST["text"]));
    $possible_errors = GbEntry::newEntry($author, $title, $text);
    if ($possible_errors && is_array($possible_errors)) {
        echo "folgende fehler gefunden:<br>";
        foreach ($possible_errors as $_error) {
            echo $_error . "<br>";
        }
    } else {
        echo "beitrag erfolgreich gespeichert.";
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Gästebuch</title>
    </head>

    <body>

    <div class='container'>
        <h1>Neuer Eintrag erfassen</h1>
        <br>
        <form action="" method="post" accept-charset="utf-8">
        Ihr Name: <input name="author" maxlength=30><br>
        Titel des Beitrags: <input name="title" maxlength=100><br>
        Ihr G&auml;stebucheintrag:<br>
        <textarea name="text" rows=5 cols=50></textarea><br>
        <input type="submit" name="submit" value="Eintragen">
        </form>

        <h1>Einträge:</h1>

        <?php
        $allGbEntries = GbEntry::allEntries();
        foreach ($allGbEntries as $oEntry) {
            echo $oEntry->displayEntry();
        }
        ?>
    </div>
    </body>
</html>
