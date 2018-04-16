<?php

namespace Bot\Commands;

class AdminSetGame extends BaseCommand
{
    public $keywords = ['!setgame', '!game', '!play'];
    public $admin = true;
    public $help = 'Défini le jeu auquel le bot joue';

    public function execute()
    {
        $stop = ['stop', 'off'];

        if (strpos($this->message->content, ' ')) {
            $game = substr($this->message->content, strpos($this->message->content, ' ') + 1);
        } else {
            $game = null;
        }

        if (in_array($game, $stop) || $game === null) {
            $game = null;
            $this->send('gg ez');
        } else {
            $this->send('brb!');
        }
        $this->client->user->setGame($game);
    }
}
