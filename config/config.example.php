<?php

return [

    /*
     * Discord API token
     */
    'token' => '##API_TOKEN##',

    /*
     * Database path
     */
    'db_path' => __DIR__ . '/../storage/db.json',

    /*
     * Channels used for broadcasting
     */
    'broadcast' => [
        '##GUILD_ID##' => [
            '##CHANNEL_ID##',
        ],
    ],

    /*
     * Bot administrators
     */
    'admin' => [
        //
    ],

];
