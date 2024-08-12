<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements HasMedia
{

    use InteractsWithMedia;
    protected $fillable = [
        'title',
        'slug',
        'price',
        'sale_price',
        'short_description',
        'description',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_category');
    }
}
