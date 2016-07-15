<?php

namespace lib;

use lib\curl\CurlRequestInterface;
use lib\Curl\CurlQueueRequest;
use lib\ReportBuilder\ReportBuilder;
use lib\ReportDecorator\ReportSortingDecorator;

/**
 * Class LinkHandler
 * @package lib
 */
class LinkHandler implements LinkHandlerInterface
{
    /**
     * @var string
     */
    private $link;

    /**
     * @param string $link
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Makes a curl request of input link
     * receives a report than decorate it
     * and that build an output report file
     * @param CurlRequestInterface $curlRequest
     * @return StatsRepository
     */
    public function processReport(CurlRequestInterface $curlRequest)
    {
        /** @var CurlQueueRequest $curlRequest */
        $repository = $curlRequest->doQueueRequest($this->link);
        $decorator = new ReportSortingDecorator();
        $decorator->setReport($repository->getStats());
        $reportBuilder = new ReportBuilder($decorator);
        $reportBuilder->generateReport();
    }
}
