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
            $table->addColumn('actions', function($categorie) {
                $edit_modal = ['url'=>route('categories.modifier',$categorie->id),'modal_id'=>'edit-categories-modal'];
                return view('categories.partials.categories_actions', compact('categorie', 'edit_modal'))->render();
            });
            $table->editColumn('created_at', function ($row) {
                return Carbon::make($row->created_at)->toDateString();
            });
            $table->rawColumns([ 'actions']);
            return $table->make();
        }
        return view('categories.liste');

    }
//    public function liste()
//    {
//        if (\request()->ajax()){
//            $query = Category::all();
//            $table = DataTables::of($query);
//            $table->addColumn('actions',function ($row){
//                $crudRoutePart = 'categories';
//                $id = $row->id;
//                $delete = 'supprimer';
//                $edit_modal = ['url'=>route('marques.modifier',$row->id),'modal_id'=>'edit-marque-modal'];
//                return view('partials.__datatable-action',compact('id','edit_modal','delete','crudRoutePart'));
//            });
//            $table->rawColumns(['actions','selectable_td']);
//            return $table->make();
//        }
//        return view('categories.liste2');
//    }
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
        return view('categories.ajouter');
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
    public function supprimer(Category $category)
    {
        try {
            $category->delete();
            // Redirect with success message
            return redirect()->route('categories.liste')->with('success', 'تم حذف الفئة بنجاح!');
        }catch(\Exception $e){
            LogService::logException($e);
            return redirect()->route('categories.liste')->with('error', 'الفئة غير موجودة!');
        }
    }
}
