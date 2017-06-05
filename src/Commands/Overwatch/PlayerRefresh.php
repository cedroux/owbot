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
    public $periodic = 60 * 5;

    public function execute()
    {
        $players = Database::select();
        $guild = $this->message->channel->guild->id;

        foreach ($players as $player) {
            echo '-- Updating ' . $player->battletag . '...' . PHP_EOL;

            $newRank = Parser::rank($player->battletag);
            $icon = get_emoji($guild, ':rank' . get_rank($newRank) . ':');
            $tag = explode('#', $player->battletag)[0];
            $diff = $newRank - $player->rank;

            $discord = ! empty($player->discord) ? "(<@!{$player->discord}>) " : '';

            if ($diff < 0) {
                $this->broadcast(":x: {$tag} {$discord}vient de perdre **" . abs($diff) . "** points. Nouveau classement : {$icon} **{$newRank}**");
            } elseif ($newRank > $player->rank) {
                $this->broadcast(":white_check_mark: {$tag} {$discord}vient de gagner **{$diff}** points. Nouveau classement : {$icon} **{$newRank}**");
            }
            $player->rank = $newRank;
            Database::update($player, 'battletag', $player->battletag);
        }
    }
}
