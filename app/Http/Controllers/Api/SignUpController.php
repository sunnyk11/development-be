<?php

namespace App\Http\Controllers\Api;

use App\Models\sign_up;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Twilio\Rest\Client;
use App\Models\crmApiCalls;
use Illuminate\Support\Facades\Http;

class SignUpController extends Controller
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
        return $request->all();
    }
    
    public function sign_up_otp_send(Request $request)
    {  
            $request->validate([
                'mobile_no' => "required|numeric|digits:10|unique:users,other_mobile_number",
                'user_name' => 'required|string',
                'sign_up_page' => 'required|string'
           ]);  
        
        try{
           $sign_up_user = sign_up::where(['mobile_no'=> $request['mobile_no']])->first();
            if($sign_up_user){
                if($sign_up_user->status==0){
                    $user_data= sign_up::where('mobile_no',  $request['mobile_no'])->whereDate('verify_code_created_at', Carbon::today())->first();
                    if($user_data){
                        return response()->json([
                            'message' => 'verification code updated',
                            'status' => '201',
                            'verify_code'=> $user_data->verify_code
                        ], 200);
                    }else{
                        $verify_code = Carbon::now()->format('mdhis'); 
                            $todayDate =  Carbon::now()->format('Y-m-d H:i:s');
                            $sign_up_user = sign_up::where(['mobile_no'=> $request['mobile_no'],'status'=>'0'])->update(['verify_code'=>$verify_code ,'verify_code_created_at'=>$todayDate]);
                            
                            return response()->json([
                                'message' => 'verification code updated',
                                'status' => '201',
                                'verify_code'=> $verify_code
                            ], 200);
                    }
                    
                }else{                
                    return response()->json([
                        'message' => 'user already sign up',
                        'status' => '200',
                    ], 200);
                }
    
            }else{
                $token = getenv("TWILIO_AUTH_TOKEN");
                $twilio_sid = getenv("TWILIO_SID");
                $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
                $twilio = new Client($twilio_sid, $token);
                $twilio->verify->v2->services($twilio_verify_sid)
                    ->verifications
                    ->create("+91".$request['mobile_no'], "sms");
    
                return response()->json([
                    'message' => 'OTP Sent',
                    'status' => '200',
                    'mobile_no'=> $request['mobile_no']
                ], 200);
    
            }

        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 
    }
    
    public function user_otp_resend(Request $request)
    {    
            $request->validate([
                'mobile_no' => "required|numeric|digits:10|unique:users,other_mobile_number",
                 ]);
        
        try{

                $token = getenv("TWILIO_AUTH_TOKEN");
                $twilio_sid = getenv("TWILIO_SID");
                $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
                $twilio = new Client($twilio_sid, $token);
                $twilio->verify->v2->services($twilio_verify_sid)
                    ->verifications
                    ->create("+91".$request['mobile_no'], "sms");
    
                return response()->json([
                    'message' => 'OTP Resend Successfully',
                    'status' => '200',
                    'mobile_no'=> $request['mobile_no']
                ], 200);
    

        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 
    }
    public function sign_up_verify_otp(Request $request) {
        
            $data = $request->validate([
                'verification_code' => ['required', 'numeric'],
                'mobile_no' => 'required|numeric|digits:10'
            ]);
        try{

            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);
            $verification = $twilio->verify->v2->services($twilio_verify_sid)
                ->verificationChecks
                ->create($data['verification_code'], array('to' => "+91".$data['mobile_no']));

            if ($verification->valid) {
                $verify_code = Carbon::now()->format('mdhis'); 
                $todayDate =  Carbon::now()->format('Y-m-d H:i:s');                    
               $user_data=[
                   'user_name'=>$request->form_data['user_name'],
                   'mobile_no'=>$request->form_data['mobile_no'],
                   'sign_up_page'=>$request->form_data['sign_up_page'],
                   'verify_code'=>$verify_code,
                   'verify_code_created_at'=>$todayDate,
                   'user_aggree'=>$request->form_data['tnc_check']
               ];
               
           sign_up::create($user_data);
            $crmp_api = getenv("crmp_api");
            $response = Http::post($crmp_api, [
                'BuyerEmail' => 'newlead1@housingstreet.com',
                'PhoneNo' => $request->form_data['mobile_no'],
                'BuyerName' => $request->form_data['user_name'],
                'Source' => 'Web',
                'LeadCreatedFrom' => 'WEBSITEUSER'
            ]);

            return response()->json([
                'message' => 'Successfully created',
                'verify_code' => $verify_code,
                'status'=>200,
                'message1' => 'Successfully verified',
                'response_success' => $response->successful(),
                'response_fail' => $response->failed(),
                'response_client_error' => $response->clientError(),
                'response_server_error' => $response->serverError(),
                'response_body' => $response->body()
            ], 201);

               


            }else{
                return response()->json([
                    'message' => 'verification error',
                    'status'=>401
                ], 401);

            }
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sign_up  $sign_up
     * @return \Illuminate\Http\Response
     */
    public function show(sign_up $sign_up)
    {
        //
    }
    
    public function sign_up_user_details(Request $request)
    {
        try{
            $user_details= sign_up::where(['verify_code'=> $request['verify_code'],'status'=> '0'])->whereDate('verify_code_created_at', Carbon::today())->first();
          
           if($user_details) {
                $array= explode(" ",$user_details['user_name']);
                return response()->json([
                    'data' => $user_details,
                    'user_name'=>array_values(array_filter($array))
                ]);

           } else{
            return response()->json([
                    'data' => $user_details
                ]);

           }
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sign_up  $sign_up
     * @return \Illuminate\Http\Response
     */
    public function edit(sign_up $sign_up)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sign_up  $sign_up
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sign_up $sign_up)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sign_up  $sign_up
     * @return \Illuminate\Http\Response
     */
    public function destroy(sign_up $sign_up)
    {
        //
    }
}
