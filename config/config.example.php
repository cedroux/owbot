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
     * Bot administrators
     */
    'admin' => [
        //
    ],

    /*
     * Channels used for broadcasting
     */
    'broadcast' => [
        '##GUILD_1_ID##' => [
            '##CHANNEL_1_ID##',
            '##CHANNEL_2_ID##',
        ],
    ],

    /*
     * Emojis
     *
     * The blank emoji is a transparent emoji used for alignments
     *
     * To get the ID of an emoji, write it in any Discord chat prefixed with a backslash.
     * Example: \:rank1:
     */
    'emojis' => [
        '##GUILD_1_ID##' => [
            ':rank1:' => '##ID##',
            ':rank2:' => '##ID##',
            ':rank3:' => '##ID##',
            ':rank4:' => '##ID##',
            ':rank5:' => '##ID##',
            ':rank6:' => '##ID##',
            ':rank7:' => '##ID##',
            ':blank:' => '##ID##',
        ],
    ],

];
