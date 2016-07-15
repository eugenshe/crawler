<?php

namespace lib\ReportBuilder;

/**
 * Interface ReportBuilderInterface
 * @package lib\ReportBuilder
 */
interface ReportBuilderInterface
{
    /**
     * @return array
     */
    public function generateReport();

    /**
     * @param string $report
     */
    public function saveReport($report);

    /**
     * @return string
     */
    public function getReportName();
}