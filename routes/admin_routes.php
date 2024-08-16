<?php
use Illuminate\Support\Facades\Route;


Route::prefix('cpadmin')->group(function () {

    Route::get('/', [\App\Http\Controllers\TableauBordController::class,'liste'])->name('tableau_de_bord.liste');

    Route::group(['prefix' => 'articles', 'controller' => \App\Http\Controllers\ArticleController::class], function () {
        Route::get('/', 'liste')->name('articles.liste');
        Route::get('/{id}/afficher', 'afficher')->name('articles.afficher');
        Route::get('/ajouter', 'ajouter')->name('articles.ajouter');
        Route::post('/', 'sauvegarder')->name('articles.sauvegarder');
        Route::get('/{id}/modifier', 'modifier')->name('articles.modifier');
        Route::put('/{id}', 'mettre_a_jour')->name('articles.mettre_a_jour');
        Route::delete('/{id}', 'supprimer')->name('articles.supprimer');
        Route::get('load/{media}', 'load')->name('articles.load');
        Route::get('/upload}', 'upload')->name('articles.upload');
        Route::get('/articles-select', 'articles_select')->name('articles.select');



    });

    Route::group(['prefix' => 'categories', 'controller' => \App\Http\Controllers\CategoryController::class], function () {
        Route::get('/', 'liste')->name('categories.liste');
        Route::get('/{id}/afficher', 'afficher')->name('categories.afficher');
        Route::get('/ajouter', 'ajouter')->name('categories.ajouter');
        Route::post('/', 'sauvegarder')->name('categories.sauvegarder');
        Route::get('/{id}/modifier','modifier')->name('categories.modifier');
        Route::put('/{id}', 'mettre_a_jour')->name('categories.mettre_a_jour');
        Route::delete('supprimer/{id}','supprimer')->name('categories.supprimer');
        Route::get('/categories-select', 'categories_select')->name('categories.select');

    });


    Route::group(['prefix' => 'utilisateurs','controller' => \App\Http\Controllers\UserController::class], function (){
        Route::get('/','liste')->name('utilisateurs.liste');
        Route::get('ajouter','ajouter')->name('utilisateurs.ajouter');
        Route::post('sauvegarder','sauvegarder')->name('utilisateurs.sauvegarder');
        Route::put('mettre_a_jour/{id}','mettre_a_jour')->name('utilisateurs.mettre_jour');
        Route::get('modifier/{id}','modifier')->name('utilisateurs.modifier');
        Route::delete('supprimer/{id}','supprimer')->name('utilisateurs.supprimer');
    });


    Route::group(['prefix' => 'tags','controller' => \App\Http\Controllers\TagController::class], function (){
        Route::get('/', 'liste')->name('tags.liste');
        Route::get('/{id}/afficher', 'afficher')->name('tags.afficher');
        Route::get('/ajouter', 'ajouter')->name('tags.ajouter');
        Route::post('/', 'sauvegarder')->name('tags.sauvegarder');
        Route::get('/{id}/modifier','modifier')->name('tags.modifier');
        Route::put('/{id}', 'mettre_a_jour')->name('tags.mettre_a_jour');
        Route::delete('supprimer/{id}','supprimer')->name('tags.supprimer');
        Route::get('/tags-select', 'tags_select')->name('tags.select');
    });
    Route::group(['prefix' => 'commandes','controller' => \App\Http\Controllers\CommandeController::class], function (){
        Route::get('/','liste')->name('commandes.liste');
        Route::get('ajouter','ajouter')->name('commandes.ajouter');
        Route::post('sauvegarder','sauvegarder')->name('commandes.sauvegarder');
        Route::put('mettre_a_jour/{id}','mettre_a_jour')->name('commandes.mettre_jour');
        Route::get('modifier/{id}','modifier')->name('commandes.modifier');
        Route::delete('supprimer/{id}','supprimer')->name('commandes.supprimer');
        Route::get('/afficher/{id}','afficher')->name('commandes.afficher');
        Route::get('/status/{id}','status_modal')->name('commandes.status_modal');
        Route::post('/status/{id}','modifier_status')->name('commandes.modifier_status');
    });

});

