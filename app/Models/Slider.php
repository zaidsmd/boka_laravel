<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slider extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table ='parametres_slider';
    protected $fillable = [
        'transition_time',
        'autoplay',
        'autoplay_interval',
    ];


    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function sliderImages()
    {
        return $this->hasMany(SliderOrder::class)->orderBy('order_number');
    }


}
