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
        $discord = '';
        $ranks = '';
        $guild = $this->message->guild->id;
        $blank = get_emoji($guild, ':blank:');

        foreach ($players as $key => $player) {
            $tag = '**' . explode('#', $player->battletag)[0] . '**';

            if (!empty($player->discord)) {
                $discord .= "<@!{$player->discord}>" . $blank . PHP_EOL;
            } else {
                $discord .= $blank . PHP_EOL;
            }
            $names .= $tag . $blank . PHP_EOL;
            $ranks .= get_emoji($guild, ':rank' . get_rank($player->rank) . ':') . $player->rank . PHP_EOL;
        }

        $embed = new MessageEmbed([
            "color"       => 0x325091,
            'title'       => 'Classement compétitif des joueurs :',
            'description' => '—',
            'fields'      => [
                [
                    'name'   => 'Rank',
                    'value'  => $ranks,
                    'inline' => 'true',
                ],
                [
                    'name'   => 'Battletag',
                    'value'  => $names,
                    'inline' => 'true',
                ],
                [
                    'name'   => 'Discord',
                    'value'  => $discord,
                    'inline' => 'true',
                ],
            ],
        ]);

        $this->send('', $embed);
    }
}
