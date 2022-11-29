<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected  $guarded=['id'];
    public function postCategory(){
        return $this->belongsTo(PostCategory::class,'post_category_id');
    }
}
