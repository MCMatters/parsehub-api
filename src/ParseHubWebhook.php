<?php

declare(strict_types=1);

namespace McMatters\ParseHubApi;

use InvalidArgumentException;

use function is_array, is_object, is_string, json_decode, parse_str, strtolower;

use const null, true;

/**
 * Class ParseHubWebhook
 *
 * @package McMatters\ParseHubApi
 */
class ParseHubWebhook
{
    const STATUS_INITIALIZED = 'initialized';
    const STATUS_RUNNING = 'running';
    const STATUS_COMPLETE = 'complete';

    /**
     * @var array
     */
    protected $payload;

    /**
     * ParseHubWebhook constructor.
     *
     * @param mixed $payload
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($payload)
    {
        $this->setPayload($payload);
    }

    /**
     * @param mixed $payload
     *
     * @return \McMatters\ParseHubApi\ParseHubWebhook
     *
     * @throws \InvalidArgumentException
     */
    public static function make($payload): self
    {
        return new self($payload);
    }

    /**
     * @return string
     */
    public function getProjectToken(): string
    {
        return $this->payload['project_token'];
    }

    /**
     * @return string
     */
    public function getRunToken(): string
    {
        return $this->payload['run_token'];
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->getJsonProperty('options_json');
    }

    /**
     * @return int
     */
    public function getPagesCount(): int
    {
        return (int) $this->payload['pages'];
    }

    /**
     * @return string
     */
    public function getStartTime(): string
    {
        return $this->payload['start_time'];
    }

    /**
     * @return string|null
     */
    public function getEndTime()
    {
        if (!$this->isCompleted()) {
            return null;
        }

        return $this->payload['end_time'];
    }

    /**
     * @return string
     */
    public function getStartUrl(): string
    {
        return $this->payload['start_url'];
    }

    /**
     * @return string
     */
    public function getStartTemplate(): string
    {
        return $this->payload['start_template'];
    }

    /**
     * @return array
     */
    public function getStartValue(): array
    {
        return $this->getJsonProperty('start_value');
    }

    /**
     * @return string
     */
    public function getOwnerEmail(): string
    {
        return $this->payload['owner_email'];
    }

    /**
     * @return string|null
     */
    public function getHashSum()
    {
        if (!$this->isCompleted()) {
            return null;
        }

        return $this->payload['md5sum'];
    }

    /**
     * @return string
     */
    public function getWebhookUrl(): string
    {
        return $this->payload['webhook'];
    }

    /**
     * @return bool
     */
    public function isDataReady(): bool
    {
        return (bool) $this->payload['data_ready'];
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return strtolower($this->payload['is_empty']) === true ||
            $this->payload['is_empty'] === '1';
    }

    /**
     * @return bool
     */
    public function isRunning(): bool
    {
        return $this->payload['status'] === self::STATUS_RUNNING;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->payload['status'] === self::STATUS_COMPLETE;
    }

    /**
     * @param mixed $payload
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function setPayload($payload)
    {
        if (is_string($payload)) {
            parse_str($payload, $this->payload);
        } elseif (is_array($payload)) {
            $this->payload = $payload;
        } elseif (is_object($payload)) {
            $this->payload = (array) $payload;
        } else {
            throw new InvalidArgumentException(
                '$payload must be a string, an array or an object'
            );
        }
    }

    /**
     * @param string $key
     *
     * @return array
     */
    protected function getJsonProperty(string $key): array
    {
        if (!$this->payload[$key]) {
            return [];
        }

        if (is_array($this->payload[$key])) {
            return $this->payload[$key];
        }

        if (is_string($this->payload[$key])) {
            $this->payload[$key] = json_decode($this->payload[$key], true);

            return $this->payload[$key];
        }

        if (is_object($this->payload[$key])) {
            $this->payload[$key] = (array) $this->payload[$key];

            return $this->payload[$key];
        }

        return [];
    }
}
