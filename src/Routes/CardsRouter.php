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
        $data = $request->getData();
        $this->ensureHasReadAccess($request);
        $this->checkContentType($request);
        $headers = ["Content-Type" => "application/json"];

        // POST: /cards/sort
        if ($data['method'] === 'POST' &&
            $data['urlData'][1] === 'sort' &&
            count($data['urlData']) === 2 &&
            count($data['formData']) > 0) {
            $responseData = CardsController::sort($data['formData']);

            return Response::fromParameters(json_encode($responseData), $headers);
        }

        Utils::throwHttpError('INVALID_PARAMETERS', 'Invalid parameters');
    }
}
