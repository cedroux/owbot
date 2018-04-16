<?php

namespace Bot;

use Bot\Commands\BaseCommand;
use Bot\Database as Database;
use CharlotteDunois\Yasmin\Client;
use CharlotteDunois\Yasmin\Models\Message;
use React\EventLoop\Factory;

final class Bot
{
    /**
     * The Discord client loop instance.
     *
     * @var mixed
     */
    protected $loop;

    /**
     * The Client instance.
     *
     * @var Client
     */
    protected $client;

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
     *
     * @throws \Exception
     */
    function __construct()
    {
        $this->config = require __DIR__ . '/../config/config.php';
        $this->loop = Factory::create();
        $this->client = new Client([], $this->loop);
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
     * Start periodic commands
     */
    public function startPeriodic()
    {
        foreach ($this->commands as $command) {
            if ($command->periodic !== null) {
                $this->loop->addPeriodicTimer($command->periodic, function () use ($command) {
                    $command->execute();
                });
            }
        }
    }

    /**
     * Description
     */
    public function start()
    {
        $this->startPeriodic();

        $this->client->on('ready', function () {
            echo 'Logged in as ' . $this->getClient()->user->tag . PHP_EOL;
        });

        try {
            $this->client->on('message', function (Message $message) {
                echo "[{$message->guild->name}][#{$message->channel->name}] {$message->author->username}: ";
                echo $message->content . PHP_EOL;

                foreach ($this->commands as $command) {
                    /** @var BaseCommand $command */
                    if ($command->triggersOn($message)) {
                        $command->start();
                    }
                }
            });
        } catch (\Exception $e) {
            echo '----------------- ' . $e->getMessage() . PHP_EOL;
        }

        $this->client->login($this->config['token']);
        $this->loop->run();
    }

    /**
     * Get Client instance
     *
     * @return
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Get config repository
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Get list of registered commands
     *
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}
