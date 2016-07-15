<?php

namespace lib\Validator;

/**
 * Interface LinkValidatorInterface
 * @package lib\Validator
 */
interface LinkValidatorInterface
{
    /**
     * @param array $links
     * @return array
     */
    public function filterLinks(array $links);

    /**
     * @param string $url
     * @throws \Exception
     */
    public function validateUrl($url);
}
