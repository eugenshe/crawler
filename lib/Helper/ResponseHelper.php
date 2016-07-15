<?php

namespace lib\Helper;

/**
 * Class ResponseHelper
 * @package lib\Helper
 */
class ResponseHelper
{
    /**
     * Extract nested links form curl response
     * find by <a> tags with three templates: full link, uri with slash '/',
     * uri with question mark '?'
     * @param string $response
     * @param string $requestedLink
     * @return array
     */
    public static function extractNestedLinks($response, $requestedLink)
    {
        $regexp = '/<a href\=(?:\'|\")(https?:\/\/%s\/[^\s\'\"]*)/';
        preg_match_all(sprintf($regexp, $requestedLink), $response, $matches);
        $linkMatches = next($matches);
        $slashMatches = self::getUriMatches($response, $requestedLink, '/');
        $questionMatches = self::getUriMatches($response, $requestedLink, '?');

        return array_merge($linkMatches, $slashMatches, $questionMatches);
    }

    /**
     * Find and count all <img> tags in curl response
     * @param string $response
     * @return integer
     */
    public static function extractImgTags($response)
    {
        $count = 0;
        preg_match_all('/(<img[^>]+>)/i', $response, $matches);
        if ($matches) {
            $count = count(next($matches));
        }

        return $count;
    }

    /**
     * Find all <a> tags by templates
     * @param string $response
     * @param string $requestedLink
     * @param string $operand
     * @return array
     */
    private static function getUriMatches($response, $requestedLink, $operand)
    {
        $result = [];
        $regexp = '/href\=(?:\'|\")(\%s[^\s\'\"]*)/';
        preg_match_all(sprintf($regexp, $operand), $response, $uriMatches);
        $uris = next($uriMatches);

        if ($uris) {
            foreach ($uris as $uri) {
                $result[] = self::formatUrl($requestedLink, $uri);
            }
        }

        return $result;
    }

    /**
     * Format url
     * @param string $requestedLink
     * @param string $uri
     * @return string
     */
    private static function formatUrl($requestedLink, $uri)
    {
        return 'http://' . $requestedLink . $uri;
    }
}