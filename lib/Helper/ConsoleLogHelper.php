<?php

namespace lib\Helper;

/**
 * Class ConsoleLogHelper
 * @package lib\Helper
 */
class ConsoleLogHelper
{
    const LINE_START = '=======>>';

    /**
     * Print message to console
     * @param string $message
     */
    public static function consoleLog($message)
    {
        echo self::LINE_START . ' ' . $message . "\n";
    }
}