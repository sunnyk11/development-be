<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Auth;


class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
       $data=Wishlist::where('status', '1')->where('user_id',$user_id)->with('productdetails')->orderBy('id', 'asc')->get();
        return response()->json([
            'data' => $data
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
        $product_id=$request->param['id'];
        // user fetch using databse
        $user_id = Auth::user()->id;
        // fetch details user product db        
        $Wishlist = Wishlist::where('user_id',$user_id)->where('product_id',$product_id)->get();
        $count = count($Wishlist);

        if($count==0){
            $Wishlist_data = [
                'user_id' => $user_id,
                'product_id' => $product_id,
            ];
            Wishlist::create($Wishlist_data);

        return response()->json([
                'message' => 'Successfully Add Wishlist',
                'status'  => 200
            ], 201);

        }else{
          return response()->json([
            'data' =>$Wishlist,
        ], 201);           
        }
    }
   public function Crm_store(Request $request)
    {
        try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                $request -> validate([
                    'product_id' => 'required|integer',
                    'user_id' => 'required|integer'
                ]);
                $product_id=$request->product_id;
                $user_id = $request->user_id;
                // fetch details user product db        
                $Wishlist = Wishlist::where(['user_id'=>$user_id,'product_id'=>$product_id])->get();
                // dd($Wishlist);
                $count = count($Wishlist);

                if($count==0){
                    $Wishlist_data = [
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                    ];
                    Wishlist::create($Wishlist_data);

                return response()->json([
                        'message' => 'Successfully Add Wishlist',
                        'status'  => 200
                    ]);

                }else{
                  return response()->json([
                    'data' =>'Already Added',
                    'status'=>200
                ]);           
                }
            } else{                
                return response() -> json([
                    'message' => 'Failure',
                    'description'=>'Unauthication',
                    'status'=> 401,
                ]);
            }
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }  
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
          
    }
     public function delete(Request $request)
    {
        $product_id=$request->param['id'];
        $user_id = Auth::user()->id;
        $whereArray = array('user_id'=>$user_id,'product_id'=>$product_id);
      $data= Wishlist::where($whereArray)->delete();
            return response()->json([
                'message' => 'Wishlist Successfully Deleted ',
            ], 201);

    }

     public function crm_delete(Request $request)
    {
        try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                $request -> validate([
                    'product_id' => 'required|integer',
                    'user_id' => 'required|integer'
                ]);
                $product_id=$request->product_id;
                $user_id = $request->user_id;
                $data= Wishlist::where(['user_id'=>$user_id,'product_id'=>$product_id])->delete();
                    return response()->json([
                        'message' => 'Wishlist Successfully Deleted ',
                        'status'=> 200
                    ]);
            } else{                
                return response() -> json([
                    'message' => 'Failure',
                    'description'=>'Unauthication',
                    'status'=> 401,
                ]);
            }
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }

    }
}
