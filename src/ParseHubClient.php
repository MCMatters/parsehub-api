<?php

declare(strict_types=1);

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
     * @var \McMatters\ParseHubApi\Resources\Project
     */
    protected $project;

    /**
     * @var \McMatters\ParseHubApi\Resources\Run
     */
    protected $run;

    /**
     * ParseHubClient constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->project = new Project($apiKey);
        $this->run = new Run($apiKey);
    }

    /**
     * @return \McMatters\ParseHubApi\Resources\Project
     */
    public function project(): Project
    {
        return $this->project;
    }

    /**
     * @return \McMatters\ParseHubApi\Resources\Run
     */
    public function run(): Run
    {
        return $this->run;
    }
}
