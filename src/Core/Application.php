<?php

namespace Src\Core;

use Src\Helpers\Utils;
use Src\Routes\Router;
use \Exception;

class Application
{
    /**
     * @var Router
     */
    private Router $router;

    /**
     * Create an application instance.
     *
     * @param  Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Run the application.
     */
    public function run()
    {
        try {
            $this->router->request->setData();
            $currentRouter = $this->router->getRoute();
            $response = $currentRouter->route($this->router->request);

            foreach ($response->getHeaders() as $key => $value) {
                header($key . ": " . $value);
            }

            echo (string) $response;
        } catch (Exception $e) {
            Utils::throwHttpError('SOMETHING_WRONG', 'Something went wrong');
        }
    }
}
