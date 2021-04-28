<?php

namespace Src\Http\Controllers;

use Src\Security\AccessHandler;

class AccessController extends CommonController
{
    /**
     * Create Read Access Token.
     *
     * @param AccessHandler $accessHandler
     * @return array
     */
    public static function createReadAccessToken(AccessHandler $accessHandler): array
    {
        return ['Access-Token' => $accessHandler->generateReadToken()];
    }
}
