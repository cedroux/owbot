<?php

namespace Bot;

use Bot\Database as Database;
use Discord\Discord;
use Discord\Parts\Channel\Message;

final class Bot
{
    /**
     * The Discord instance.
     *
     * @var Discord
     */
    protected $discord;

    /**
     * The Database instance.
     *
     * @var Database
     */
    protected $database;

    /**
     * Config repository
     *
     * @var array
     */
    protected $config = [];

    /**
     * Commands repository
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Bot constructor.
     */
    function __construct()
    {
        $this->config = require __DIR__ . '/../config/config.php';
        $this->discord = new Discord(['token' => $this->config['token']]);
    }

    /**
     * Register a command in the application
     *
     * @param string $class
     */
    public function registerCommand(string $class)
    {
        $this->commands[] = new $class($this);
    }

    /**
     * Description
     */
    public function start()
    {
        $this->discord->on('ready', function (Discord $discord) {
            $this->discord->on('message', function (Message $message, Discord $discord) {
                echo "{$message->author->username}: {$message->content}" . PHP_EOL;
                
                foreach ($this->commands as $command) {
                    if ($command->triggersOn($message)) {
                        $command->start();
                    }
                }
            });
        });

        $this->discord->run();
    }

    /**
     * @return Discord
     */
    public function getDiscord(): Discord
    {
        return $this->discord;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}
