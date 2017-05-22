<?php

if (! function_exists('get_rank')) {
    function get_rank(int $rank)
    {
        $rank = 0;
        if ($rank < 1500) {
            $rank = 1;
        } elseif ($rank >= 1500 && $rank < 2000) {
            $rank = 2;
        } elseif ($rank >= 2000 && $rank < 2500) {
            $rank = 3;
        } elseif ($rank >= 2500 && $rank < 3000) {
            $rank = 4;
        } elseif ($rank >= 3000 && $rank < 3500) {
            $rank = 5;
        } elseif ($rank >= 3500 && $rank < 4000) {
            $rank = 6;
        } elseif ($rank >= 4000) {
            $rank = 7;
        }

        return $rank;
    }
}