<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;


class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $user_id = Auth::user()->id;
            $data=Wishlist::where('status', '1')->where('user_id',$user_id)->with('productdetails')->orderBy('id', 'asc')->get();
                return response()->json([
                    'data' => $data
                ], 200);
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
      } 
    }
    public function get_wishlist_userid(Request $request){
        // return $request->user_id;
        $request->validate([
            'user_id' => 'required|integer'
        ]);
       try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                $data=DB::table('wishlists')
                   ->select('wishlists.id as wishlist_id','wishlists.user_id','wishlists.product_id','products.build_name as property_name')
                   ->Join('products','products.id','=','wishlists.product_id')
                   ->where(['wishlists.user_id'=>$request->user_id,'status'=>'1'])
                   ->get();
                 if(count($data)>0){
                    return response()->json([
                         'message' =>'SUCCESS',
                         'data' => $data,
                         'status'=>200
                     ], 200);
                  }else{
                    return response()->json([
                         'message' =>'FAIL',
                         'description' => 'User Id is Invalid !!!...',
                         'status'=>200
                     ], 200);
                }
            }else{
                return response() -> json([
                    'message' => 'FAIL',
                    'description'=>'Unauthication',
                    'status'=> 401,
                ]);
            }     
        }catch(\Exception $e) {
            return $this->getExceptionResponse1($e);
      }  
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
            'message' => 'Wishlist Already ',
            'data' =>$Wishlist,
            'status'  => 200
        ], 201);           
        }
    }
   public function Crm_store(Request $request)
    {
        $request -> validate([
                'product_id' => 'required|integer',
                'user_id' => 'required|integer'
        ]);
        try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
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
                        'message' => 'SUCCESS ',
                        'description'=>'Successfully Add Wishlist',
                        'status'  => 200
                    ]);

                }else{
                  return response()->json([
                    'message' =>'SUCCESS',
                    'description'=>'Already Added',
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
            return $this->getExceptionResponse1($e);
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
        $request -> validate([
                    'product_id' => 'required|integer',
                    'user_id' => 'required|integer'
        ]);
        try{
            $token  = $request->header('authorization');
            $object = new Authicationcheck();
            if($object->authication_check($token) == true){
                
                $product_id=$request->product_id;
                $user_id = $request->user_id;
                $data= Wishlist::where(['user_id'=>$user_id,'product_id'=>$product_id])->delete();
                    return response()->json([
                        'message' =>'SUCCESS',
                        'description'=>'Wishlist Successfully Deleted',
                        'status'=>200
                    ]);
                    
            } else{                
                return response() -> json([
                    'message' => 'Failure',
                    'description'=>'Unauthication',
                    'status'=> 401,
                ]);
            }
        }catch(\Exception $e) {
            return $this->getExceptionResponse1($e);
        }

    }
}
