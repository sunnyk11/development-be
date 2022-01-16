<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
		'last_name',
		'gender',		 
		'userSelect_type',
        'email',
        'usertype',
        'profile_pic',
        'company_name',
        'company_url',
        'address',
        'city',
        'other_mobile_number',
        'landline_number',
        'company_profile',
        'pan_number',
        'aadhar_number',
        'provided_service',
        'place_of_practice',
        'price_for_service',
        'law_firm_number',
        'practice_number',
        'password',
        'user_role',
        'internal_user',
        'branch',
        'area_names'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function bank_details_history(){
        return $this->hasMany('App\Models\user_bank_details_history', 'user_id','id')->where(['status'=>'1'])->orderBy('id', 'desc')->take(5);
    }

    public function productdetails()
    {
        return $this->hasMany('App\Models\product', 'user_id','id')->with('amenities','product_comp','product_img','property_room','product_wishlist_crm','letout_invoice', 'rent_invoice')->where(['delete_flag'=> '0'])->orderBy('id', 'desc');
    }
    public function product_wishlist(){

        return $this->hasMany('App\Models\Wishlist', 'user_id','id')->with('product_name')->where('status', '1');
    }

	public function roles() {
        return $this->belongsToMany(Role::class, 'user_roles_pivot', 'user_id', 'role_id')->with('permissions');
    }
						 
}
