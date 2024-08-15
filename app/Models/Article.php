<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
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
        'quantite'
    ];

    function categories(){
        return $this->belongsToMany(Category::class);
    }

    function tags(){
        return $this->belongsToMany(Tag::class);
    }


    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }
}
