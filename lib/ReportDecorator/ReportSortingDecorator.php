<?php

namespace lib\ReportDecorator;

/**
 * Class ReportSortingDecorator
 * @package lib\ReportDecorator
 */
class ReportSortingDecorator implements ReportDecoratorInterface
{
    /**
     * @var array
     */
    private $report;

    /**
     * @param array $report
     * @return $this
     */
    public function setReport(array $report)
    {
        $this->report = $report;

        return $this;
    }

    /**
     * ASC sorting report
     * @return array
     */
    public function getDecoratedReport()
    {
        usort($this->report, function ($a, $b) {
            return $a['images'] - $b['images'];
        });

        return $this->report;
    }
}