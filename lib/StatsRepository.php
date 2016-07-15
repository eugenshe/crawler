<?php

namespace lib;

/**
 * Class StatsRepository
 * @package lib
 */
class StatsRepository
{
    /**
     * @var StatsRepository
     */
    private static $instance;

    /**
     * @var array
     */
    private $linksStats = [];

    /**
     * @var array
     */
    private $processedLinks = [];

    /**
     * @return self
     */
    static public function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Check whether the link is processed
     * @param string $link
     * @return bool
     */
    public function isLinkPrecessed($link)
    {
        return in_array($link, $this->processedLinks);
    }

    /**
     * Add link to processed list
     * @param string $link
     */
    private function addToProcessed($link)
    {
        $this->processedLinks[] = $link;
    }

    /**
     * Add collected stats to repository
     * @param array $stats
     */
    private function addStats(array $stats)
    {
        $this->linksStats[] = $stats;
    }

    /**
     * Getting collected stats and adding to repository
     * @param array $stats
     */
    public function processStats(array $stats)
    {
        $this->addToProcessed($stats['link']);
        $this->addStats($stats);
    }

    /**
     * Get number of already processed links
     * @return int
     */
    public function getProcessedLinksCount()
    {
        return count($this->processedLinks);
    }

    /**
     * Get all collected stats
     * @return array
     */
    public function getStats()
    {
        return $this->linksStats;
    }
}