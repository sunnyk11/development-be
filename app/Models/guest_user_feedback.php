<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guest_user_feedback extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id','product_id','stars','subject','content','status'];
    
    public function UserDetail()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }

    public function scopeSearch($query, $searchTerm) {

        if ($searchTerm->start_date && $searchTerm->end_date) {
            $start_date = $searchTerm->start_date;
            $end_date = $searchTerm->end_date;
                $query->where('created_at', '>=', $start_date)
                      ->orWhere('created_at', '<=', $end_date);
            // );
        }
        // if ($searchTerm->end_date) {
        //     $end_date = $searchTerm->end_date;
        //     $query->where(function($query) use ($end_date){
        //         $query->where('expected_pricing', '<=', $end_date)
        //               ->orWhere('expected_rent', '<=', $end_date);
        //     });
        // }
    }
    
}
