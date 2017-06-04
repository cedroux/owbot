#!/usr/bin/php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Bot\Bot;

$bot = new Bot();

// Fun
$bot->registerCommand(\Bot\Commands\Pizza::class);
$bot->registerCommand(\Bot\Commands\Greetings::class);

// Misc
$bot->registerCommand(\Bot\Commands\Help::class);
$bot->registerCommand(\Bot\Commands\AdminSetGame::class);
$bot->registerCommand(\Bot\Commands\AdminRestart::class);
$bot->registerCommand(\Bot\Commands\AdminExit::class);
$bot->registerCommand(\Bot\Commands\About::class);

// Overwatch
$bot->registerCommand(\Bot\Commands\Overwatch\PlayerRank::class);
$bot->registerCommand(\Bot\Commands\Overwatch\PlayerAdd::class);
$bot->registerCommand(\Bot\Commands\Overwatch\PlayerAddMe::class);
$bot->registerCommand(\Bot\Commands\Overwatch\PlayerDelete::class);
$bot->registerCommand(\Bot\Commands\Overwatch\PlayerRefresh::class);
$bot->registerCommand(\Bot\Commands\Overwatch\Top::class);

$bot->start();
