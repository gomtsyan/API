<?php

namespace Src\Http\Request;

use Src\Helpers\Utils;

class Request
{
    /**
     * Request method
     *
     * @var string
     */
    public string $method;

    /**
     * Request Form Data
     *
     * @var array
     */
    public array $formData;

    /**
     * Request Url Data
     *
     * @var array
     */
    public array $urlData;

    /**
     * Request Router Name
     *
     * @var string
     */
    public string $router;

    /**
     * Set Method
     *
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * Get Method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Set Form Data
     *
     * @param array $formData
     */
    public function setFormData(array $formData)
    {
        $this->formData = $formData;
    }

    /**
     * Get Form Data
     *
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }

    /**
     * Set Url Data
     *
     * @param array $urlData
     */
    public function setUrlData(array $urlData)
    {
        $this->urlData = $urlData;
    }

    /**
     * Get Url Data
     *
     * @return array
     */
    public function getUrlData(): array
    {
        return $this->urlData;
    }

    /**
     * Set Router
     *
     * @param string $router
     */
    public function setRouter(string $router)
    {
        $this->router = $router;
    }

    /**
     * Get Router
     *
     * @return string
     */
    public function getRouter(): string
    {
        return $this->router;
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
     * set Request Data.
     */
    public function setRequestData()
    {
        $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = trim($urlPath, '/');
        $explodedUrl = explode('/', $url);

        if ($explodedUrl[0] !== 'api' || $explodedUrl[1] !== 'v1') {
            Utils::throwHttpError('INCORRECT_URL', 'Could not route request.');
        }

        // removing 'api' and 'v1' elements
        $urlData = array_slice($explodedUrl, 2);

        $this->setMethod($_SERVER['REQUEST_METHOD']);
        $this->setFormData(Utils::getFormData($_SERVER['REQUEST_METHOD']));
        $this->setUrlData($urlData);
        $this->setRouter(ucfirst($urlData[0] . 'Router'));
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
