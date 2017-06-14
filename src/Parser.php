<?php

namespace Bot;

use Exception;
use PHPHtmlParser\Dom;

class Parser
{
    const URL = 'https://playoverwatch.com/fr-fr/career/pc/eu/';

    /**
     * Parsed Battletag
     *
     * @var string
     */
    public $battletag;

    /**
     * DOM instance
     *
     * @var Dom
     */
    public $dom;

    /**
     * Load DOM
     *
     * @param string $battletag
     */
    public function __construct(string $battletag)
    {
        $this->battletag = str_replace('#', '-', $battletag);

        $this->dom = new Dom;
        $this->dom->loadFromUrl(self::URL . urlencode($this->battletag));
    }

    /**
     * Static rank accessor
     *
     * @param string $battletag
     * @return integer
     */
    static public function rank(string $battletag)
    {
        return (new self($battletag))->getRank();
    }

    /**
     * Get rank
     *
     * @return int
     * @throws Exception
     */
    public function getRank(): int
    {
        /** @var Dom\Collection $rank */
        $rank = $this->dom->find('.competitive-rank div');

        if (! $rank->count()) {
            throw new Exception('Rank not found for ' . $this->battletag);
        }

        return (int) $rank->text;
    }
}
