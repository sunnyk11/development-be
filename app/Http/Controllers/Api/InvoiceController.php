<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\invoices;
use App\Http\Resources\API\invoiceResource;

class InvoiceController extends Controller
{
   

    public function search_data(Request $request){
    	try{
            $data= invoices::select('products.id as product_id' ,'products.build_name as product_name', 'invoices.*')
                   ->search($request)
                   ->leftjoin('products','products.product_uid','=','invoices.property_uid') 
                   ->paginate(20);
            $excel_data= invoices::select('products.id as product_id','products.build_name as product_name', 'invoices.*')
                    ->search($request)
                    ->leftjoin('products','products.product_uid','=','invoices.property_uid')
                    ->get();
            $data1= invoiceResource::collection($data);
            $excel_data1= invoiceResource::collection($excel_data);
             return response()->json([
                                'data' => $data,
                                'excel_data'=>$excel_data1,
                                'status' => '200'
                            ], 200);

         }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        }         

    }
}
