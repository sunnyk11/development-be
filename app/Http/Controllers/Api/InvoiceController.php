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
            $data= invoices::select('products.id as product_id','products.build_name as product_name','invoices.*')
                   ->search($request)
                   ->leftjoin('products','products.product_uid','=','invoices.property_uid') 
                   ->paginate(20);
          
             return response()->json([
                                'data' => $data,
                                'status' => '200'
                            ], 200);

         }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        }         

    }
      public function search_data_excel(Request $request){
        try{
            $data= invoices::select('products.id as product_id','products.build_name as product_name','invoices.*')
                   ->search($request)
                   ->leftjoin('products','products.product_uid','=','invoices.property_uid') 
                   ->get();

            $excel_data= invoiceResource::collection($data);
          
             return response()->json([
                                'data' => $excel_data,
                                'status' => '200'
                            ], 200);

         }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        }         

    }
}
