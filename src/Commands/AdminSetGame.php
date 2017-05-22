<?php

namespace Bot\Commands;

use Discord\Parts\User\Game;

class AdminSetGame extends BaseCommand
{
    public $keywords = ['!setgame', '!game', '!play'];
    public $admin = true;
    public $help = 'Défini le jeu auquel le bot joue';

    public function execute()
    {
        $stop = ['stop', 'off'];

        if (strpos($this->message->content, ' ')) {
            $arg = substr($this->message->content, strpos($this->message->content, ' ') + 1);
        } else {
            $arg = null;
        }

        if (in_array($arg, $stop) || $arg === null) {
            $game = null;
            $this->send('gg ez');
        } else {
            $game = $this->discord->factory(Game::class, [
                'name' => $arg,
            ]);
            $this->send('brb!');
        }
        $this->discord->updatePresence($game);
    }
}
