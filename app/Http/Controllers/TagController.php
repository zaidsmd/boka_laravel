<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class TagController extends Controller
{
    public function liste()
    {

        if (request()->ajax()) {
            $query = Tag::query();
            $table = DataTables::of($query);
            $table->addColumn(
                'selectable_td',
                function ($row) {
                    $id = $row->id;
                    return '<input type="checkbox" class="row-select form-check-input" value="' . $id . '">';
                }
            );

            $table->addColumn('actions', function ($o_tag) {
                $edit_modal = ['url' => route('tags.modifier', $o_tag->id), 'modal_id' => 'edit-tag-modal'];
                return view('back_office.tags.partials.tags_actions', compact('o_tag', 'edit_modal'))->render();
            });
            $table->editColumn('type', function ($row){
                return $row->type ?? '--';
            });
            $table->rawColumns(['selectable_td', 'actions']);
            return $table->make();

        }
        return view('back_office.tags.liste');
    }
    public function sauvegarder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required','string','max:255','unique:tags,name'],
            'type' => ['required','string','max:255'],
        ], [
            'name.required' => 'اسم الوسم مطلوب.',
            'name.string' => 'اسم الوسم يجب أن يكون نصاً.',
            'name.max' => 'اسم الوسم لا يمكن أن يتجاوز 255 حرفاً.',
            'name.unique' => 'اسم الوسم موجود مسبقاً.',
            'type.required' => 'نوع الوسم مطلوب.',
            'type.string' => 'نوع الوسم يجب أن يكون نصاً.',
            'type.max' => 'نوع الوسم لا يمكن أن يتجاوز 255 حرفاً.',
        ]);


        if ($validator->fails()) {
            // Redirect back to the specified error page with validation errors and input data
            return redirect()->route('tags.liste')->withErrors($validator)->withInput();
        }
//        $request->validate([
//            'name' => ['required','string','max:255','unique:categories,name'],
//            'slug' => ['slug','string','max:255'],
//        ]);
        $slug = arabic_slug($request->get('name'));
        $o_categorie = Tag::create([
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'slug' => $slug,
        ]);
        if ($request->ajax()){
            return $o_categorie;
        }
        session()->flash('success', 'تم إضافة الوسم!');
        return redirect()->route('tags.liste');
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
            $o_tag = Tag::find($id);
            return view('back_office.tags.partials.modifier_modal',compact('o_tag'));
        }
        abort('404');
    }

    /**
     * Update the specified resource in storage.
     */
    public function mettre_a_jour(Request $request, $id)
    {
        $o_tag = Tag::find($id);

        // Validate the request with custom Arabic messages
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ], [
            'name.required' => 'اسم الوسم مطلوب.',
            'name.string' => 'اسم الوسم يجب أن يكون نصاً.',
            'name.max' => 'اسم الوسم لا يمكن أن يتجاوز 255 حرفاً.',
            'type.required' => 'نوع الوسم مطلوب.',
            'type.string' => 'نوع الوسم يجب أن يكون نصاً.',
            'type.max' => 'نوع الوسم لا يمكن أن يتجاوز 255 حرفاً.',
        ]);

        $slug = arabic_slug($request->get('name'));

        // Update the tag
        $o_tag->update([
            'name' => $request->name,
            'type' => $request->type,
            'slug' => $slug,
        ]);

        // Redirect with a success message in Arabic
        return redirect()->route('tags.liste')
            ->with('success', 'تم تحديث تسمية الوسم بنجاح.');
    }




    public function tags_select(Request $request)
    {
        if ($request->ajax()) {
            $search = '%' . $request->get('term') . '%';
            $data = Tag::where('name', 'LIKE', $search)->get(['id', 'name as text']);
            return response()->json($data, 200);
        }
        abort(404);
    }

    public function supprimer($id)
    {
        if (\request()->ajax()) {
            $o_tag = Tag::with('articles')->find($id);
            if ($o_tag) {
                if ($o_tag->articles->count() > 0) {
                    return response('لا يمكن حذف الوسم لأنها تحتوي على منتجات', 400);
                }
                $o_tag->delete();
                return response('تم حذف الوسم بنجاح', 200);
            } else {
                return response('Erreur', 404);
            }
        }
        abort(404);
    }
}
