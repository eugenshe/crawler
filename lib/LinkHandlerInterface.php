<?php

namespace lib;

use lib\curl\CurlRequestInterface;

/**
 * Interface LinkHandlerInterface
 * @package lib
 */
interface LinkHandlerInterface
{
    /**
     * @param string $link
     * @return $this
     */
    public function setLink($link);

    /**
     * @return string
     */
    public function getLink();

    /**
     * @param CurlRequestInterface $curl
     * @return StatsRepository
     */
    public function processReport(CurlRequestInterface $curl);
}