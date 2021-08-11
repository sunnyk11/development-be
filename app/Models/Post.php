<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Post extends Model
{
    use HasFactory;
	use Sluggable;
	
	//protected $fillable = ['title', 'slug', 'description', 'image_path', 'avatar_path'];
	protected $fillable = ['title', 'views', 'slug', 'description', 'image_path', 'created_by', 'category'];
	
	public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
	
}
