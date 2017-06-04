<?php

namespace Bot\Commands;

use Bot\Bot;
use Discord\Discord;
use Discord\Parts\Channel\Message;

abstract class BaseCommand
{
    /**
     * Command settings
     */
    public $keywords = [];
    public $admin = false;
    public $typing = true;
    public $help = '';
    /**
     * Discord instance
     *
     * @var Discord
     */
    protected $discord;
    protected $config;
    /**
     * @var Message
     */
    protected $message;

    /**
     * Command constructor.
     *
     * @param Bot &$bot
     */
    function __construct(Bot &$bot)
    {
        $this->bot = $bot;
        $this->discord = $bot->getDiscord();
        $this->config = $bot->getConfig();

        echo 'New command registered: ' . get_class($this) . PHP_EOL;
    }

    /**
     * Keyword detection
     *
     * @param Message $message
     * @return bool
     */
    public function triggersOn(Message $message): bool
    {
        $key = strtolower(explode(' ', $message->content)[0]);

        if (is_array($this->keywords) && in_array($key, $this->keywords)) {
            $this->message = $message;

            return true;
        } elseif ($key == $this->keywords) {
            $this->message = $message;

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function start(): bool
    {
        if ($this->checkAdmin() === false) {
            return false;
        }

        $this->execute();
    }

    /**
     * Check if the command requires admin rights, and if so,
     * check if the user is authorized
     *
     * @return bool
     */
    public function checkAdmin()
    {
        if ($this->admin === false) {
            return true;
        }

        return $this->isAdmin();
    }


    /**
     * Check if the author is an admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return in_array($this->message->author->user->id, $this->config['admin']);
    }

    /**
     * Abstract command to be implemented in child commands
     *
     * @return mixed
     */
    abstract protected function execute();

    /**
     * Send a message on the triggering channel
     *
     * @param $string
     */
    public function send(string $string): void
    {
        if ($this->typing === true) {
            $this->message->channel->broadcastTyping();
        }

        $this->message->channel->sendMessage($string);
    }

    /**
     * Reply to the user
     *
     * @param string $string
     */
    public function reply(string $string): void
    {
        $this->message->reply($string);
    }

    /**
     * Send a message to all channels configured as 'broadcast'
     *
     * @param string $string
     */
    public function broadcast(string $string): void
    {
        foreach ($this->config['broadcast'] as $guild => $channels) {
            foreach ($channels as $channel) {
                $this->discord
                    ->guilds->get('id', $guild)
                    ->channels->get('id', $channel)
                    ->sendMessage($string);
            }
        }
    }
}
