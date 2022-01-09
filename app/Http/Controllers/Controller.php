<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     public function getExceptionResponse($e){
        return response()->json([
            'message'   => $e->getMessage(),
            'status'    => 404,
        ]);
    }
    public function getExceptionResponse1($e){
        return response()->json([
            'message'   => 'FAIL',
            'status'    => 404,
        ]);
    }

}
