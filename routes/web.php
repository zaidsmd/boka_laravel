<?php

require_once __DIR__ . '/modules/back_office.php';
require_once __DIR__ . '/modules/front_office.php';
require_once __DIR__ . '/modules/emails.php';
\Illuminate\Support\Facades\Route::get('patch/status',function (){
    return \App\Models\Article::whereNull('status')->update(['status' => 'published']) . ' Articles Affected';
});
