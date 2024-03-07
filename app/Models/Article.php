<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory;
    
    use SoftDeletes;
    
    protected $fillable=[
        'category_id',
        'user_id',
        'article_title',
        'article_content',
        'article_slug',
        'article_hit',
        'article_status',
        'article_image'
    ];

    protected $table = 'articles';
    protected $primaryKey = 'article_id';

    public function getCategory()
    {
        return $this->hasOne('App\Models\Category','category_id','category_id');
    }
    
    public function getUser()
    {
        return $this->hasOne('App\Models\User','user_id','user_id');
    }
}
