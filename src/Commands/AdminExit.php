<?php

namespace Bot\Commands;

class AdminExit extends BaseCommand
{
    public $keywords = ['!exit', '!quit'];
    public $admin = true;
    public $help = 'Ferme le bot';

    public function execute()
    {
        echo 'Exiting...' . PHP_EOL;

        exit (0);
    }
}
