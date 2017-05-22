<?php

namespace Bot\Commands\Overwatch;

use Bot\Commands\BaseCommand;
use Bot\Database;
use Bot\Parser;

class PlayerAddMe extends BaseCommand
{
    public $keywords = '!addme';
    public $help = 'Lier son identifiant Discord a un Battletag';

    public function execute()
    {
        $battletag = trim(substr($this->message->content, strlen('!addme') + 1));

        if (empty($battletag)) {
            $this->send("Utilisation : **!addme Battletag#1234**");

            return;
        }

        $rank = Parser::rank($battletag);
        $tag = explode('#', $battletag)[0];

        if (! $rank) {
            $this->send("Joueur inconnu ou non classé : {$battletag}");

            return;
        }

        $player = Database::select('battletag', $battletag);

        if (empty($player)) {
            Database::insert([
                'battletag' => $battletag,
                'rank'      => $rank,
                'discord'   => $this->message->author->id,
            ]);
            $this->send("Vous avez été ajouté au classement (Rang {$rank})");
        } elseif (empty($player->discord)) {
            $player->discord = $this->message->author->id;
            Database::update($player, 'battletag', $player->battletag);
            $this->send("{$tag} a été lié à votre identifiant Discord");
        } elseif (! empty($player->discord)) {
            $this->send("Ce Battletag est déjà lié à un identifiant Discord");
        }
    }
}