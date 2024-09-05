<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeArticle extends Model
{
    use HasFactory;
    protected $fillable =['article_id', 'type' ,'display_order' ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

}
