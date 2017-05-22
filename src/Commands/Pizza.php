<?php

namespace Bot\Commands;

class Pizza extends BaseCommand
{
    public $keywords = ['!pizza'];
    public $help = 'Commande une pizza';
    public $typing = true;

    public function execute()
    {
        $this->reply('t\'es pas déjà assez gros ?');
    }
}
