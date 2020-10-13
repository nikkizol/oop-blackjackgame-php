<?php
declare(strict_types=1);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

require "classes/Blackjack.php";
require "classes/Card.php";
require "classes/Player.php";
require "classes/Suit.php";
require "classes/dealer.php";


session_start();


if (!isset($_SESSION["blackjack"])) {
    $_SESSION["blackjack"] = new Blackjack();
}

$deck = $_SESSION["blackjack"]->getDeck();
$player = $_SESSION["blackjack"]->getPlayer();
$dealer = $_SESSION["blackjack"]->getDealer();
$result = "";


if (isset($_POST['hit'])) {
    if ($player->hit($deck) == "true") {
        $result = "You lost!!!";
    }

}

if (isset($_POST['surrender'])) {
    if ($player->surrender() == "true") {
        $result = "You lost!!!";
    }
}

if (isset($_POST['stand'])) {
    $dealer->hit($deck);
    if ($dealer->getScore() > $player->getScore() && $dealer->getScore() <= 21) {
        $player->getLost();
        $result = "You lost!!!";
    } elseif ($dealer->getScore() == $player->getScore()) {
        $result = "It's a draw";
    } else $result = "You win!!!";

}

if (isset($_POST['new'])) {
    session_unset();
    $_SESSION["blackjack"] = new Blackjack();
    $deck = $_SESSION["blackjack"]->getDeck();
    $player = $_SESSION["blackjack"]->getPlayer();
    $dealer = $_SESSION["blackjack"]->getDealer();
    $player->getScore();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Blackjack</title>
    <style>
        .cards {
            font-size: 900%;
        }

        h1, h2 {
            text-align: center;
        }

        h2 {
            color: white;
            background: grey;
            position: absolute;
            top: 20%;
            left: 45%;
            z-index: 1;
        }


        body {
            margin: auto;
            width: 80%;
            text-align: center;
        }

        .col {
            margin: auto;
            padding: 5px;
        }

        form {
            display: inline-block;
        }

    </style>
</head>
<body>
<h1>Blackjack</h1>
<h2><?php echo $result ?></h2>
<div class="container">
    <div class="row">
        <div class="col">
            <h3>Player</h3>
            <h4>Score:<?php echo $player->getScore() ?></h4>
            <p class="cards"> <?php
                foreach ($player->getCards() as $card) { ?><?php echo $card->getUnicodeCharacter(true);
                } ?></p>
        </div>
        <div class="col">
            <h3>Dealer</h3>
            <h4>Score:<?php echo $dealer->getScore() ?></h4>
            <p class="cards"> <?php
                foreach ($dealer->getCards() as $card) { ?><?php echo $card->getUnicodeCharacter(true);
                } ?></p>
        </div>
    </div>
</div>
<form method="post">
    <?php if (!$result) : ?>
        <button type="submit" name="hit" class="btn btn-success">Hit</button>
        <button type="submit" name="stand" class="btn btn-warning">Stand</button>
        <button type="submit" name="surrender" class="btn btn-danger">Surrender</button>
    <?php else : ?>
        <button type="submit" name="new" class="btn btn-primary">New Game</button>
    <?php endif; ?>
</form>
</body>
</html>