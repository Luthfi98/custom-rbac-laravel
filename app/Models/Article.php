<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function category()
    {
        return $this->hasOne(CategoryArticle::class, 'id', 'category_article_id');
    }


    public function tag()
    {
        return $this->hasMany(TagingArticle::class,'article_id', 'id');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function editor()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function publisher()
    {
        return $this->hasOne(User::class, 'id', 'published_by');
    }
}
