<?php

namespace Bot\Commands\Overwatch;

use Bot\Commands\BaseCommand;
use Bot\Database;
use Bot\Parser;

class PlayerAdd extends BaseCommand
{
    public $keywords = '!add';
    public $admin = true;
    public $help = 'Ajoute un joueur dans le classement';

    public function execute()
    {
        $battletag = trim(substr($this->message->content, strlen('!add') + 1));

        if (empty($battletag)) {
            $this->send("Utilisation : **!add Battletag#1234**");

            return;
        }

        $rank = Parser::rank($battletag);
        $tag = explode('#', $battletag)[0];

        if (! $rank) {
            $this->send("Joueur inconnu ou non classé : {$battletag}");
        } elseif (empty(Database::select('battletag', $battletag))) {
            Database::insert([
                'battletag' => $battletag,
                'rank'      => $rank,
            ]);
            $this->send("**{$tag}** a été ajouté (Rang {$rank})");
        } else {
            $this->send("{$tag} est déjà présent dans le classement");
        }
    }
}
