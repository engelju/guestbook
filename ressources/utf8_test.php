<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

header('Content-Type: text/html; charset=utf-8');

$pdo = new PDO('mysql:dbname=encoding_test;host=localhost', 'pnn_root', 'teequ2eD',
               array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!empty($_POST['text'])) {
	$tmp_text = $_POST['text'];
    $stmt = $pdo->prepare('INSERT INTO `texts` (`content`) VALUES (:text)');
    $retval = $stmt->execute(array('text' => $tmp_text));
}

$results = $pdo->query('SELECT * FROM `texts`')->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html>
<head>
    <title>UTF-8 encoding test</title>
</head>
<body>

<h1>Display test</h1>

<p>
A good day, World!<br>
Schönen Tag, Welt!<br>
Une bonne journée, tout le monde!<br>
يوم جيد، العالم<br>
좋은 일, 세계!<br>
Một ngày tốt lành, thế giới!<br>
こんにちは、世界！<br>
</p>

<h1>Submission test</h1>

<form action="" method="post" accept-charset="utf-8">
    <textarea name="text"></textarea>
    <input type="submit" value="Submit">
</form>

<?php if (!empty($_POST['text'])) : ?>
    <h2>Last received data</h2>
    <pre><?php echo htmlspecialchars($_POST['text'], ENT_NOQUOTES, 'UTF-8'); ?></pre>
<?php endif; ?>

<h1>Output test</h1>

<ul>
    <?php foreach ($results as $result) : ?>
        <li>
            <pre><?php echo htmlspecialchars($result['content'], ENT_NOQUOTES, 'UTF-8'); ?></pre>
        </li>
    <?php endforeach; ?>
</ul>

</body>
</html>
