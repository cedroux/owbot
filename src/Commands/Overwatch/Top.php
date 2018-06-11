<?php

namespace Bot\Commands\Overwatch;

use Bot\Commands\BaseCommand;
use Bot\Database;
use CharlotteDunois\Yasmin\Models\MessageEmbed;

class Top extends BaseCommand
{
    public $keywords = '!top2';
    public $help = 'Affiche le classement compétitif des joueurs (enrichi)';

    public function execute()
    {
        $players = Database::select();

        if (!is_array($players) || count($players) === 0) {
            $this->send("Aucun joueur enregistré");

            return;
        }

        usort($players, function ($a, $b) {
            return $a->rank < $b->rank;
        });

        $names = '';
        $ranks = '';
        $guild = $this->message->guild->id;
        $blank = get_emoji($guild, ':blank:');

        foreach ($players as $key => $player) {
            $tag = '**' . explode('#', $player->battletag)[0] . '**';

            $ranks .= get_emoji($guild, ':rank' . get_rank($player->rank) . ':') . $player->rank . PHP_EOL;
            $names .= $tag;
            if (!empty($player->discord)) {
                $names .= " (<@!{$player->discord}>)";
            }
            $names .= $blank . PHP_EOL;
        }

        $embed = new MessageEmbed([
            "color"       => 0x325091,
            'title'       => 'Classement compétitif des joueurs :',
            'description' => '—',
            'fields'      => [
                [
                    'name'   => 'Rank',
                    'value'  => $ranks,
                    'inline' => 'false',
                ],
                [
                    'name'   => 'Battletag',
                    'value'  => $names,
                    'inline' => 'true',
                ],
            ],
        ]);

        $this->send('', $embed);
    }
}
