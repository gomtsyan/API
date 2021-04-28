<?php

namespace Src\Routes;

use Src\Helpers\Utils;
use Src\Http\Controllers\CardsController;
use Src\Http\Request\Request;
use Src\Http\Response\Response;

class CardsRouter extends RouterHandler
{
    /**
     * Run SortRouter.
     *
     * @param  Request $request
     * @return Response
     */
    public function route(Request $request): Response
    {
        $this->ensureHasReadAccess($request);
        $this->checkContentType($request);
        $headers = ["Content-Type" => "application/json"];

        // POST: /cards/sort
        if ($request->method === 'POST' &&
            $request->urlData[1] === 'sort' &&
            count($request->urlData) === 2 &&
            count($request->formData) > 0) {
            $responseData = CardsController::sort($request->formData);

            return Response::fromParameters(json_encode($responseData), $headers);
        }

        Utils::throwHttpError('INVALID_PARAMETERS', 'Invalid parameters');
    }
}
