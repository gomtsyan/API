<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Src\Http\Request\Request;

class RequestTest extends TestCase
{
    public function testCanHandleRequest()
    {
        $requestMock = $this->createMock(Request::class);
        $requestMock->method("getHeaders")->willReturn([]);
        $requestMock->method("getPath")->willReturn("/");
    }

    public function testCanGetRoute()
    {
    }
}
