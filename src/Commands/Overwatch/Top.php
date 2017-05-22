<?php

namespace Bot\Commands\Overwatch;

use Bot\Commands\BaseCommand;
use Bot\Database;

class Top extends BaseCommand
{
    public $keywords = '!top';
    public $help = 'Affiche le classement compétitif des joueurs';

    public function execute()
    {
        $players = Database::select();

        if (count($players) === 0) {
            $this->send("Aucun joueur enregistré");
            return;
        }

        usort($players, function ($a, $b) {
            return $a->rank < $b->rank;
        });

        $output = '';
        $output .= 'Classement compétitif des joueurs :' . PHP_EOL;
        $output .= '```' . PHP_EOL;
        $output .= ' #  Battletag               Rank' . PHP_EOL;
        $output .= '——————————————————————————————————' . PHP_EOL;

        foreach ($players as $key => $player) {
            $tag = explode('#', $player->battletag)[0];

            if (! empty($player->discord)) {
                $user = $this->message->channel->guild->members->get("id", $player->discord);
                $nick = $user->nick; // Mandatory assignation to resolve the data
                $name = ! empty($nick) ? $nick : $user->username;
                if ($name !== $tag) {
                    $tag .= ' (' . $name . ')';
                }
            }
            $output .= str_pad($key + 1, 2, ' ', STR_PAD_LEFT) . '  ';
            $output .= str_pad($tag, 24 + (strlen($tag) - mb_strlen($tag)));
            $output .= $player->rank . PHP_EOL;
        }
        $output .= "```";
        $this->send($output);
    }
}
