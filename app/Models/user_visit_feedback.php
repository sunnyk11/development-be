<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DateTimeInterface;

class user_visit_feedback extends Model
{
    use HasFactory;
     protected $fillable = [
        'star_rating','system_ip','device_info','message','status',
    ];
      protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

      public function scopeSearch($query, $searchTerm) {
        if ($searchTerm->start_date && $searchTerm->end_date) {
          $start_date_modified=$searchTerm->start_date." 00:00:00";
          $end_date_modified=$searchTerm->end_date." 23:59:59";

          $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date_modified);
          $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $end_date_modified);
          $query->whereBetween('created_at', [$start_date,$end_date]);
        }
    }

}
