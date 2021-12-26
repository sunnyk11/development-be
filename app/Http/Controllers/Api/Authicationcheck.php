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
    public function  static_data(){
        try{
            $static_data_array=[];
            $bedroom=[['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5'],['number'=>'6'],['number'=>'7'],['number'=>'8'],['number'=>'9'],['number'=>'10']];
            $bathroom=[['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5'],['number'=>'6'],['number'=>'7'],['number'=>'8'],['number'=>'9'],['number'=>'10']];
            $balconies=[['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5'],['number'=>'6'],['number'=>'7'],['number'=>'8'],['number'=>'9'],['number'=>'10']];
            $area_unit=[['unit'=>'sq.ft.'],['unit'=>'sq.yards'],['unit'=>'sq.m.'],['unit'=>'acres'],['unit'=>'marla'],['unit'=>'cents'],['unit'=>'bigha'],['unit'=>'kottah'],['unit'=>'kanal'],['unit'=>'grounds'],['unit'=>'biswa'],['unit'=>'guntha'],['unit'=>'aankadam'],['unit'=>'hectares'],['unit'=>'rood'],['unit'=>'chataks'],['unit'=>'perch']];
            $property_type=[['id'=>1,'name'=>'Flat/ Apartment'],['id'=>2,'name'=>'Residential House'],['id'=>3,'name'=>'Builder Floor Apartment'],['id'=>4,'name'=>'Residential Land/ Plot'],['id'=>5,'name'=>'Penthouse'],['id'=>6,'name'=>'Studio Apartment'],['id'=>7,'name'=>'Commercial Office Space'],['id'=>8,'name'=>'Office in IT Park/ SEZ'],['id'=>9,'name'=>'Commercial Shop'],['id'=>10,'name'=>'Commercial Showroom'],['id'=>11,'name'=>'Commercial Land'],['id'=>12,'name'=>'Warehouse/ Godown'],['id'=>13,'name'=>'Industrial Land'],['id'=>14,'name'=>'Industrial Building'],['id'=>15,'name'=>'Industrial Shed'],['id'=>16,'name'=>'Agricultural Land'],['id'=>17,'name'=>'Farm House']];
            $addition_room=[['id'=>1,'name'=>'Pooja  Room'],['id'=>2,'name'=>'Study  Room'],['id'=>3,'name'=>'Servant  Room'],['id'=>4,'name'=>'Other  Room']];
            $facing_towards=[['direction'=>'East'],['direction'=>'North East'],['direction'=>'North'],['direction'=>'West'],['direction'=>'South'],['direction'=>'South-East'],['direction'=>'North West'],['direction'=>'South West']];
            $year_built=[['year'=>'2000'],['year'=>'2001'],['year'=>'2002'],['year'=>'2003'],['year'=>'2004'],['year'=>'2005'],['year'=>'2006'],['year'=>'2007'],['year'=>'2008'],['year'=>'2009'],['year'=>'2010'],['year'=>'2011'],['year'=>'2012'],['year'=>'2013'],['year'=>'2014'],['year'=>'2015'],['year'=>'2016'],['year'=>'2017'],['year'=>'2018'],['year'=>'2019'],['year'=>'2020'],['year'=>'2021'],['year'=>'2022']];
            $property_floor=[['number'=>'Ground Floor'],['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5'],['number'=>'6'],['number'=>'7'],['number'=>'8'],['number'=>'9'],['number'=>'10']];
            $total_floors=[['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5'],['number'=>'6'],['number'=>'7'],['number'=>'8'],['number'=>'9'],['number'=>'10']];
            $security_deposit=[['months'=>'1'],['months'=>'2'],['months'=>'3'],['months'=>'4'],['months'=>'5'],['months'=>'6']];
            $maintenance_charge_condition=[['id'=>1,'condition'=>'Monthly'],['id'=>2,'condition'=>'Annually'],['id'=>3,'condition'=>'One Time']];
            $parking_covered_count=[['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5']];
            $parking_open_count=[['number'=>'1'],['number'=>'2'],['number'=>'3'],['number'=>'4'],['number'=>'5']];
            $willing_to_rent=[['id'=>1,'value'=>'Family'],['id'=>2,'value'=>'Single Men'],['id'=>3,'value'=>'Single Women']];
            $month_of_notic=[['id'=>1,'months'=>'1'],['id'=>2,'months'=>'2'],['id'=>3,'months'=>'3'],['id'=>4,'months'=>'4'],['id'=>5,'months'=>'5'],['id'=>6,'months'=>'6']];
            $agreement_duration=[['id'=>1,'value'=>'One Year'],['id'=>2,'value'=>'Three Year'],['id'=>3,'value'=>'Custom']];
            $agreement_type=[['id'=>1,'value'=>'Company Lease Agreement'],['id'=>2,'value'=>'Any']];

            $static_data_array=['property_floor'=>$property_floor,'facing_towards'=>$facing_towards,'total_floors'=>$total_floors,'security_deposit'=>$security_deposit,'bedroom'=>$bedroom,'bathroom'=> $bathroom,'balconies'=>$balconies,'area_unit'=>$area_unit,'property_type'=>$property_type,'addition_room'=> $addition_room,'year_built'=>$year_built,'maintenance_charge_condition'=>$maintenance_charge_condition,'parking_covered_count'=>$parking_covered_count,'parking_open_count'=>$parking_open_count,'willing_to_rent'=>$willing_to_rent,'month_of_notic'=>$month_of_notic,'agreement_duration'=>$agreement_duration,'agreement_type'=>$agreement_type];
           return $static_data_array;
        }catch(\Exception $e) {
            return $this->getExceptionResponse($e);
        } 
        
    }
}
