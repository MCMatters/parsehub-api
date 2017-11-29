<?php

declare(strict_types = 1);

namespace McMatters\ParseHubApi;

use McMatters\ParseHubApi\Resources\Project;
use McMatters\ParseHubApi\Resources\Run;

/**
 * Class ParseHubClient
 *
 * @package McMatters\ParseHubApi
 */
class ParseHubClient
{
    /**
     * @var Project
     */
    public $project;

    /**
     * @var Run
     */
    public $run;

    /**
     * ParseHubClient constructor.
     *
     * @param string $apiKey
     * @param int $wait
     */
    public function __construct(string $apiKey, int $wait = 1)
    {
        $this->project = new Project($apiKey, $wait);
        $this->run = new Run($apiKey, $wait);
    }
}
