<?php

namespace Bot\Commands;

/**
 * Display available commands
 *
 * Parameters:
 *   full: List all possible keywords (e.g. '!help/!info/!commands')
 *   admin: Show only admin command (User must be admin)
 */
class Help extends BaseCommand
{
    public $keywords = ['!help', '!info', '!commands'];
    public $help = 'Affiche les différentes commandes disponibles';

    public function execute()
    {
        $message = '';
        $arguments = explode(' ', $this->message->content);

        /** @var BaseCommand $command */
        foreach ($this->bot->getCommands() as $command) {
            if (in_array('full', $arguments)) {
                $key = is_array($command->keywords) ? implode('**/**', $command->keywords) : $command->keywords;
            } else {
                $key = is_array($command->keywords) ? $command->keywords[0] : $command->keywords;
            }

            if (! empty($command->help) && ! $command->admin && ! in_array('admin', $arguments)) {
                $message .= "**{$key}** {$command->help}\n";
            } elseif (in_array('admin', $arguments) && $command->admin && $this->isAdmin()) {
                $message .= "**{$key}** {$command->help}\n";
            }
        }

        $this->send($message);
    }
}
