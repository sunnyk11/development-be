<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class Authicationcheck extends Controller
{
    public function  authication_check($token){
        try{
            $webToken = date('d:m:Y') . '-housingstreet';
            $ciphering ="AES-256-CBC";
            $option=0;
            $decryption_iv="JaNdRgUkXp2s5v8y/B?E(G+KbPeShVmY";
            $decryption_key="hWmYq3t6w9z*C&F)";
            $token_decrypted =openssl_decrypt(str_replace("Bearer ","",$token), $ciphering,$decryption_iv,$option,$decryption_key);
            if($webToken == $token_decrypted){
                return true;
            }else{
                return false;
            }
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        }   
    }
}
