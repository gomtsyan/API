<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Src\Http\Request\Request;
use Src\Routes\Router;
use Src\Routes\RouterHandler;
use Src\Security\AccessHandler;
use Dotenv\Dotenv;

/**
* @runInSeparateProcess
*/
final class RouterTest extends TestCase
{
    public function testCanRouteAccessRequest()
    {
        $requestMock = $this->createMock(Request::class);

        $requestMock->method("getHeaders")->willReturn([]);
        $requestMock->method("setMethod")->willReturn('GET');
        $requestMock->method("setRouter")->willReturn('AccessRouter');
        $requestMock->method("setUrlData")->willReturn([]);
        $requestMock->method("setFormData")->willReturn([]);

        $routerMock = $this->createMock(Router::class);

        $this->assertInstanceOf(RouterHandler::class, $routerMock->getRoute());
    }

    public function testCanRouteCardsRequest()
    {
        $dotenv = new DotEnv(__DIR__.'/../');
        $dotenv->load();
        $accessHandler = new AccessHandler(getenv('SECRET'));
        $accessToken = $accessHandler->generateReadToken();
        $requestMock = $this->createMock(Request::class);

        $requestMock->method("getHeaders")->willReturn([
            "Access-Token" => $accessToken,
            "Content-Type" => "application/json"
        ]);

        $requestMock->method("setMethod")->willReturn('POST');
        $requestMock->method("setRouter")->willReturn('CardsRouter');
        $requestMock->method("setUrlData")->willReturn(["cards", "sort"]);
        $requestMock->method("setFormData")->willReturn([]);

        $routerMock = $this->createMock(Router::class);

        $this->assertInstanceOf(RouterHandler::class, $routerMock->getRoute());
    }
}
