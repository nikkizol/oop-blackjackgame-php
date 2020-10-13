<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blackjack</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/97e98690fe.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<h1>Blackjack</h1>

<?php
foreach($player->getCards() AS $card) {
echo $card->getUnicodeCharacter(true);
echo '<br>';
}
?>

<form method="post">
    <button type="submit" name="new" class="btn btn-primary">New Game</button>
    <button type="submit" name="hit" class="btn btn-primary">Hit</button>
    <button type="submit" name="stand" class="btn btn-primary">Stand</button>
    <button type="submit" name="surrender" class="btn btn-primary">Surrender</button>
</form>
</body>
</html>