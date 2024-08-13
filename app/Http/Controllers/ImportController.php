<?php

namespace App\Http\Controllers;

use App\Models\Article;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    function import(){
        $filePath = Storage::path('imports/articles.csv');
        if (($handle = fopen($filePath, 'r')) !== false) {
            // Read the CSV data line by line
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {

                // Parse the data from CSV (assuming the structure you provided)
                $slug = $data[0];
                $title = $data[1];
                $short = $data[2];
                $desc = $data[3];
                $salePrice = $data[4];
                $price = $data[5];
                $categories = explode(', ', $data[6]);
                $images = explode(', ', $data[7]);

                // Insert the article into the database
                $article = Article::create([
                    'slug' => $slug,
                    'title' => $title,
                    'short_description' => $short,
                    'description' => $desc,
                    'sale_price' =>  $salePrice === "" ? null : $salePrice,
                    'price' => $price,
                ]);

                // Handle categories (assuming the categories table and pivot table are set up)
                $categoryIds = [];
                foreach ($categories as $categoryName) {
                    $category = \App\Models\Category::firstOrCreate(['name' => $categoryName,'slug'=>Str::slug($categoryName)]);
                    $categoryIds[] = $category->id;
                }
                $article->categories()->sync($categoryIds);

                // Handle images using Spatie Media Library
                foreach ($images as $key => $imageUrl) {
                    if ($key == 0){
                        $article->addMediaFromUrl($imageUrl)->toMediaCollection('principal');
                    }
                    $article->addMediaFromUrl($imageUrl)->toMediaCollection('images');
                }
            }

            // Close the file
            fclose($handle);
        }
    }
}
