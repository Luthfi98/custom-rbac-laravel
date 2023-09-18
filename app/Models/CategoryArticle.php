<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryArticle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function child(): HasMany
    {
        return $this->hasMany(CategoryArticle::class, 'parent_id', 'id');
    }
}
