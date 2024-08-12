<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\LimiteService;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function liste(Request $request)
    {
        if ($request->ajax()) {
            $query = Article::with('categories');
            if ($request->get('famille_id')) {
                $query->where('famille_id', $request->get('famille_id'));
            }
            if ($request->get('date')) {
                $start_date = Carbon::createFromFormat('d/m/Y', trim(explode('-', $request->get('date'))[0]))->toDateString();
                $end_date = Carbon::createFromFormat('d/m/Y', trim(explode('-', $request->get('date'))[1]))->toDateString();
                if ($end_date === $start_date) {
                    $query->whereDate('created_at', $end_date);
                } else {
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                }
            }
            if ($request->get('reference')) {
                $query->where('reference', $request->get('reference'));
            }
            if ($request->get('designation')) {
                $designation_search = '%' . $request->get('designation') . '%';
                $query->where('designation', 'LIKE', $designation_search);
            }
            if ($request->get('prix_vente')) {
                $query->where('prix_vente', +$request->get('prix_vente'));
            }
            if ($request->get('prix_achat')) {
                $query->where('prix_achat', +$request->get('prix_achat'));
            }
            if ($request->get('prix_revient')) {
                $query->where('prix_revient', +$request->get('prix_revient'));
            }
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
            $table->addColumn('actions', function($article) {
                return view('articles.partials.articles_actions', compact('article'))->render();
            });


            $table->editColumn('created_at', function ($row) {
                return Carbon::make($row->created_at)->toDateString();
            });
            $table->rawColumns([ 'actions']);
            return $table->make();
        }
        return view('articles.liste');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function ajouter()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sauvegarder(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function afficher(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function modifier(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function mettre_a_jour(Request $request, Article $article)
    {
        //
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
