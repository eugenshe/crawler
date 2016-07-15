<?php

namespace lib\Curl;

use lib\Helper\ConsoleLogHelper;
use lib\Helper\LinkHelper;
use lib\Helper\ResponseHelper;
use lib\StatsRepository;
use lib\validator\LinkValidatorInterface;

/**
 * Class CurlQueueRequest
 * @package lib\Curl
 */
class CurlQueueRequest extends CurlRequest implements CurlRequestInterface
{
    /**
     * @var LinkValidatorInterface $validator
     */
    private $validator;

    /**
     * @param LinkValidatorInterface $validator
     * @return $this
     */
    public function setValidator(LinkValidatorInterface $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Do request for each link, collect stats, find nested links
     * and put them in a queue for processing
     * It will run until the queue is cleared
     * @param string $link
     * @return StatsRepository
     */
    public function doQueueRequest($link)
    {
        $repository = StatsRepository::getInstance();
        $this->validator->validateUrl($link);
        $queue = $this->handleRequest($repository, $link);

        while (count($queue)) {
            $url = array_shift($queue);
            $queue = array_unique(array_merge($queue, $this->handleRequest($repository, $url)));
            ConsoleLogHelper::consoleLog('In Queue: ' . count($queue));
            ConsoleLogHelper::consoleLog('Processed: ' . $repository->getProcessedLinksCount());
        }
        ConsoleLogHelper::consoleLog('Final.');

        return $repository;
    }

    /**
     * Do curl request and handle response
     * Collect stats
     * @param StatsRepository $repository
     * @param                 $url
     * @return array
     */
    private function handleRequest(StatsRepository $repository, $url)
    {
        ConsoleLogHelper::consoleLog('Url: ' . $url);
        $queueResponse = $this->doRequest($url);
        $repository->processStats(
            [
                'link'   => $url,
                'time'   => $queueResponse['time'],
                'images' => ResponseHelper::extractImgTags($queueResponse['response'])
            ]
        );

        $nestedLinks = ResponseHelper::extractNestedLinks($queueResponse['response'], LinkHelper::clearLink($url));

        return  $this->validator->filterLinks($nestedLinks);
    }
}