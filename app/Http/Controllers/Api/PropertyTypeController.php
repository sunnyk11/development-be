<?php

namespace App\Http\Controllers\Api;

use App\Models\Property_type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\product;

class PropertyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Property_type::with('Product_type_count')->where('status', '1')->orderBy('id', 'asc')->get(); 

        $pro_type_count=[];
        foreach ($data as $key => $value) {
            $product_count= count($value['product_type_count']);
            if($product_count>0){
                $count=['id'=>$value['id'],'pro_count'=>$product_count,'pro_type'=>$value['name']];
                array_push($pro_type_count,$count);
            }
        }
        return response()->json([
            'data' => $data,
            'count'=>$pro_type_count 
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property_type  $property_type
     * @return \Illuminate\Http\Response
     */
    public function show(Property_type $property_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Property_type  $property_type
     * @return \Illuminate\Http\Response
     */
    public function edit(Property_type $property_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property_type  $property_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property_type $property_type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property_type  $property_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property_type $property_type)
    {
        //
    }
}
