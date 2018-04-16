<?php

namespace Bot\Commands;

class AdminRestart extends BaseCommand
{
    public $keywords = ['!restart', '!reboot'];
    public $admin = true;
    public $help = 'Relance le bot';

    public function execute()
    {
        echo 'Restarting...' . PHP_EOL;

        $file = __DIR__ . '/../../' . basename($_SERVER['PHP_SELF']);
        pcntl_exec($file);

        exit (0);
    }
}
