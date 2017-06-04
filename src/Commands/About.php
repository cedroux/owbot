<?php

namespace Bot\Commands;


class About extends BaseCommand
{
    public $keywords = ['!about'];
    public $help = 'À propos du bot';

    public function execute()
    {
        $message = 'OWbot' . PHP_EOL;
        $message .= 'https://github.com/cedroux/owbot/';
        $this->send($message);
    }
}
