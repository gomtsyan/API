<?php

namespace Src\Routes;

use Src\Helpers\Utils;
use Src\Http\Request\Request;
use Src\Http\Response\Response;
use Src\Security\AccessHandler;

abstract class RouterHandler
{
    /**
     * @var AccessHandler
     */
    protected AccessHandler $accessHandler;

    /**
     * Create an instance of RouterHandler.
     *
     * @param  AccessHandler $accessHandler
     */
    public function __construct(AccessHandler $accessHandler)
    {
        $this->accessHandler = $accessHandler;
    }

    /**
     * Run router.
     *
     * @param  Request $request
     * @return Response
     */
    abstract public function route(Request $request): Response;

    /**
     * Checking read access.
     *
     * @param Request $request
     */
    protected function ensureHasReadAccess(Request $request)
    {
        $token = $this->getAccessToken($request);

        if (!$this->accessHandler->hasReadAccess($token)) {
            Utils::throwHttpError('INCORRECT_ACCESS_TOKEN', 'Access denied.');
        }
    }

    /**
     * Checking read and write access.
     *
     * @param Request $request
     */
    protected function ensureHasReadAndWriteAccess(Request $request)
    {
        $token = $this->getAccessToken($request);

        if (!$this->accessHandler->hasReadAndWriteAccess($token)) {
            Utils::throwHttpError('INCORRECT_ACCESS_TOKEN', 'Access denied.');
        }
    }

    /**
     * Get access token.
     *
     * @param Request $request
     * @return string
     */
    private function getAccessToken(Request $request): string
    {
        $headers = $request->getHeaders();

        if (!array_key_exists("Access-Token", $headers)) {
            Utils::throwHttpError('ACCESS_TOKEN_NOT_FOUND', 'Access-Token not found in request headers.');
        }

        return $headers['Access-Token'];
    }

    /**
     * Check Content Type.
     *
     * @param Request $request
     */
    protected function checkContentType(Request $request)
    {
        $headers = $request->getHeaders();

        if (!array_key_exists("Content-Type", $headers)) {
            Utils::throwHttpError('CONTENT_TYPE_NOT_FOUND', 'Content-Type not found in request headers.');
        } else {
            if ($headers['Content-Type'] !== 'application/json') {
                Utils::throwHttpError('INVALID_CONTENT_TYPE', 'Content-Type will be application/json.');
            }
        }
    }
}
