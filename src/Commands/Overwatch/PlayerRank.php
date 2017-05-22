<?php

namespace Bot\Commands\Overwatch;

use Bot\Commands\BaseCommand;
use Bot\Parser;

class PlayerRank extends BaseCommand
{
    public $keywords = '!rank';
    public $help = 'Récupère le rang d\'un joueur';

    public function execute()
    {
        $battletag = trim(substr($this->message->content, strlen('!rank') + 1));

        if (empty($battletag)) {
            $this->send("Utilisation : **!rank Battletag#1234**");

            return;
        }

        $rank = Parser::rank($battletag);
        $tag = explode('#', $battletag)[0];

        if (! $rank) {
            $this->send("Joueur inconnu : {$battletag}");
        } else {
            $this->send("Le rang de **{$tag}** est **{$rank}**");
        }
    }
}
