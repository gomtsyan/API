<?php

namespace Src\Routes;

use Src\Helpers\Utils;
use Src\Http\Request\Request;
use Src\Http\Response\Response;
use Src\Http\Controllers\AccessController;

class AccessRouter extends RouterHandler
{
    /**
     * Run AccessRouter.
     *
     * @param  Request $request
     * @return Response
     */
    public function route(Request $request): Response
    {
        $headers = ["Content-Type" => "application/json"];
        //GET: /access
        if ($request->method === 'GET' && count($request->urlData) === 1 && count($request->formData) === 0) {
            $responseData = AccessController::createReadAccessToken($this->accessHandler);

            return Response::fromParameters(json_encode($responseData), $headers);
        }

        Utils::throwHttpError('INVALID_PARAMETERS', 'Invalid parameters');
    }
}
