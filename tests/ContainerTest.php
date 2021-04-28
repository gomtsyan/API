<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Src\Core\Container;
use Src\Core\Application;

class ContainerTest extends TestCase
{
    public function testCanCreateApplication()
    {
        $this->assertInstanceOf(Application::class, (new Container())->createApplication());
    }
}
