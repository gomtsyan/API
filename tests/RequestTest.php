<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Src\Http\Request\Request;

class RequestTest extends TestCase
{
    public function testRequestData()
    {
        $requestMock = $this->createMock(Request::class);

        $requestMock->method("setMethod")->willReturn('GET');
        $requestMock->method("setRouter")->willReturn('AccessRouter');
        $requestMock->method("setUrlData")->willReturn([]);
        $requestMock->method("setFormData")->willReturn([]);

        $this->assertIsString($requestMock->getMethod());
        $this->assertIsString($requestMock->getRouter());
        $this->assertIsArray($requestMock->getUrlData());
        $this->assertIsArray($requestMock->getFormData());
    }
}
