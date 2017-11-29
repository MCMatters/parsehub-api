<?php

declare(strict_types = 1);

namespace McMatters\ParseHubApi\Resources;

use Throwable;
use const false, null;
use function array_filter;

/**
 * Class Project
 *
 * @package McMatters\ParseHubApi\Resources
 */
class Project extends AbstractResource
{
    /**
     * @param int $offset
     * @param int $limit
     * @param int $includeOptions
     *
     * @return array
     * @throws Throwable
     */
    public function list(
        int $offset = 0,
        int $limit = 20,
        int $includeOptions = 0
    ): array {
        return $this->requestGet('projects', [
            'offset'          => $offset,
            'limit'           => $limit,
            'include_options' => $includeOptions,
        ]);
    }

    /**
     * @param string $token
     * @param int $offset
     *
     * @return array
     * @throws Throwable
     */
    public function get(string $token, int $offset = 0): array
    {
        return $this->requestGet("projects/{$token}", ['offset' => $offset]);
    }

    /**
     * @param string $token
     * @param array|string|null $startValueOverride
     * @param string|null $startUrl
     * @param string|null $startTemplate
     * @param bool $sendEmail
     *
     * @return array
     * @throws Throwable
     */
    public function run(
        string $token,
        $startValueOverride = null,
        string $startUrl = null,
        string $startTemplate = null,
        bool $sendEmail = false
    ): array {
        return $this->requestPost("projects/{$token}/run", array_filter([
            'start_value_override' => $startValueOverride,
            'start_url'            => $startUrl,
            'start_template'       => $startTemplate,
            'send_email'           => $sendEmail,
        ]));
    }


    /**
     * @param string $token
     * @param string $format
     *
     * @return array|string
     * @throws Throwable
     */
    public function getLastReadyData(string $token, string $format = 'json')
    {
        return $this->requestGet("projects/{$token}/last_ready_run/data", [
            'format' => $this->getRequestFormat($format),
        ]);
    }
}
