<?php

/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/
namespace Luminova\ExtraUtils\Payment\Http;

class Response {
    /**
     * The result object containing various response information.
     *
     * @var object
    */
    private object $result;

    /**
     * Parsed response body as an object.
     *
     * @var object
    */
    private object $body;

    /**
     * Initialize the Response object with the provided result.
     *
     * @param object $result The result object containing response information.
    */
    public function __construct(object $result)
    {
        $this->result = $result;
        $this->body = $this->parseBody($result->body);
    }

    /**
     * Get the original response object.
     *
     * @return mixed The original response object or null if not available.
    */
    public function getResponse(): mixed 
    {
        return $this->result->response ?? null;
    }

    /**
     * Get the response headers.
     *
     * @return array The response headers.
    */
    public function getHeaders(): array 
    {
        return $this->result->headers;
    }

    /**
     * Get a specific header by key.
     *
     * @param string $key The header key.
     *
     * @return mixed The header value or null if not found.
    */
    public function getHeader(string $key): mixed 
    {
        return $this->result->headers[$key] ?? null;
    }

    /**
     * Get the HTTP status code.
     *
     * @return int The HTTP status code or 0 if not available.
    */
    public function getStatus(): int
    {
        return $this->result->statusCode ?? 0;
    }

    /**
     * Check if the response indicates success.
     *
     * @return bool True if the response is successful; otherwise, false.
    */
    public function isSuccess(): bool 
    {
        return $this->body->status ?? false;
    }

    /**
     * Get the parsed response body.
     *
     * @return object The parsed response body or null if not available.
    */
    public function getBody(): object
    {
        return $this->body ?? null;
    }

    /**
     * Get the data portion of the response body.
     *
     * @return object|null The data portion of the response body or null if not available.
    */
    public function getData(): ?object
    {
        return $this->body->data ?? null;
    }

    /**
     * Get the message from the response body.
     *
     * @return string The message from the response body.
    */
    public function getMessage(): string
    {
        return $this->body->message;
    }

    /**
     * Get the error object from the response.
     *
     * @return object|null The error object or null if not available.
    */
    public function getErrors(): ?object
    {
        return $this->result->error ?? null;
    }

    /**
     * Get the error message from the response.
     *
     * @return string The error message.
    */
    public function getError(): string
    {
        return $this->result->error->message ?? '';
    }

    /**
     * Get the error code from the response.
     *
     * @return int The error code or 0 if not available.
    */
    public function getErrorCode(): int
    {
        return $this->result->error->code ?? 0;
    }

    /**
     * Parse the response body and handle potential JSON decoding errors.
     *
     * @param mixed $body The response body to parse.
     *
     * @return object Parsed response body as an object.
    */
    private function parseBody(mixed $body): object 
    {
        $contents = json_decode($body);

        if ($contents === null) {
            $message = 'Something went wrong';

            if (json_last_error() === JSON_ERROR_NONE) {
                $message = json_last_error_msg();
            }

            $contents = [
                'status' => false,
                'contentType' => $this->getHeader('Content-Type'),
                'message' => $message
            ];
        }

        return (object) $contents;
    }
}