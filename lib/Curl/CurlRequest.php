<?php

namespace lib\Curl;

use lib\validator\LinkValidatorInterface;

/**
 * Class CurlRequest
 * @package lib\Curl
 */
abstract class CurlRequest implements CurlRequestInterface
{
    const USER_AGENT = 'Mozilla/4.0 (compatible; MSIE 5.01; ' . 'Windows NT 5.0)';

    /**
     * Make curl request and log time
     * @param string $link
     * @return array
     */
    public function doRequest($link)
    {
        $startTime = $this->getMicroTime();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_REFERER, '');
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        $html = curl_exec($ch);
        curl_close($ch);

        $response = [
            'link'     => $link,
            'time'     => $this->getEndTime($startTime),
            'response' => $html
        ];

        return $response;
    }

    /**
     * @return float
     */
    public function getMicroTime()
    {
        return microtime(true);
    }

    /**
     * Calculate end time point
     * @param float $startTime
     * @return float
     */
    public function getEndTime($startTime)
    {
        $endTime = $this->getMicroTime() - $startTime;

        return round($endTime, 4);
    }

    /**
     * @param string $link
     * @return array
     */
    public abstract function doQueueRequest($link);

    /**
     * @param LinkValidatorInterface $validator
     * @return $this
     */
    public abstract function setValidator(LinkValidatorInterface $validator);
}