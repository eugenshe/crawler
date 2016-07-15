<?php

namespace lib\Curl;

/**
 * Interface CurlRequestInterface
 * @package lib\Curl
 */
interface CurlRequestInterface
{
    /**
     * @param string $link
     * @return string
     */
    public function doRequest($link);

    /**
     * @return float
     */
    public function getMicroTime();

    /**
     * @param float $startTime
     * @return float
     */
    public function getEndTime($startTime);
}