<?php

namespace App\Http\Controllers\Api;

use App\Models\ServiceUserReviews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceImgReview;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Image;

class ServiceUserReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try{
            // return $db_img_length;
            if($request['data']['user_id']){
                ServiceUserReviews::where(['user_id'=> $request['data']['user_id'],'s_user_id'=> $request['data']['s_user_id']])->update(['stars' =>$request['data']['stars'],'content'=>$request['data']['content']]);
                return response()->json([
                    'message' => 'Review Updated',
                    'data'    => $request['data']['s_user_id'],
                ],201);
            }
            else{
            // return $request->all();
            $user_id=Auth::user()->id;            
                $review = new ServiceUserReviews([
                    'user_id' => Auth::user()->id,
                    's_user_id' => $request['data']['s_user_id'],
                    'stars' => $request['data']['stars'],
                    'content' => $request['data']['content'],
                ]);
                return $review;
                $review->save();
                $review_id=$review->id;
            // return $request->all();
                $DB_img=ServiceImgReview::where('user_id',$user_id)->where('service_id', $request['data']['s_user_id'])->get();
                // dd($DB_img);
                $db_img_length=count($DB_img);
                // product images functionalty
                if($db_img_length<5){
                    $product_image= $request->input('product_image');
                    $Product_img_length=count($product_image); 
                    if($Product_img_length>0){
                        foreach ($product_image as $value) {                    
                            $base64_image = $value; // your base64 encoded
                            @list($type, $file_data) = explode(';', $base64_image);
                            @list(, $file_data) = explode(',', $file_data);
                            $imageName = 'product_image_file/IMAGE'.Str::random(30).'.'.'png';
                            Storage::disk('public')->put($imageName, base64_decode($file_data));
                                $Product_images_data = [
                                    'user_id' =>Auth::user()->id,
                                    'service_id' => $review_id,
                                    'image' =>$imageName 
                                ];
                                // return $Product_images_data;
                            ServiceImgReview::create($Product_images_data);
                        }
                        
                    }
                }
                return response()->json([
                    'message' => 'Review Submitted',
                    'data'    => $request['data']['s_user_id'],
                ],201);
            }
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceUserReviews  $serviceUserReviews
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceUserReviews $serviceUserReviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceUserReviews  $serviceUserReviews
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceUserReviews $serviceUserReviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceUserReviews  $serviceUserReviews
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceUserReviews $serviceUserReviews)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceUserReviews  $serviceUserReviews
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceUserReviews $serviceUserReviews)
    {
        //
    }
}
