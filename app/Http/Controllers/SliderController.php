<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\SliderOrder;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SliderController extends Controller
{
    public function liste(Request $request)
    {
        $slider = Slider::first();

        if ($slider) {

            $mediaItems = Media::select('media.*', 'slider_order.order', 'slider_order.url')
                ->join('slider_order', 'media.id', '=', 'slider_order.image_id')
                ->where('slider_order.slider_id', $slider->id)
                ->orderBy('slider_order.order')
                ->get();
;        } else {
            $mediaItems = collect();
        }        return view('back_office.sliders.liste',compact('slider', 'mediaItems'));
    }

    public function sauvegarder(Request $request)
    {
        $request->validate([
            'image_data' => 'required|json',
            'transition_time' => 'required|integer|min:0',
            'autoplay' => 'required|boolean',
        ]);

        $imageData = json_decode($request->input('image_data'), true);
        $slider = Slider::first();

        DB::beginTransaction();

        try {

            $slider->transition_time = $request->input('transition_time');
            $slider->autoplay = $request->input('autoplay');

            // Save the changes
            $slider->save();
            // Remove existing orders for the slider
            SliderOrder::where('slider_id', $slider->id)->delete();

            foreach ($imageData as $image) {
                $order = $image['order'];
                $base64String = $image['real_url'];
                $imageId = $image['id'];
                $fileName = $image['name'];
                $additional_url = $image['additional_url'];
                if (!$imageId) {
                    // New image: handle base64 encoding
                    $base64String = preg_replace('/^data:image\/\w+;base64,/', '', $base64String);
                    $base64String = str_replace(' ', '+', $base64String);
                    base64_decode($base64String); // Decode the base64 data

                    // Save the image and get the media instance
                    $media = $slider->addMediaFromBase64($base64String)
                        ->usingFileName($fileName)
                        ->toMediaCollection('sliders');

                    // Save the order
                    SliderOrder::create([
                        'slider_id' => $slider->id,
                        'image_id' => $media->id,
                        'url' => $additional_url,
                        'order' => $order
                    ]);

                } else {
                    // Existing image: update order
                    $media = $slider->getMedia('sliders')->firstWhere('id', $imageId);
                    if ($media) {
                        SliderOrder::updateOrCreate(
                            ['slider_id' => $slider->id, 'image_id' => $imageId],
                            ['order' => $order, 'url' => $additional_url] // Ensure URL is part of the update
                        );

                    }
                }
            }

            DB::commit();
            return redirect()->route('sliders.liste')->with('success', 'تم حفظ الشريط المتحرك بنجاح!');
        } catch (\Exception $e) {
            DB::rollback();
            // Log the error or handle it as needed
            Log::error('Error saving slider images: ' . $e->getMessage());
            return redirect()->route('sliders.liste')->with('error', 'حدث خطأ أثناء حفظ الشريط المتحرك.');
        }
    }



}
