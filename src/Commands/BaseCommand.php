<?php

namespace Bot\Commands;

use Bot\Bot;
use Discord\Discord;
use Discord\Parts\Channel\Message;

abstract class BaseCommand
{
    /**
     * Keywords that will trigger the command
     *
     * @var string|array
     */
    public $keywords = [];

    /**
     * Determine if only admins can use the command
     *
     * @var bool
     */
    public $admin = false;

    /**
     * Short help text (will be used in !help)
     *
     * @var string
     */
    public $help = '';

    /**
     * Periodic execution of the command every n seconds
     * If set to null, the command won't be executed periodically
     *
     * Note: Periodic execution can't use Message object since its
     *       not triggered by a message event
     *
     * @var null|int
     */
    public $periodic = null;

    /**
     * Discord instance
     *
     * @var Discord
     */
    protected $discord;

    /**
     * Configuration repository
     *
     * @var array
     */
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
     * @param string $string
     * @param bool $tts
     * @param null $embed
     */
    public function send(string $string, $tts = false, $embed = null)
    {
        $this->message->channel->sendMessage($string, $tts, $embed);
    }

    /**
     * Reply to the user
     *
     * @param string $string
     */
    public function reply(string $string)
    {
        $this->message->reply($string);
    }

    /**
     * Send a message to all channels configured as 'broadcast'
     *
     * @param string $string
     */
    public function broadcast(string $string)
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
