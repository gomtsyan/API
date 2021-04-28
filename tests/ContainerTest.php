<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Src\Core\Container;
use Src\Core\Application;
use Src\Http\Request\Request;

class ContainerTest extends TestCase
{
    public function testCanCreateApplication()
    {
        $requestMock = $this->createMock(Request::class);
        $requestMock->method("getHeaders")->willReturn([]);
        $requestMock->method("getData")->willReturn($requestMock->getData());

        $this->assertInstanceOf(Application::class, (new Container())->createApplication());
    }
}
