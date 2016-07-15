<?php

namespace lib\ReportBuilder;

use lib\Helper\ConsoleLogHelper;
use lib\ReportDecorator\ReportDecoratorInterface;

/**
 * Class ReportBuilder
 * @package lib\ReportBuilder
 */
class ReportBuilder implements ReportBuilderInterface
{
    const REPORT_HEADING = 'report';
    const UNDERSCORE     = '_';
    const DATE_FORMAT    = 'd.m.Y';
    const FILE_EXTENSION = '.html';

    /**
     * @var ReportDecoratorInterface
     */
    private $reportDecorator;

    /**
     * ReportBuilder constructor.
     * @param ReportDecoratorInterface $reportDecorator
     */
    public function __construct(ReportDecoratorInterface $reportDecorator)
    {
        $this->reportDecorator = $reportDecorator;
    }

    /**
     * Saving report file
     * @param string $report
     */
    public function saveReport($report)
    {
        $reportName = $this->getReportName();
        file_put_contents($reportName, $report);
        ConsoleLogHelper::consoleLog('Generated file: ' . $reportName);
    }

    /**
     * Generate report file name by date
     * @return string
     */
    public function getReportName()
    {
        return self::REPORT_HEADING . self::UNDERSCORE . date(self::DATE_FORMAT, time()) . self::FILE_EXTENSION;
    }

    /**
     * Creating HTML table by DOMDocument
     * and saving it to project dir
     */
    public function generateReport()
    {
        $sortedReport = $this->reportDecorator->getDecoratedReport();
        $dom = new \DOMDocument;

        $domAttribute = $dom->createAttribute('border');
        $domAttribute->value = '1';

        $table = $dom->createElement('table');

        $tr = $dom->createElement('tr');
        $table->appendChild($tr);

        $td = $dom->createElement('th', 'Url');
        $tr->appendChild($td);

        $td = $dom->createElement('th', 'Images');
        $tr->appendChild($td);

        $td = $dom->createElement('th', 'Time');
        $tr->appendChild($td);

        foreach ($sortedReport as $reportRaw) {
            $tr = $dom->createElement('tr');
            $table->appendChild($tr);

            $td = $dom->createElement('td', htmlspecialchars($reportRaw['link']));
            $tr->appendChild($td);

            $td = $dom->createElement('td', $reportRaw['images']);
            $tr->appendChild($td);

            $td = $dom->createElement('td', $reportRaw['time']);
            $tr->appendChild($td);
        }

        $table->appendChild($domAttribute);
        $dom->appendChild($table);
        $dom->formatOutput = true;

        $this->saveReport($dom->saveHTML());
    }
}