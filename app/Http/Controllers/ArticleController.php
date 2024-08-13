<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Services\LimiteService;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ArticleController extends Controller
{



    public function admin(Request $request)
    {
        if ($request->ajax()) {
            $query = Article::with('categories');

            $table = DataTables::of($query);
            $table->addColumn(
                'selectable_td',
                function ($row) {
                    $id = $row['id'];
                    return '<input type="checkbox" class="row-select form-check-input" value="' . $id . '">';
                }
            )->addColumn('quantite', function ($row) {
                return $row->quantite;
            });
            $table->addColumn('actions', function ($row) {
                $crudRoutePart = 'articles';
                $show = 'afficher';
                $delete = 'supprimer';
                $edit = 'modifier';
                $id = $row->id;
                return view('partials.__datatable-action', compact('id', 'crudRoutePart', 'edit', 'delete', 'show'));
            });

            $table->rawColumns(['selectable_td', 'actions']);
            return $table->make();
        }
        return view('articles.admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function liste(Request $request)
    {
        if ($request->ajax()) {
            $query = Article::with('categories');
            $table = DataTables::of($query);
            $table->addColumn(
                'selectable_td',
                function ($row) {
                    $id = $row['id'];
                    return '<input type="checkbox" class="row-select form-check-input" value="' . $id . '">';
                }
            )->addColumn('quantite', function ($row) {
                return $row->quantite;
            });
            $table->addColumn('actions', function ($article) {
                return view('articles.partials.articles_actions', compact('article'))->render();
            });
            $table->editColumn('created_at', function ($row) {
                return Carbon::make($row->created_at)->toDateString();
            });
            $table->rawColumns(['actions']);
            return $table->make();
        }
        return view('articles.liste');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function ajouter()
    {
        $categories = Category::all();
        return view('articles.ajouter', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sauvegarder(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'titre' => 'required|string|max:255|unique:articles,title',
                'short_description' => 'required|string',
                'description' => 'required|string',
                'sale_price' => 'required|numeric',
                'price' => 'nullable|numeric',
                'categorie' => 'required|array',
            ]);


            if ($validator->fails()) {
                // Redirect back to the specified error page with validation errors and input data
                return redirect()->route('articles.ajouter')->withErrors($validator)->withInput();
            }
            // Créer l'article
            $article = Article::create([
                'title' => $request->get('titre'),
                'short_description' => $request->get('short_description'),
                'description' => $request->get('description'),
                'sale_price' => $request->get('sale_price'),
                'price' => $request->get('price') ?? null,
                'slug' =>$request->get('titre'),
            ]);

            // Associer les catégories à l'article
            $article->categories()->sync($request->get('categorie'));

            return redirect()->route('articles.liste')->with('success', 'Article créé avec succès!');

        }catch (\Exception $e)
            {
                LogService::logException($e);
                return redirect()->route('articles.liste')->with('error', 'Article non crée!');
            }
}


    /**
     * Display the specified resource.
     */
    public function afficher($id)
    {
        $article = Article::with('categories')->find($id);
        $categories = Category::all();

        return view('articles.afficher', compact('categories', 'article'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function modifier(Request $request, $id)
    {
        $article = Article::with('categories')->find($id);
        $categories = Category::all();
        return view('articles.modifier', compact('categories', 'article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function mettre_a_jour(Request $request, $id)
    {

        $article = Article::with('categories')->find($id);
        $articleId = $article->id;

        // Update validation rules
        $validator = Validator::make($request->all(), [
            'titre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('articles', 'title')->ignore($articleId)
            ],
            'short_description' => 'required|string',
            'description' => 'required|string',
            'sale_price' => 'required|numeric',
            'price' => 'nullable|numeric',
            'categorie' => 'required|array',
        ]);
        if ($validator->fails()) {
            // Redirect back to the specified error page with validation errors and input data
            return redirect()->route('articles.modifier', $articleId)->withErrors($validator)->withInput();
        }
        try{
            $article->update([
                'title' => $request->input('titre'),
                'short_description' => $request->input('short_description'),
                'description' => $request->input('description'),
                'sale_price' => $request->input('sale_price'),
                'price' => $request->input('price'),
                'slug' => Str::slug($request->input('titre')), // Ensure slug is updated
            ]);

            // Sync categories
            $article->categories()->sync($request->input('categorie'));
            return redirect()->route('articles.liste')->with('success', 'Article modifié avec succès!');

        }catch (\Exception $e){
            LogService::logException($e);
            return redirect()->route('articles.liste')->with('error', 'Article non modifié!');
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function supprimer(Article $article)
    {
        try {
            $article->delete();
            // Redirect with success message
            return redirect()->route('articles.liste')->with('success', __('lang.product_deleted_success'));
        }catch(\Exception $e){
            LogService::logException($e);
            return redirect()->route('articles.liste')->with('error', __('lang.product_not_found'));
        }
    }
}
