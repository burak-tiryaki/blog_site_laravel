<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable=['article_title','article_hit'];

    public function getCategory()
    {
        return $this->hasOne('App\Models\Category','category_id','category_id');
    }
    
    public function getUser()
    {
            
    }
}
