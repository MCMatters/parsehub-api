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
    protected $project;

    /**
     * @var Run
     */
    protected $run;

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

    /**
     * @return Project
     */
    public function project(): Project
    {
        return $this->project;
    }

    /**
     * @return Run
     */
    public function run(): Run
    {
        return $this->run;
    }
}
