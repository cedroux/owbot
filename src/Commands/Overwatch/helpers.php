<?php

if (! function_exists('get_rank')) {
    /**
     * Convert rank value to rank id
     *
     * @param int $rank
     * @return int
     */
    function get_rank(int $rank): int
    {
        if ($rank < 1500) {
            return 1;
        } elseif ($rank >= 1500 && $rank < 2000) {
            return 2;
        } elseif ($rank >= 2000 && $rank < 2500) {
            return 3;
        } elseif ($rank >= 2500 && $rank < 3000) {
            return 4;
        } elseif ($rank >= 3000 && $rank < 3500) {
            return 5;
        } elseif ($rank >= 3500 && $rank < 4000) {
            return 6;
        } elseif ($rank >= 4000) {
            return 7;
        }
    }
}

if (! function_exists('get_emoji')) {
    /**
     * Return formated emoji code
     *
     * @param int $guild_id
     * @param string $emoji
     * @return string
     */
    function get_emoji(int $guild_id, string $emoji): string
    {
        $config = require __DIR__ . '/../../../config/config.php';

        return "<{$emoji}{$config['emojis'][$guild_id][$emoji]}>";
    }
}
