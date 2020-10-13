<?php
declare(strict_types=1);

require "Deck.php";


class Player
{
    const MAX_VALUE = 21;
    private array $cards = [];
    private bool $lost = false;

    public function __construct(Deck $deck)
    {
        array_push($this->cards, $deck->drawCard());
        array_push($this->cards, $deck->drawCard());

    }


    public function hit(Deck $deck)
    {
        array_push($this->cards, $deck->drawCard());
        if ($this->getScore() > self::MAX_VALUE) {
            return $this->getLost();
    }
        return $this->cards;


    }
    public function getCards()
    {
        return $this->cards;
    }

    public function surrender()
    {
        return $this->lost = true;
    }

    public function getScore()
    {
        $score = 0;
        foreach ($this->cards as $value) {
            $score += $value->getValue();
        }
        return $score;

    }

//    public function hasLost()
//    {
//        return $this->lost;
//    }

    public function getLost()
    {
        return $this->lost = true;

    }
}

