<?php

declare(strict_types=1);

namespace McMatters\ParseHubApi\Resources;

use McMatters\Ticl\Client;

use const true;

/**
 * Class AbstractResource
 *
 * @package McMatters\ParseHubApi\Resources
 */
abstract class AbstractResource
{
    /**
     * @var \McMatters\Ticl\Client
     */
    protected $httpClient;

    /**
     * AbstractResource constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://www.parsehub.com/api/v2',
            'query' => ['api_key' => $apiKey],
            'filter_nulls' => true,
        ]);
    }
}
