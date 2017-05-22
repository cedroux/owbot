<?php

namespace Bot\Commands;

class Greetings extends BaseCommand
{
    public $keywords = ['yo', 'cc', 'coucou', 'salut', 'bonjour', 'hello', 'pouet', 'slt', 'hi'];

    public function execute()
    {
        $this->reply('stoi le ' . $this->message->content);
    }
}
