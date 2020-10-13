<?php
declare(strict_types=1);


class Dealer extends Player
{
    const VALUE = 15;


    public function hit(Deck $deck)
    {
        while ($this->getScore() < self::VALUE) {
            parent::hit($deck);

        }
    }
}