<?php

namespace Database\Seeders;

use App\Models\Slider;
use App\Models\SliderOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        // Check if there are any existing sliders
        if (Slider::count() == 0) {
            // Create a new slider entry
            $slider = Slider::create([
                'transition_time' => 4000,
                'autoplay' => false,
                'autoplay_interval' => 3000,
            ]);

            // Add the first image to the media library
            $media1 = $slider->addMedia(public_path('images/Carousel-1.jpg'))->preservingOriginal()->toMediaCollection('sliders');

            // Add the second image to the media library
            $media2 = $slider->addMedia(public_path('images/Carousel-2.jpg'))->preservingOriginal()->toMediaCollection('sliders');

            // Create slider orders and associate with media
            SliderOrder::create([
                'slider_id' => $slider->id,
                'image_id' => $media1->id,
                'order' => 1,
            ]);

            SliderOrder::create([
                'slider_id' => $slider->id,
                'image_id' => $media2->id,
                'order' => 2,
            ]);
        }
    }

}
