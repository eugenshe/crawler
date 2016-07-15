<?php

namespace lib;

use lib\Curl\CurlQueueRequest;
use lib\Validator\LinkValidator;

/**
 * Class Crawler
 * @package lib
 */
class Crawler
{
    /**
     * @var string
     */
    private $link;

    /**
     * Crawler constructor.
     * @param string $link
     */
    public function __construct($link)
    {
        $this->link = $link;
    }

    /**
     * Run Crawler process
     */
    public function run()
    {
        $linkHandler = new LinkHandler();
        $curlRequest = new CurlQueueRequest();
        $curlRequest->setValidator(new LinkValidator());
        $linkHandler
            ->setLink($this->link)
            ->processReport($curlRequest);
    }
}