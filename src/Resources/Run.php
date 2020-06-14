<?php

declare(strict_types=1);

namespace McMatters\ParseHubApi\Resources;

/**
 * Class Run
 *
 * @package McMatters\ParseHubApi\Resources
 */
class Run extends AbstractResource
{
    /**
     * @param string $token
     *
     * @return array
     */
    public function get(string $token): array
    {
        return $this->httpClient->get("runs/{$token}")->json();
    }

    /**
     * @param string $token
     *
     * @return array
     */
    public function getData(string $token): array
    {
        return $this->httpClient
            ->withQuery(['format' => 'json'])
            ->get("runs/{$token}/data")
            ->json();
    }

    /**
     * @param string $token
     *
     * @return array
     */
    public function cancel(string $token): array
    {
        return $this->httpClient
            ->post("runs/{$token}/cancel", [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
                ],
            ])
            ->json();
    }

    /**
     * @param string $token
     *
     * @return array
     */
    public function delete(string $token): array
    {
        return $this->httpClient->delete("runs/{$token}")->json();
    }
}
