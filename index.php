<?php
declare(strict_types=1);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);
//require "Deck.php";
require "Blackjack.php";
require "Card.php";
require "Player.php";
require "Suit.php";
//require "view.php";

session_start();


if (!isset($_SESSION["blackjack"])) {
    $_SESSION["blackjack"] = new Blackjack();
}

$deck = $_SESSION["blackjack"]->getDeck();
$player = $_SESSION["blackjack"]->getPlayer();
$dealer = $_SESSION["blackjack"]->getDealer();
$lost = "";


if (isset($_POST['hit'])) {
//    if (isset($_SESSION["blackjack"])) {
//        $deck = $_SESSION["blackjack"]->getDeck();
//        $player = $_SESSION["blackjack"]->getPlayer();
//        $dealer = $_SESSION["blackjack"]->getDealer();
        if ($player->hit($deck) == "true") {
            $lost = "You lost!!!";
        }
//        $_SESSION["blackjack"]->setPlayer($player);
//        $player->getScore();
//    }
}

if (isset($_POST['surrender'])) {
//    if (isset($_SESSION["blackjack"])) {
//        $deck = $_SESSION["blackjack"]->getDeck();
//        $player = $_SESSION["blackjack"]->getPlayer();
//        $dealer = $_SESSION["blackjack"]->getDealer();
      if ($player->surrender() == "true"){
          $lost = "You lost!!!";
      }
//        $_SESSION["blackjack"]->setPlayer($player);
//        $player->getScore();
//    }
}

if (isset($_POST['stand'])) {
  $dealer->hit($deck);
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
    <title>Blackjack</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/97e98690fe.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
        .cards {
            font-size: 900%;
        }

        h1, h2 {
            text-align: center;
        }

        body {
            margin: auto;
            width: 80%;
        }

    </style>
</head>

<h1>Blackjack</h1>
<h2><?php echo $lost ?></h2>
<h3>Player</h3>
<h4>Score:<?php echo $player->getScore() ?></h4>

<p class="cards"> <?php
    foreach ($player->getCards() as $card) { ?><?php echo $card->getUnicodeCharacter(true);
    } ?></p>

<h3>Dealer</h3>
<h4>Score:<?php echo $dealer->getScore() ?></h4>

<p class="cards"> <?php
    foreach ($dealer->getCards() as $card) { ?><?php echo $card->getUnicodeCharacter(true);
    } ?></p>


<form method="post">
    <button type="submit" name="new" class="btn btn-primary">New Game</button>
    <button type="submit" name="hit" class="btn btn-primary">Hit</button>
    <button type="submit" name="stand" class="btn btn-primary">Stand</button>
    <button type="submit" name="surrender" class="btn btn-primary">Surrender</button>
</form>
</body>
</html>