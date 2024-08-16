<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CommandeController extends Controller
{
    public function liste(Request $request)
    {
        $statuses = Order::getStatuses();
        if (request()->ajax()) {
            $query = Order::query();
            if ($request->get('numero')) {
                $query->where('number', $request->get('numero'));
            }if ($request->get('nom')) {
                $query->where(function($q) use ($request) {
                    $q->where('first_name', $request->get('nom'))
                        ->orWhere('last_name', $request->get('nom'));
                });
            }
            if ($request->get('city')) {
                $query->where('city', $request->get('city'));
            }if ($request->get('payment_method')) {
                $query->where('payment_method', $request->get('payment_method'));
            }if ($request->get('statut')) {
                $query->where('status', $request->get('statut'));
            }

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
//                $connexion = 'connexion';
                $crudRoutePart = 'commandes';
                $id = $row?->id;
                return view(
                    'partials.__datatable-action',
                    compact(
//                        'edit',
                        'delete',
                        'show',
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
        return view('back_office.commandes.liste', compact('statuses'));
    }

    public function afficher(Request $request, $id)
    {

        $o_order = Order::find($id);
        $totalPrice = $o_order->lines->sum(function ($line) {
            return $line->price * $line->quantity;
        });
        return view('back_office.commandes.afficher', compact('o_order', 'totalPrice', ));

    }

    public function supprimer($id)
    {
        if (\request()->ajax()) {
            $o_order = Order::with('lines')->find($id);
            if ($o_order) {
                // Delete associated order lines
                $o_order->lines()->delete();

                // Delete the order
                $o_order->delete();

                return response('تم حذف الطلب بنجاح', 200);
            } else {
                return response('الطلب غير موجود', 404);
            }
        }
        abort(404);
    }

    public function status_modal( $id)
    {
        $o_order = Order::find($id);
        if (!$o_order) {
            return response( "  الطلب لا يوجد!", 404);
        }
        $statuses = Order::getStatuses();

        return view('back_office.commandes.partials.status_modal', compact('o_order', 'statuses' ));
    }

    public function modifier_status(Request $request, $id)
    {
        $o_order = Order::find($id);

        if ($o_order) {
            $status = $request->input('status');
            $o_order->status = $status;
            $o_order->save();
            return redirect()->route('commandes.afficher', $o_order->id)
                ->with('success', 'تم تحديث الحالة بنجاح');

        }else{
            return redirect()->route('commandes.liste', $o_order->id)
                ->with('error', __('فشل في تحديث الحالة. يرجى المحاولة مرة أخرى.'));

        }

    }

    public function ajouter()
    {

        $status = Order::getStatuses();
        return view('back_office.commandes.ajouter', compact('status'));
    }
}
