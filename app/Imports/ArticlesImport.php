<?php

namespace App\Imports;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Storage;

class ArticlesImport implements ToCollection, WithHeadingRow, WithChunkReading,SkipsEmptyRows
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Parse the data from CSV
            $slug = $row['slug'];
            $title = $row['title'];
            $short = $row['short'];
            $desc = $row['desc'];
            $salePrice = $row['sale_price'];
            $price = $row['price'];
            $categories = explode(', ', $row['categories']);
            $images = explode(', ', $row['images']);

            // Insert the article into the database
            $article = Article::create([
                'slug' => $slug,
                'title' => $title,
                'short_description' => $short,
                'description' => $desc,
                'sale_price' => $salePrice === "" ? null : $salePrice,
                'price' => $price,
            ]);

            // Handle categories and tags
            $categoryIds = [];
            $tagIds = [];
            foreach ($categories as $categoryName) {
                if (in_array($categoryName, ['6-9 سنوات', '9-12 سنوات', '0-3 سنوات', '3-6 سنوات', '12-15 سنوات', '16+ سنوات', 'الوالدية'])) {
                    $tag = Tag::firstOrCreate(['name' => $categoryName, 'type' => 'فئة-عمرية', 'slug' => arabic_slug($categoryName)]);
                    $tagIds[] = $tag->id;
                } else {
                    $category = Category::firstOrCreate(['name' => $categoryName, 'slug' => arabic_slug($categoryName)]);
                    $categoryIds[] = $category->id;
                }
            }
            $article->categories()->sync($categoryIds);
            $article->tags()->sync($tagIds);

            // Handle images using Spatie Media Library
            foreach ($images as $key => $imageUrl) {
                if ($key == 0) {
                    $article->addMediaFromUrl($imageUrl)->toMediaCollection('principal');
                }
                $article->addMediaFromUrl($imageUrl)->toMediaCollection('images');
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000; // Adjust chunk size based on your needs
    }
}
