<?php

namespace App\Http\Controllers;

use App\Models\MemberOrder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MemberOrderController extends Controller
{

    public function liste(Request $request)
    {
        if (request()->ajax()) {
            $query = MemberOrder::query()->where('status', 'pending') ->with(['user', 'product']);;
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
                $show = 'afficher';
                $traiter = 'traiter';
//                $connexion = 'connexion';
                $crudRoutePart = 'member_orders';
                $id = $row?->id;
                return view(
                    'partials.__datatable-action',
                    compact(
//                        'edit',
//                        'delete',
//                        'show',
                    'traiter',
                        'crudRoutePart',
                        'id',
                    )
                )->render();
            })->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d H:i:s'); // Example format
            })

                ->rawColumns(['selectable_td', 'actions']);
            return $table->make();
        }
        return view('back_office.member_orders.liste');
    }

    public function traiter($id)
    {
        if (\request()->ajax()) {
            $o_member_order = MemberOrder::find($id);
            if ($o_member_order) {
                // Delete the order
                $o_member_order->status = 'approved';
                $o_member_order->save();
                return response('تم معالجة  الطلب بنجاح', 200);
            } else {
                return response('الطلب غير موجود', 404);
            }
        }
        abort(404);
    }

}
