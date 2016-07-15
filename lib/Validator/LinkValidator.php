<?php

namespace lib\Validator;

use lib\StatsRepository;

/**
 * Class LinkValidator
 * @package lib\Validator
 */
class LinkValidator implements LinkValidatorInterface
{
    /**
     * Filter links, compare with already processed
     * Return unprocessed links
     * @param array $links
     * @return array
     */
    public function filterLinks(array $links)
    {
        $out = [];
        $repository = StatsRepository::getInstance();
        foreach ($links as $link) {
            if (!$repository->isLinkPrecessed($link)) {
                $out[] = $link;
            }
        }

        return $out;
    }

    /**
     * Validate input url
     * @param string $url
     * @throws \Exception
     */
    public function validateUrl($url)
    {
        if (!preg_match('/\b(?:(?:https?):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $url)) {
            throw new \Exception('Url is not valid', 404);
        }
    }
}