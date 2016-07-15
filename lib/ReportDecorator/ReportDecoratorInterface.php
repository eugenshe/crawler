<?php

namespace lib\ReportDecorator;

/**
 * Interface ReportDecoratorInterface
 * @package lib\ReportDecorator
 */
interface ReportDecoratorInterface
{
    /**
     * @param array $report
     * @return $this
     */
    public function setReport(array $report);

    /**
     * @return array
     */
    public function getDecoratedReport();
}