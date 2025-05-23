<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class DescriptionGenerationException extends Exception
{
    /**
     * @var array
     */
    protected $context;

    /**
     * @param string $message
     * @param array $context
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = "",
        array $context = [],
        int $code = 0,
        ?Throwable $previous = null
    ) {
        $this->context = $context;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the error context
     *
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Create an instance for API errors
     *
     * @param string $message
     * @param array $apiResponse
     * @return static
     */
    public static function apiError(string $message, array $apiResponse = []): self
    {
        return new static(
            $message,
            [
                'type' => 'api_error',
                'response' => $apiResponse
            ],
            500
        );
    }

    /**
     * Create an instance for invalid input data
     *
     * @param array $invalidFields
     * @return static
     */
    public static function invalidInput(array $invalidFields): self
    {
        return new static(
            'Invalid input data provided for job description generation',
            [
                'type' => 'validation_error',
                'invalid_fields' => $invalidFields
            ],
            422
        );
    }

    /**
     * Create an instance for rate limit errors
     *
     * @param int $retryAfter
     * @return static
     */
    public static function rateLimitExceeded(int $retryAfter): self
    {
        return new static(
            'API rate limit exceeded',
            [
                'type' => 'rate_limit_error',
                'retry_after' => $retryAfter
            ],
            429
        );
    }

    /**
     * Create an instance for timeout errors
     *
     * @param int $timeout
     * @return static
     */
    public static function timeout(int $timeout): self
    {
        return new static(
            'Request timed out while generating description',
            [
                'type' => 'timeout_error',
                'timeout' => $timeout
            ],
            504
        );
    }

    /**
     * Check if the exception is related to API errors
     *
     * @return bool
     */
    public function isApiError(): bool
    {
        return ($this->context['type'] ?? '') === 'api_error';
    }

    /**
     * Check if the exception is related to validation
     *
     * @return bool
     */
    public function isValidationError(): bool
    {
        return ($this->context['type'] ?? '') === 'validation_error';
    }

    /**
     * Check if the exception is related to rate limiting
     *
     * @return bool
     */
    public function isRateLimitError(): bool
    {
        return ($this->context['type'] ?? '') === 'rate_limit_error';
    }

    /**
     * Check if the exception is related to timeout
     *
     * @return bool
     */
    public function isTimeoutError(): bool
    {
        return ($this->context['type'] ?? '') === 'timeout_error';
    }

    /**
     * Get a response-ready array representation of the exception
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'context' => $this->getContext()
        ];
    }
}
