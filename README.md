# OWBot
A Discord bot for Overwatch players

## Introduction
OWBot is a simple bot for Discord written in PHP. It allows player to track their competive ranking among other players of a Discord server.

## How to use
### Requirements
* PHP >= 7.0
* Composer

### Install
Get the repository and update dependencies
```bash
# Clone the repository
git clone https://github.com/Cedroux/owbot.git

# Change directory
cd owbot

# Install Composer dependencies
composer install
```

### Configure

Copy and edit the default configuration file
```bash
cp config/config.example.php config/config.php
nano config/config.php
```

### Launch
To start the bot, just execute `bot.php`
```bash
php bot.php
```
