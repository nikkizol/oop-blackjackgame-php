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
$bet=0;
$chips = 100;
if (!isset($_SESSION["blackjack"])) {
    $_SESSION["blackjack"] = new Blackjack();
}

if (!isset($_SESSION["chips"])) {
    $_SESSION["chips"] = 100;
}
if (!isset($_SESSION["bet"])) {
    $_SESSION["bet"] = $bet;
}

$chips = $_SESSION["chips"];
$bet = $_SESSION["bet"];

$deck = $_SESSION["blackjack"]->getDeck();
$player = $_SESSION["blackjack"]->getPlayer();
$dealer = $_SESSION["blackjack"]->getDealer();
$result = "";
$dealerScore = "";




if (isset($_POST['hit'])) {
    if ($player->hit($deck) == "true") {
        $dealerScore= $dealer->getScore();
        $result = "You lost!!!";
    }


}

if (isset($_POST['surrender'])) {
    $dealerScore= $dealer->getScore();
    if ($player->surrender() == "true") {
        $result = "You lost!!!";
    }
}

if (isset($_POST['stand'])) {
    $dealer->hit($deck);
    $dealerScore = $dealer->getScore();
    if ($dealer->getScore() > $player->getScore() && $dealer->getScore() <= 21) {
        $player->getLost();
        $result = "You lost!!!";
    } elseif ($dealer->getScore() == $player->getScore()) {
        $result = "It's a draw";
    } else $result = "You win!!!";

}

if (isset($_POST['new'])) {
    session_unset();
    $result="";
    $_SESSION["bet"] = $bet;
    $bet=0;
    $_SESSION["blackjack"] = new Blackjack();
    $deck = $_SESSION["blackjack"]->getDeck();
    $player = $_SESSION["blackjack"]->getPlayer();
    $dealer = $_SESSION["blackjack"]->getDealer();
    $player->getScore();
}


if (isset( $_POST['bet'] )) {
    $bet = $_POST['bet'];
    $chips= $chips-$bet;
}
$_SESSION["bet"] = $bet;
$_SESSION["chips"] = $chips;


if($result=="You win!!!"){
    $chips= $chips+$bet*2;
}
$_SESSION["chips"] = $chips;

if ($result=="You lost!!!" && $chips===0){
    $result= "GAME OVER";
    session_unset();
    $bet=0;
    $chips=100;
    $_SESSION["bet"] = $bet;
    $_SESSION["chips"] = $chips;

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
            left: 43%;
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

        <?php if ((!isset($_POST['stand'])) && (!isset($_POST['surrender'])) && (!$result)) : ?>
        .dealer span:nth-child(2) {
            filter: blur(10px);
            -webkit-filter: blur(20px);
        }

        <?php endif; ?>

        .bet {
            padding: 10px;
        }
        .bet_but {
            margin: 10px;
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
            <h4>Total Chips:<?php echo $chips ?></h4>
            <h5>Chips you bet:<?php echo $_SESSION["bet"] ?></h5>
            <p class="cards"> <?php
                foreach ($player->getCards() as $card) { ?><?php echo $card->getUnicodeCharacter(true);
                } ?></p>
        </div>
        <div class="col">
            <h3>Dealer</h3>
            <h4>Score:<?php echo $dealerScore ?></h4>
            <p class="cards dealer"> <?php
                foreach ($dealer->getCards() as $card) { ?><?php echo $card->getUnicodeCharacter(true);
                } ?></p>
        </div>
    </div>
</div>
<form method="post">
    <?php if (!$result) : ?>
        <button type="submit" name="hit" class="btn btn-success">Hit</button>
        <button type="submit" name="stand" class="btn btn-warning">Stand</button>
        <button type="submit" name="surrender" class="btn btn-danger">Surrender</button><br>
    <?php else : ?>
        <button type="submit" name="new" class="btn btn-primary">New Game</button><br>
    <?php endif; ?>
</form><br>
<form method="post" action="index.php">
    <label for="chips">How many chips you want to bet?</label><br>
    <input type="number" id="bet" name="bet"  min="5" max="<?php echo $chips ?>" >
    <input type="submit" name="submit" value="Bet">
</form>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>