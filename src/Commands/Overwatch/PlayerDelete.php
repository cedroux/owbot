<?php

namespace Bot\Commands\Overwatch;

use Bot\Commands\BaseCommand;
use Bot\Database;

class PlayerDelete extends BaseCommand
{
    public $keywords = '!delete';
    public $admin = true;
    public $help = 'Retire un joueur du classement';

    public function execute()
    {
        $battletag = trim(substr($this->message->content, strlen('!delete') + 1));

        if (empty($battletag)) {
            $this->send("Utilisation : **!delete Battletag#1234**");

            return;
        }

        $tag = explode('#', $battletag)[0];

        $player = Database::select('battletag', $battletag);

        if (!empty($player)) {
            Database::delete('battletag', $battletag);
            $this->send("{$tag} a été retiré du classement");
        } else {
            $this->send("{$tag} est introuvable dans le classement");
        }
    }
}
