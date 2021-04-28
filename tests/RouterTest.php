<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Src\Helpers\Utils;
use Src\Http\Request\Request;
use Src\Routes\Router;
use Src\Routes\RouterHandler;

/**
* @runInSeparateProcess
*/
final class RouterTest extends TestCase
{
    public function testCanRouteAccessRequest()
    {
        $requestMock = $this->createMock(Request::class);
        $requestMock->method("getHeaders")->willReturn([]);
        $requestMock->method("getData")
            ->willReturn([
                'method' => 'GET',
                'formData' => [],
                'urlData' => ['access'],
                'router' => ucfirst('accessRouter')
            ]);
        $router = new Router($requestMock);
        $this->assertInstanceOf(RouterHandler::class, $router->getRoute());
    }

    /**
     * @dataProvider routesProvider
     * @testdox      Routes $url to $handler
     */
    public function testRoutesRequest(string $url, string $handler): void
    {
        // ...
        $this->testRoutesRequest($url, $handler);
    }

    public function routesProvider()
    {
        return [
            'testing an OK value' => ['url' => '.api/v1/access', 'handler' => RouterHandler::class],
            'testing a bad value' => ['url' => '.api/v1/access555', 'handler' => RouterHandler::class]
        ];
    }
}
