# OWBot
A Discord bot for Overwatch players

## Introduction
OWBot is a simple bot for Discord written in PHP. It allows player to track their competive ranking among other players of a Discord server.


## Available commands

### General
**`!help`**
> List the available commands

**`!help admin` (Admin only)**
> List the available commands for the admin users

### Overwatch

**`!rank <BattleTag>`**
> Display the competitive rank of any BattleTag

**`!addme <BattleTag>`**
> Link your BattleTag and your Discord ID to the bot. You will now appear in the rankings and your rank changes will be broadcasted on the specified channels.

**`!top`**
> Display the competive rank table of players registered in the server

**`!top2`**
> Same as `!top` but in a fancy way (Not mobile friendly)

**`!add <BattleTag>` (Admin only)**
> Add any BattleTag to the tracking (but not linked to a Discord ID)

**`!delete <BattleTag>` (Admin only)**
> Remove a player from the tracking.

**`!refresh` (Admin only)**
> Force a refresh of the ranks. *Not recommended as it can cause some lags.*

### Administration commands

**`!setgame <Game name>`**
> Update the game *played* by the bot. Will be seen in the user list as *Playing **Game name***

**`!restart`**
**`!exit`**


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
