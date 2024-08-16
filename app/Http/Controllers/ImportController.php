<?php

namespace App\Http\Controllers;

use App\Imports\ArticlesImport;
use App\Models\Article;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    function import($file){
        $filePath = Storage::path('imports/articles-'.$file.'.xlsx');
        Excel::import(new ArticlesImport, $filePath);

        echo  'done';
    }
}
