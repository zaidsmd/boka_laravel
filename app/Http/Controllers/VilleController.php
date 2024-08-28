<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class VilleController extends Controller
{
    public function liste()
    {

        if (request()->ajax()) {
            $query = Ville::query();
            $table = DataTables::of($query);
            $table->addColumn(
                'selectable_td',
                function ($row) {
                    $id = $row->id;
                    return '<input type="checkbox" class="row-select form-check-input" value="' . $id . '">';
                }
            );

            $table->addColumn('actions', function ($ville) {
                $edit_modal = ['url' => route('villes.modifier', $ville->id), 'modal_id' => 'edit-ville-modal'];
                return view('back_office.villes.partials.villes_actions', compact('ville', 'edit_modal'))->render();
            });

            $table->rawColumns(['selectable_td', 'actions']);
            return $table->make();

        }
        return view('back_office.villes.liste');
    }


    public function sauvegarder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'max:255', 'unique:villes,nom'],
            'price' => ['required', 'numeric', 'min:0'],
        ], [
            'nom.required' => 'اسم المدينة مطلوب.',
            'nom.string' => 'اسم المدينة يجب أن يكون نصاً.',
            'nom.max' => 'اسم المدينة لا يمكن أن يتجاوز 255 حرفاً.',
            'nom.unique' => 'اسم المدينة موجود مسبقاً.',
            'price.required' => 'سعر التوصيل مطلوب.',
            'price.numeric' => 'سعر التوصيل يجب أن يكون رقماً.',
            'price.min' => 'سعر التوصيل لا يمكن أن يكون أقل من 0.',
        ]);

        if ($validator->fails()) {
            // Redirect back to the specified error page with validation errors and input data
            return redirect()->route('villes.liste')->withErrors($validator)->withInput();
        }

        Ville::create([
            'nom' => $request->get('nom'),
            'price' => $request->get('price'),
        ]);
        session()->flash('success', 'تم إضافة المدينة!');
        return redirect()->route('villes.liste');
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
            $ville = Ville::find($id);
            return view('back_office.villes.partials.modifier_modal',compact('ville'));
        }
        abort('404');
    }

    /**
     * Update the specified resource in storage.
     */
    public function mettre_a_jour(Request $request, $id)
    {
        $ville = Ville::find($id);

        // Validate the request with custom Arabic messages
        $request->validate([
            'nom' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ], [
            'nom.required' => 'اسم المدينة مطلوب.',
            'nom.string' => 'اسم المدينة يجب أن يكون نصاً.',
            'nom.max' => 'اسم المدينة لا يمكن أن يتجاوز 255 حرفاً.',
            'price.required' => 'سعر التوصيل مطلوب.',
            'price.numeric' => 'سعر التوصيل يجب أن يكون رقماً.',
            'price.min' => 'سعر التوصيل لا يمكن أن يكون سالباً.',
        ]);

        // Update the tag
        $ville->update([
            'nom' => $request->nom,
            'price' => $request->price,
        ]);

        // Redirect with a success message in Arabic
        return redirect()->route('villes.liste')
            ->with('success', 'تم تحديث المدينة بنجاح.');
    }

    public function supprimer($id)
    {
        if (\request()->ajax()) {
            $ville  = Ville::find($id);
            if ($ville) {
                $ville->delete();
                return response('تم حذف المدينة بنجاح', 200);
            } else {
                return response('Erreur', 404);
            }
        }
        abort(404);
    }
}
