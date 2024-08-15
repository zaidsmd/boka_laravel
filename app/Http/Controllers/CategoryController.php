<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function liste(Request $request)
    {
        if ($request->ajax()) {
            $query = Category::all();
            $table = DataTables::of($query);
            $table->addColumn(
                'selectable_td',
                function ($row) {
                    $id = $row['id'];
                    return '<input type="checkbox" class="row-select form-check-input" value="' . $id . '">';
                }
            );

            $table->addColumn('actions', function ($categorie) {
                $edit_modal = ['url' => route('categories.modifier', $categorie->id), 'modal_id' => 'edit-categories-modal'];
                return view('categories.partials.categories_actions', compact('categorie', 'edit_modal'))->render();
            });
                $table->rawColumns(['selectable_td', 'actions']);
                    return $table->make();
                }
            return view('categories.liste');

        }


    public function categories_select(Request $request)
    {
        if ($request->ajax()) {
            $search = '%' . $request->get('term') . '%';
            $data = Category::where('name', 'LIKE', $search)->get(['id', 'name as text']);
            return response()->json($data, 200);
        }
        abort(404);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function ajouter()
    {
//        return view('categories.ajouter');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sauvegarder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required','string','max:255','unique:categories,name'],
        ]);

        if ($validator->fails()) {
            // Redirect back to the specified error page with validation errors and input data
            return redirect()->route('categories.liste')->withErrors($validator)->withInput();
        }
//        $request->validate([
//            'name' => ['required','string','max:255','unique:categories,name'],
//            'slug' => ['slug','string','max:255'],
//        ]);
        $slug = Str::slug($request->get('name'));
        $o_categorie = Category::create([
            'name' => $request->get('name'),
            'slug' => $slug,
        ]);
        if ($request->ajax()){
            return $o_categorie;
        }
        session()->flash('success', 'تم إضافة الفئة!');
        return redirect()->route('categories.liste');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function modifier(Request $request, $id)
    {
        if ($request->ajax()){
            $request->validate([
                'id'=>'exists:categories,id'
            ]);
            $o_categorie = Category::find($id);
            return view('categories.partials.modifier_modal',compact('o_categorie'));
        }
        abort('404');
    }

    /**
     * Update the specified resource in storage.
     */
    public function mettre_a_jour(Request $request,$id)
    {
        $categorie = Category::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $slug = Str::slug($request->get('name'));
        $categorie->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);
        return redirect()->route('categories.liste')
            ->with('success', __('.تم تحديث تسمية الفئة بنجاح'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function supprimer($id)
    {
        if (\request()->ajax()) {
            $o_categorie = Category::with('articles')->find($id);
            if ($o_categorie) {
                if ($o_categorie->articles->count() > 0) {
                    return response('لا يمكن حذف الفئة لأنها تحتوي على مقالات', 400);
                }
                $o_categorie->delete();
                return response('تم حذف الفئة بنجاح', 200);
            } else {
                return response('Erreur', 404);
            }
        }
        abort(404);
    }

}
