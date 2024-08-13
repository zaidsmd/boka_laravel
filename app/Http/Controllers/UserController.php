<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
                $connexion = 'connexion';
                $crudRoutePart = 'utilisateurs';
                $id = $row?->id;
                return view(
                    'partials.__datatable-action',
                    compact(
                        'edit',
                        'delete',
                        'connexion',

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
    public function sauvegarder()
    {
            return view('users.ajouter',);
    }
}
