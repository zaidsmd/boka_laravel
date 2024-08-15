<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\LogService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function liste()
    {

        if (request()->ajax()) {
            $query = User::query();
            $table = DataTables::of($query);
            $table->addColumn(
                'selectable_td',
                function ($row) {
                    $id = $row->id;
                    return '<input type="checkbox" class="row-select form-check-input" value="' . $id . '">';
                }
            )->addColumn('actions', function ($row) {
                $edit = 'modifier';
                $delete = 'supprimer';
//                $connexion = 'connexion';
                $crudRoutePart = 'utilisateurs';
                $id = $row?->id;
                return view(
                    'partials.__datatable-action',
                    compact(
                        'edit',
                        'delete',

                        'crudRoutePart',
                        'id',
                    )
                )->render();
            })->rawColumns(['selectable_td', 'actions']);
            return $table->make();
        }
        return view('users.liste');
    }

    public function ajouter()
    {
        return view('users.ajouter',);
    }
    public function sauvegarder(Request $request)
    {
//        dd($request->all());
        $rules = [
            'first_name'=>'required|min:3|max:255|string',
            'last_name'=>'required|min:3|max:255|string',
            'email' => 'required|email|unique:users,email',
            'password'=>'required|min:8|max:255',
//            'i_role'=>'required|exists:roles,name'
        ];
        $messages = [
            'first_name.required' => 'الاسم الأول مطلوب.',
            'first_name.min' => 'الاسم الأول يجب أن يتكون من 3 أحرف على الأقل.',
            'first_name.max' => 'الاسم الأول لا يمكن أن يتجاوز 255 حرفًا.',
            'first_name.string' => 'الاسم الأول يجب أن يكون نصًا.',

            'last_name.required' => 'اسم العائلة مطلوب.',
            'last_name.min' => 'اسم العائلة يجب أن يتكون من 3 أحرف على الأقل.',
            'last_name.max' => 'اسم العائلة لا يمكن أن يتجاوز 255 حرفًا.',
            'last_name.string' => 'اسم العائلة يجب أن يكون نصًا.',

            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون عنوان بريد إلكتروني صالح.',
            'email.unique' => 'هذه العنوان البريدي مستخدم بالفعل.',

            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'كلمة المرور يجب أن تتكون من 8 أحرف على الأقل.',
            'password.max' => 'كلمة المرور لا يمكن أن تتجاوز 255 حرفًا.',
        ];
        $attributes = [
            'first_name'=>'الاسم الشخصي',
            'last_name'=>'الاسم العائلي',
            'email'=>'البريد الإلكتروني',
            'password'=>'كلمة المرور',
//            'i_role'=>'Role'
        ];

        $validation = Validator::make($request->all(),$rules,$messages, $attributes);
        $validation->validate();
        DB::beginTransaction();
        try {
            $o_utilisateur = new User();
            $o_utilisateur->first_name = $request->get('first_name');
            $o_utilisateur->last_name= $request->get('last_name');
            $o_utilisateur->email = $request->get('email');
            $o_utilisateur->email_verified_at = Carbon::now();
            $o_utilisateur->password = Hash::make($request->get('password'));
            $o_utilisateur->save();

//            $o_utilisateur->syncRoles( $request->get('i_role'));
            DB::commit();
            session()->flash('success', 'تم إضافة المستخدم!');
            return redirect()->route('utilisateurs.liste');
        }catch (\Exception $exception){
            DB::rollBack();
            LogService::logException($exception);
            session()->flash('error','Erreur !');
            return redirect()->route('utilisateurs.liste');
        }
    }
    public function modifier($id)
    {
        $o_utilisateur = User::find($id);
        if (!$o_utilisateur) {
            session()->flash('error', 'المستخدم غير موجود!');
            return redirect()->route('utilisateurs.liste');
        }
//        $roles = Role::whereNot('name', 'super_admin')->get();
        return view('users.modifier', compact('o_utilisateur', ));
    }

    public function mettre_a_jour(Request $request, $id)
    {

        $o_utilisateur = User::find($id);
        if (!$o_utilisateur) {
            session()->flash('error', 'المستخدم غير موجود!');
            return redirect()->route('utilisateurs.liste');
        }
        $rules = [
            'first_name' => 'required|min:3|max:255|string',
            'last_name' => 'required|min:3|max:255|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($o_utilisateur->id),
            ],
            'password' => 'nullable|min:8|max:255',
//            'i_role'=>'required|exists:roles,name'
        ];
        $messages = [
            'first_name.required' => 'الاسم الأول مطلوب.',
            'first_name.min' => 'الاسم الأول يجب أن يتكون من 3 أحرف على الأقل.',
            'first_name.max' => 'الاسم الأول لا يمكن أن يتجاوز 255 حرفًا.',
            'first_name.string' => 'الاسم الأول يجب أن يكون نصًا.',

            'last_name.required' => 'اسم العائلة مطلوب.',
            'last_name.min' => 'اسم العائلة يجب أن يتكون من 3 أحرف على الأقل.',
            'last_name.max' => 'اسم العائلة لا يمكن أن يتجاوز 255 حرفًا.',
            'last_name.string' => 'اسم العائلة يجب أن يكون نصًا.',

            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون عنوان بريد إلكتروني صالح.',
            'email.unique' => 'هذه العنوان البريدي مستخدم بالفعل.',

            'password.min' => 'كلمة المرور يجب أن تتكون من 8 أحرف على الأقل.',
            'password.max' => 'كلمة المرور لا يمكن أن تتجاوز 255 حرفًا.',
        ];
        $attributes = [
            'first_name'=>'الاسم الشخصي',
            'last_name'=>'الاسم العائلي',
            'email'=>'البريد الإلكتروني',
            'password'=>'كلمة المرور',
//            'i_role'=>'Role'
        ];
        $validation = Validator::make($request->all(), $rules, $messages, $attributes);
        $validation->validate();
        DB::beginTransaction();
        try {
            $o_utilisateur->first_name = $request->get('first_name');
            $o_utilisateur->last_name= $request->get('last_name');
            $o_utilisateur->email = $request->get('email');
            $o_utilisateur->email_verified_at = Carbon::now();
            $o_utilisateur->password = trim($request->get('password')) ? Hash::make($request->get('i_password')) : $o_utilisateur->password;
//            $o_utilisateur->role = $request->get('i_role');
            $o_utilisateur->save();
//            $o_utilisateur->magasins()->sync($request->get('i_magasins'));
//            $o_utilisateur->syncRoles( $request->get('i_role'));
            DB::commit();
            session()->flash('success', 'تم تعديل المستخدم!');
            return redirect()->route('utilisateurs.liste');
        } catch (\Exception $exception) {
            DB::rollBack();
            LogService::logException($exception);
            session()->flash('error', 'Erreur !');
            return redirect()->route('utilisateurs.liste');
        }
    }

    public function supprimer($id)
    {
        if (\request()->ajax()) {
            $o_utilisateur = User::find($id);
            if ($o_utilisateur) {
                $o_utilisateur->delete();
                return response('تم حذف المستخدم بنجاح', 200);
            } else {
                return response('Erreur', 404);
            }
        }
        abort(404);
    }

}
