<?php

namespace Src\Http\Request;

use Src\Helpers\Utils;

class Request
{
    /**
     * Request data
     *
     * @var array
     */
    private array $data;

    /**
     * Set Request Data.
     */
    public function setData()
    {
        $this->data = $this->getRequestData();
    }

    /**
     * Get Request Data.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Create a new Request object.
     *
     * @return Request
     */
    public static function fromGlobalState(): Request
    {
        return new self();
    }

    /**
     * Get Request Data.
     *
     * @return array
     */
    private function getRequestData(): array
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = trim($urlPath, '/');
        $explodedUrl = explode('/', $url);

        if ($explodedUrl[0] !== 'api' || $explodedUrl[1] !== 'v1') {
            Utils::throwHttpError('INCORRECT_URL', 'Could not route request.');
        }

        // removing 'api' and 'v1' elements
        $urlData = array_slice($explodedUrl, 2);

        return ['method' => $method,
            'formData' => Utils::getFormData($method),
            'urlData' => $urlData,
            'router' => ucfirst($urlData[0] . 'Router')
        ];
    }

    /**
     * Get Headers.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return getallheaders();
    }
}
