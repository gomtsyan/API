<?php

namespace Src\Routes;

use Src\Helpers\Utils;
use Src\Http\Request\Request;
use Src\Security\AccessHandler;

class Router
{
    /**
     * @var array
     */
    private array $routeList = [
        'AccessRouter',
        'CardsRouter'
    ];

    /**
     * @var Request
     */
    public Request $request;

    /**
     * Create a router instance.
     *
     * @param  Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get current router.
     *
     * @return RouterHandler
     */
    public function getRoute(): RouterHandler
    {
        $requestData  = $this->request->getData();
        if ($this->isValidRouter($requestData['router'])) {
            $_router = __NAMESPACE__ . "\\" . $requestData['router'];
            return new $_router($this->createAccessHandler());
        }

        Utils::throwHttpError('INCORRECT_URL', 'Could not route request.');
    }

    /**
     * Check is valid router.
     *
     * @param  string $router
     * @return bool
     */
    private function isValidRouter(string $router): bool
    {
        return in_array($router, $this->routeList);
    }

    /**
     * Create AccessHandler.
     *
     * @return AccessHandler
     */
    private function createAccessHandler(): AccessHandler
    {
        return new AccessHandler(getenv('SECRET'));
    }
}
