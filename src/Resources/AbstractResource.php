<?php

declare(strict_types = 1);

namespace McMatters\ParseHubApi\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Throwable;
use const false, true;
use function array_merge_recursive, is_callable, json_decode, sleep, stripos;

/**
 * Class AbstractResource
 *
 * @package McMatters\ParseHubApi\Resources
 */
abstract class AbstractResource
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var int
     */
    protected $wait;

    /**
     * AbstractResource constructor.
     *
     * @param string $apiKey
     * @param int $wait
     */
    public function __construct(string $apiKey, int $wait = 1)
    {
        $this->client = new Client([
            'base_uri' => 'https://www.parsehub.com/api/v2/',
            'query'    => [
                'api_key' => $apiKey,
            ],
        ]);

        $this->wait = $wait;
    }

    /**
     * @param string $uri
     * @param array $query
     *
     * @return array|string
     * @throws Throwable
     */
    protected function requestGet(string $uri, array $query = [])
    {
        return $this->request('GET', $uri, ['query' => $query]);
    }

    /**
     * @param string $uri
     * @param array $data
     *
     * @return array|string
     * @throws Throwable
     */
    protected function requestPost(string $uri, array $data = [])
    {
        return $this->request('POST', $uri, [
            'headers'     => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Charset'      => 'utf-8',
            ],
            'form_params' => $data,
        ]);
    }

    /**
     * @param string $uri
     * @param array $query
     *
     * @return array|string
     * @throws Throwable
     */
    protected function requestDelete(string $uri, array $query = [])
    {
        return $this->request('DELETE', $uri, ['query' => $query]);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @return array|string
     * @throws Throwable
     */
    protected function request(
        string $method,
        string $uri,
        array $options = []
    ) {
        $options = array_merge_recursive($this->client->getConfig(), $options);

        try {
            $response = $this->client->request($method, $uri, $options);
        } catch (Throwable $e) {
            if (0 !== $this->wait &&
                is_callable([$e, 'getStatusCode']) &&
                $e->getStatusCode() === 429
            ) {
                sleep($this->wait);

                $response = $this->client->request($method, $uri, $options);
            } else {
                throw $e;
            }
        }

        $content = $response->getBody()->getContents();

        return $this->respondedWithJson($response)
            ? json_decode($content, true)
            : $content;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    protected function getRequestFormat(string $format = 'json'): string
    {
        return $format === 'csv' ? 'csv' : 'json';
    }

    /**
     * @param Response $response
     *
     * @return bool
     */
    protected function respondedWithJson(Response $response): bool
    {
        $contentTypes = $response->getHeader('Content-Type') ?? [];

        foreach ((array) $contentTypes as $contentType) {
            if (false !== stripos($contentType ?? '', 'json')) {
                return true;
            }
        }

        return false;
    }
}
