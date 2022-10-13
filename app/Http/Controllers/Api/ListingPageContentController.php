<?php

namespace App\Http\Controllers\Api;;

use App\Models\listing_page_content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListingPageContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        try{
            $data=listing_page_content::orderBy('id', 'desc')->paginate(7);
            return response()->json([
                'data' => $data
            ], 200); 
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
    }

    public function getheading_data()
    { 
        try{
            $data=listing_page_content::where('content_status','1')->orderBy('id', 'desc')->get();
            return response()->json([
                'data' => $data
            ], 200); 
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'status' => 'required|boolean',
            'text'=>'required'                       
        ]);
        try{ 
            $content_data = new listing_page_content([
            'content_status' => $request->status,
            'content'=>$request->text
            ]);

        $content_data->save();  
        return response() -> json([
                'message' => 'listing page heading Created',
            ]);

        }catch(\Exception $e) {
            return $this->getExceptionResponse1($e);
        }
       
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

public function heading_status_changes(Request $request){
        // return $request->user_id;
        try{
            $request -> validate([
                    'text_id' => 'required|integer'
                ]);
            $data= listing_page_content::select('content_status')->where('id', $request->text_id)->first();
            if($data['content_status']=='1'){
                listing_page_content::where('id', $request->text_id)->update(['content_status' =>'0']);
            }else{
                listing_page_content::where('id',$request->text_id)->update(['content_status' =>'1']);
            }
            return response()->json([
                'message' => 'heading Status Changes',
                'status'=> 200
            ]);

           
         }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }


     public function heading_Update(Request $request)
    {
         $request->validate([
            'status' => 'required|boolean',
            'text'=>'required',
            'text_id'=>'required',                       
        ]);

      try{
       listing_page_content::where('id', $request->text_id)->update(['content_status'=> $request->status,'content'=>$request->text]);
              return response()->json([
              'message' =>'data updated',
              'status'=>201
            ], 201);
        }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        } 
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\listing_page_content  $listing_page_content
     * @return \Illuminate\Http\Response
     */
    public function show(listing_page_content $listing_page_content)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\listing_page_content  $listing_page_content
     * @return \Illuminate\Http\Response
     */
    public function edit(listing_page_content $listing_page_content)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\listing_page_content  $listing_page_content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, listing_page_content $listing_page_content)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\listing_page_content  $listing_page_content
     * @return \Illuminate\Http\Response
     */
    public function destroy(listing_page_content $listing_page_content)
    {
        //
    }
    public function delete(Request $request)
    {
        try{
            listing_page_content::where('id', $request['id'])->delete();  
            return response()->json([
                'message' => 'deleted Successfully',
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
}
