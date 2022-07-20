<?php

namespace App\Http\Controllers\Api;

use App\Models\offer_banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfferBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        try{
            $data=offer_banner::orderBy('id', 'desc')->paginate(7);
            return response()->json([
                'data' => $data
            ], 200); 
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
    }
    public function getoffer_banner_web()
    { 
        try{
            $data=offer_banner::where('banner_status','1')->paginate(7);
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
        // $request->validate([
        //     'tittle' => 'required',
        //     'status' => 'required|boolean',
        //     // 'start_date'=>'required',
        //     // 'end_date'=>'required',
        //     'text'=>'required'                       
        // ]);
        try{ 
            $offer_banner = new offer_banner([
            'tittle' => $request->tittle,
            'banner_status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'text'=>$request->text
            ]);

        $offer_banner->save();  
        return response() -> json([
                'message' => 'banner Created',
            ]);

        }catch(\Exception $e) {
            return $this->getExceptionResponse1($e);
        }
       
    }

    public function update_banner_id(Request $request){
        try{
            $data= offer_banner::where('id',  $request['banner_id'])->first();
               return response()->json([
                    'data' => $data
                ]);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }

    }

     public function banner_Update(Request $request)
    {
        //  $request->validate([
        //     'tittle' => 'required',
        //     'status' => 'required|boolean',
        //     // 'start_date'=>'required',
        //     // 'end_date'=>'required',
        //     'text'=>'required'                       
        // ]);

      try{
       offer_banner::where('id', $request->banner_id)->update(['tittle' => $request->tittle,'banner_status'=> $request->status,'start_date'=>$request->start_date,'end_date'=>$request->end_date,'text'=>$request->text]);
              return response()->json([
              'message' =>'data updated',
              'status'=>201
            ], 201);
        }catch(\Exception $e) {
              return $this->getExceptionResponse($e);
        } 
    }

    public function banner_status_changes(Request $request){
        // return $request->user_id;
        try{
            $request -> validate([
                    'banner_id' => 'required|integer'
                ]);
            $data= offer_banner::select('banner_status')->where('id', $request->banner_id)->first();
            if($data['banner_status']=='1'){
                offer_banner::where('id', $request->banner_id)->update(['banner_status' =>'0']);
            }else{
                offer_banner::where('id',$request->banner_id)->update(['banner_status' =>'1']);
            }
            return response()->json([
                'message' => 'Banner Status Changes',
                'status'=> 200
            ]);

           
         }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\offer_banner  $offer_banner
     * @return \Illuminate\Http\Response
     */
    public function show(offer_banner $offer_banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\offer_banner  $offer_banner
     * @return \Illuminate\Http\Response
     */
    public function edit(offer_banner $offer_banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\offer_banner  $offer_banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, offer_banner $offer_banner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\offer_banner  $offer_banner
     * @return \Illuminate\Http\Response
     */

    public function delete(Request $request)
    {
        try{
            offer_banner::where('id', $request['banner_id'])->delete();  
            return response()->json([
                'message' => 'deleted Successfully',
            ], 201);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }
    public function destroy(offer_banner $offer_banner)
    {
        //
    }
}
