<?php

namespace App\Http\Controllers;

use Response;

/**
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message, $code = 200)
    {
        return Response::json($result , $code,[], JSON_NUMERIC_CHECK);
    }

    public function sendError($error, $code = 404)
    {
        return Response::json($error, $code);
    }
}
