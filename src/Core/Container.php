<?php

namespace Src\Core;

use Src\Http\Request\Request;
use Src\Routes\Router;

class Container
{
    /**
     * Create Application.
     *
     * @return Application
     */
    public function createApplication(): Application
    {
        return new Application($this->createRouter());
    }

    /**
     * Create Router.
     *
     * @return Router
     */
    private function createRouter(): Router
    {
        return new Router($this->getRequest());
    }

    /**
     * Get Request.
     *
     * @return Request
     */
    private function getRequest(): Request
    {
        return Request::fromGlobalState();
    }
}
