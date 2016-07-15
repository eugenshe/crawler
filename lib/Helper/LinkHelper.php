<?php

namespace lib\Helper;

/**
 * Class LinkHelper
 * @package lib\Helper
 */
class LinkHelper
{
    /**
     * Get only host from url
     * @param string $link
     * @return string
     */
    public static function clearLink($link)
    {
        $parsedUrl = parse_url($link);

        return $parsedUrl['host'];
    }
}