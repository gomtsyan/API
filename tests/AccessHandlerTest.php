<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Src\Security\AccessHandler;

/**
 * @covers \Src\Security\AccessHandler
 */
class AccessHandlerTest extends TestCase
{
    public function testCanGenerateReadToken()
    {
        $accessHandler = new AccessHandler('asdfghjkl;');
        $this->assertIsString($accessHandler->generateReadToken());
    }

    public function testCanCheckReadAccess()
    {
        $accessHandler = new AccessHandler('asdfghjkl;');
        $token = $accessHandler->generateReadToken();

        $this->assertTrue($accessHandler->hasReadAccess($token));
    }

    public function testCheckIsFalseWhenReadTokenInvalidFormat()
    {
        $accessHandler = new AccessHandler("super secret2");
        $this->assertFalse($accessHandler->hasReadAccess("token abc 321"));
    }
}
