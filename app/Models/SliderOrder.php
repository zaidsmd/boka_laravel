<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SliderOrder extends Model
{

    use HasFactory;

    protected $table = 'slider_order';
    protected $fillable = [ 'slider_id', 'image_id', 'order'];

    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}



