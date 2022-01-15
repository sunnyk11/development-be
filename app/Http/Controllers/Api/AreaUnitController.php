<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\area_unit;

class AreaUnitController extends Controller
{
	 public function index()
    {
        try{
            $data=area_unit::select('id','unit','status')->where('status', '1')->orderBy('id', 'asc')->get();
            return response()->json([
                'data' => $data
            ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 
    }
    
}
