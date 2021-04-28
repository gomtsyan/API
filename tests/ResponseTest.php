<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Src\Http\Response\Response;

class ResponseTest extends TestCase
{
    public function testCanGetResponseAsString()
    {
        $this->assertSame("Hello", (string) Response::fromParameters("Hello", []));
    }

    public function testCanGetHeaders()
    {
        $this->assertSame(
            "application/json",
            Response::fromParameters("Hello", ["Content-Type" => "application/json"])->getHeaders()["Content-Type"]
        );
    }
}
