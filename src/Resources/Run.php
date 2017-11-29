<?php

declare(strict_types = 1);

namespace McMatters\ParseHubApi\Resources;

use Throwable;

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
     * @throws Throwable
     */
    public function get(string $token): array
    {
        return $this->requestGet("runs/{$token}");
    }

    /**
     * @param string $token
     * @param string $format
     *
     * @return array|string
     * @throws Throwable
     */
    public function getData(string $token, string $format = 'json')
    {
        return $this->requestGet("runs/{$token}/data", [
            'format' => $this->getRequestFormat($format),
        ]);
    }

    /**
     * @param string $token
     *
     * @return array
     * @throws Throwable
     */
    public function cancel(string $token): array
    {
        return $this->requestPost("runs/{$token}/cancel");
    }

    /**
     * @param string $token
     *
     * @return array
     * @throws Throwable
     */
    public function delete(string $token): array
    {
        return $this->requestDelete("runs/{$token}");
    }
}
