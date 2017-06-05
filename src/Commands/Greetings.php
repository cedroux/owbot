<?php

namespace Bot\Commands;

class Greetings extends BaseCommand
{
    public $keywords = ['yo', 'cc', 'coucou', 'salut', 'bonjour', 'hello', 'pouet', 'slt', 'hi'];

    public function execute()
    {
        $this->send("Bienvenue agent <@{$this->message->author->id}> ! Pour connaître les commandes disponibles envoie **!help**");
    }
}
