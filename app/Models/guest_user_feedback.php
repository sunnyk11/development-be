<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
            $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $searchTerm->start_date);
            $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $searchTerm->end_date);
                $query->whereBetween('created_at', [$start_date,$end_date]);
        }
        // if ($searchTerm->start_date) {
        //     $start_date = $searchTerm->start_date;
        //     $query->where(function($query) use ($start_date){
        //         $query->where('created_at', '>=', $start_date);
        //     });
        // }
        // if ($searchTerm->end_date) {
        //     $end_date = $searchTerm->end_date;
        //     $query->where(function($query) use ($end_date){
        //         $query->where('created_at', '<=', $end_date);
        //     });
        // }
    }
    
}
