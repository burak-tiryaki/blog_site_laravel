<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = ['category_name','category_slug','category_status'];
    
    public function getArticleCount($where=array())
    {
        return $this->hasMany('App\Models\Article','category_id','category_id')
                    ->where($where)
                    ->count();
    }
}
