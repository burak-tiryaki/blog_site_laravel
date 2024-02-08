<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    public function getArticleCount()
    {
        return $this->hasMany('App\Models\Article','category_id','category_id')->count();
    }
}
