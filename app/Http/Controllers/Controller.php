<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function RespondWithSuccess($massage = '', $data = [], $code)
    {
        return response()->json([
            'success' => true,
            'message' => $massage,
            'data' => $data,
        ], $code);
    }
    public function RespondWithEorror($massage='' , $data=null, $code)
    {

        return response()->json([
            'error' => true,
            'message' => $massage,
            'data' => $data,
        ], $code);
    }
}
