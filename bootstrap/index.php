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
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen" />
        <style>
        input {
            padding:15px !important;
        }
        </style>
    </head>
    <body>
    <div class="container">
        <h2>Neuer Eintrag erfassen</h2>
        <div class="row">
            <div class="span6">
                <form action="" method="post" accept-charset="utf-8">
                    <div class="controls controls-row">
                        <input id="author" name="author" type="text" class="span3" placeholder="Name"> 
                        <input id="title" name="title" type="text" class="span3" placeholder="Titel">
                    </div>
                    <div class="controls">
                        <textarea id="text" name="text" class="span6" placeholder="Your Message" rows="5"></textarea>
                    </div>
                    <div class="controls">
                        <input type="submit" name="submit" value="Eintragen" class="btn btn-primary input-medium pull-right">
                    </div>
                </form>
            </div>
        </div>
        
        <h2>Einträge:</h2>
        <?php
        $allGbEntries = GbEntry::allEntries();
        foreach ($allGbEntries as $oEntry) {
            echo $oEntry->displayEntry();
        }
        ?>
    </div>
    </body>
</html>