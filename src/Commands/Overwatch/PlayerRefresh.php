<?php

namespace Bot\Commands\Overwatch;

use Bot\Commands\BaseCommand;
use Bot\Database;
use Bot\Parser;

class PlayerRefresh extends BaseCommand
{
    public $keywords = '!refresh';
    public $admin = true;
    public $help = 'Actualise le classement';

    public function execute()
    {
        $players = Database::select();

        foreach ($players as $player) {
            echo '-- Updating ' . $player->battletag . '...' . PHP_EOL;

            $newRank = Parser::rank($player->battletag);
            $tag = explode('#', $player->battletag)[0];
            $diff = $newRank - $player->rank;

            if ($diff < 0) {
                $this->send(":x: {$tag} vient de perdre **" . abs($diff) . "** points. Nouveau classement : **{$newRank}**");
            } elseif ($newRank > $player->rank) {
                $this->send(":white_check_mark: {$tag} vient de gagner **{$diff}** points. Nouveau classement : **{$newRank}**");
            }
            $player->rank = $newRank;
            Database::update($player, 'battletag', $player->battletag);
        }
    }
}
