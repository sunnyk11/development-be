<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\property_room;

class PropertyRoomController extends Controller
{
    public function index()
    {
        try{
            $data=property_room::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
            return response()->json([
                'data' => $data
            ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 
    }
}
