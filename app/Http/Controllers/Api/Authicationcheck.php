<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\property_room;
use App\Models\property_willing_rent_out;
use App\Models\property_maintenance_condition;
use App\Models\property_ageement_type;
use App\Models\property_ageement_duration;
use App\Models\area_unit;
use App\Models\Amenitie;
use App\Models\Property_type;
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
    public function  static_data(){
        try{
            $static_data_array=[];
            $bedroom=[['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5'],['number'=>'6'],['number'=>'7'],['number'=>'8'],['number'=>'9'],['number'=>'10']];
            $bathroom=[['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5'],['number'=>'6'],['number'=>'7'],['number'=>'8'],['number'=>'9'],['number'=>'10']];
            $balconies=[['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5'],['number'=>'6'],['number'=>'7'],['number'=>'8'],['number'=>'9'],['number'=>'10']];
            $area_unit=area_unit::select('id','unit','status')->where('status', '1')->orderBy('id', 'asc')->get();
            $property_type=Property_type::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();

              $addition_room=property_room::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
            $facing_towards=[['direction'=>'East'],['direction'=>'North East'],['direction'=>'North'],['direction'=>'West'],['direction'=>'South'],['direction'=>'South-East'],['direction'=>'North West'],['direction'=>'South West']];
            $year_built=[['year'=>'1990'],['year'=>'1991'],['year'=>'1992'], ['year'=>'1993'],['year'=>'1994'],['year'=>'1995'],['year'=>'1996'],['year'=>'1997'],['year'=>'1998'],['year'=>'1999'],['year'=>'2000'],['year'=>'2001'],['year'=>'2002'],['year'=>'2003'],['year'=>'2004'],['year'=>'2005'],['year'=>'2006'],['year'=>'2007'],['year'=>'2008'],['year'=>'2009'],['year'=>'2010'],['year'=>'2011'],['year'=>'2012'],['year'=>'2013'],['year'=>'2014'],['year'=>'2015'],['year'=>'2016'],['year'=>'2017'],['year'=>'2018'],['year'=>'2019'],['year'=>'2020'],['year'=>'2021'],['year'=>'2022']];
            $property_floor=[['number'=>'Ground Floor'],['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5'],['number'=>'6'],['number'=>'7'],['number'=>'8'],['number'=>'9'],['number'=>'10']];
            $total_floors=[['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5'],['number'=>'6'],['number'=>'7'],['number'=>'8'],['number'=>'9'],['number'=>'10']];
            $security_deposit=[['months'=>'1'],['months'=>'2'],['months'=>'3'],['months'=>'4'],['months'=>'5'],['months'=>'6']];
            $maintenance_charge_condition=property_maintenance_condition::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
            $parking_covered_count=[['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5']];
            $parking_open_count=[['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5']];
            $willing_to_rent=property_willing_rent_out::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
            $month_of_notic=[['id'=>1,'months'=>'1'],['id'=>2,'months'=>'2'],['id'=>3,'months'=>'3'],['id'=>4,'months'=>'4'],['id'=>5,'months'=>'5'],['id'=>6,'months'=>'6']];
             $agreement_duration=property_ageement_duration::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
            $agreement_type=property_ageement_type::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
            $amenities_data=Amenitie::select('id','name','IsEnable')->where('IsEnable', '1')->orderBy('id', 'asc')->get();

            $static_data_array=['amenities_data'=>$amenities_data,'property_floor'=>$property_floor,'facing_towards'=>$facing_towards,'total_floors'=>$total_floors,'security_deposit'=>$security_deposit,'bedroom'=>$bedroom,'bathroom'=> $bathroom,'balconies'=>$balconies,'area_unit'=>$area_unit,'property_type'=>$property_type,'addition_room'=> $addition_room,'year_built'=>$year_built,'maintenance_charge_condition'=>$maintenance_charge_condition,'parking_covered_count'=>$parking_covered_count,'parking_open_count'=>$parking_open_count,'willing_to_rent'=>$willing_to_rent,'month_of_notic'=>$month_of_notic,'agreement_duration'=>$agreement_duration,'agreement_type'=>$agreement_type];
           return $static_data_array;
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 
        
    }
    public function get_dropdown_data(){
        $property_room=property_room::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
        $property_willing_rent_out=property_willing_rent_out::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
        $property_maintenance_condition=property_maintenance_condition::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
        $property_ageement_type=property_ageement_type::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
        $property_ageement_duration=property_ageement_duration::select('id','name','status')->where('status', '1')->orderBy('id', 'asc')->get();
        $area_unit=area_unit::select('id','unit','status')->where('status', '1')->orderBy('id', 'asc')->get();
        $Amenitie=Amenitie::where('IsEnable', '1')->orderBy('id', 'asc')->get();
        return response()->json([
            'property_room' => $property_room,
            'property_willing_rent_out' => $property_willing_rent_out,
            'property_maintenance_condition' => $property_maintenance_condition,
            'property_ageement_type' => $property_ageement_type,
            'property_ageement_duration' => $property_ageement_duration,
            'area_unit' => $area_unit,
            'Amenitie' => $Amenitie,
        ], 200);
    }
}
