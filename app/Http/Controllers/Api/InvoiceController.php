<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\invoices;
use App\Http\Resources\API\invoiceResource;

class InvoiceController extends Controller
{
   

    public function search_data(Request $request){
    	// return invoices::search($request)->toSql();
    	try{
            return invoiceResource::collection(invoices::search($request)->paginate(20));

         }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        } 
                
        

    }
}
