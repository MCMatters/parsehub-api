<?php

declare(strict_types=1);

namespace McMatters\ParseHubApi\Resources;

use const false, null;

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
     */
    public function list(
        int $offset = 0,
        int $limit = 20,
        int $includeOptions = 0
    ): array {
        return $this->httpClient
            ->withQuery([
                'offset' => $offset,
                'limit' => $limit,
                'include_options' => $includeOptions,
            ])
            ->get('projects')
            ->json();
    }

    /**
     * @param string $token
     * @param int $offset
     *
     * @return array
     */
    public function get(string $token, int $offset = 0): array
    {
        return $this->httpClient
            ->withQuery(['offset' => $offset])
            ->get("projects/{$token}")
            ->json();
    }

    /**
     * @param string $token
     * @param array|string|null $startValueOverride
     * @param string|null $startUrl
     * @param string|null $startTemplate
     * @param bool $sendEmail
     *
     * @return array
     */
    public function run(
        string $token,
        $startValueOverride = null,
        string $startUrl = null,
        string $startTemplate = null,
        bool $sendEmail = false
    ): array {
        return $this->httpClient
            ->post("projects/{$token}/run", [
                'body' => [
                    'start_value_override' => $startValueOverride,
                    'start_url' => $startUrl,
                    'start_template' => $startTemplate,
                    'send_email' => $sendEmail,
                ],
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
    public function getLastReadyData(string $token): array
    {
        return $this->httpClient
            ->withQuery(['format' => 'json'])
            ->get("projects/{$token}/last_ready_run/data")
            ->json();
    }
}
