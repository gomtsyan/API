<?php

namespace Src\Http\Response;

class Response
{
    /**
     * @var string
     */
    private string $response;

    /**
     * @var array
     */
    private array $headers;

    /**
     * Create an instance of the response.
     *
     * @param  string $response
     * @param  array $headers
     */
    private function __construct(string $response, array $headers)
    {
        $this->response = $response;
        $this->headers = $headers;
    }

    /**
     * Create new response.
     *
     * @param  string $response
     * @param  array $headers
     * @return Response
     */
    public static function fromParameters(string $response, array $headers): Response
    {
        return new self($response, $headers);
    }

    /**
     * Get headers.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * To string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->response;
    }
}
