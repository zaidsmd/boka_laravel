<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Article */
class ArticleCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->transform(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'price' => $article->price,
                    'sale_price' => $article->sale_price,
                    'media_url' => $article->getFirstMediaUrl('principal'),
                    // Add any custom fields here
                    'formatted_price' => number_format($article->price, 2, ',', ' '),
                    'formatted_sale_price' => $article->sale_price ? number_format($article->sale_price, 2, ',', ' ') : null,
                    'is_on_sale' => $article->sale_price !== null,
                ];
            }),
        ];
    }
}
