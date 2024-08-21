<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Order;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TableauBordController extends Controller
{
    public function liste(Request $request)
    {
        // Default to the range of the current year
        $range = [Carbon::now()->firstOfYear(), Carbon::now()->lastOfYear()];
        $date_picker_start = $range[0];
        $date_picker_end = $range[1];

        if ($request->has('i_date') && $request->get('i_date')) {
            $date = $request->get('i_date');
            $dates = explode('-', $date);
            $start_date = trim($dates[0]);
            $end_date = isset($dates[1]) ? trim($dates[1]) : null;

            try {
                // Convert to Carbon instances for date comparisons
                $date_picker_start = Carbon::createFromFormat('d/m/Y', $start_date)->startOfDay();
                $date_picker_end = $end_date ? Carbon::createFromFormat('d/m/Y', $end_date)->endOfDay() : Carbon::now()->endOfDay();

                // Apply date filtering to the queries
                $articles = Article::count();
                $categories = Category::count();
                $tags = Tag::count();
                $utilisateurs_admin = User::where('role', 'admin')->count();
                $utilisateurs = User::where('role', 'user')->count();

                $processing_sum = Order::where('status', 'قيد المعالجة')->whereBetween('created_at', [$date_picker_start, $date_picker_end])->sum('total');
                $canceled_sum = Order::where('status', 'ملغى')->whereBetween('created_at', [$date_picker_start, $date_picker_end])->sum('total');
                $delivered_sum = Order::where('status', 'تم التوصيل')->whereBetween('created_at', [$date_picker_start, $date_picker_end])->sum('total');
                $shipped_sum = Order::where('status', 'مُرسل')->whereBetween('created_at', [$date_picker_start, $date_picker_end])->sum('total');


                $canceled = Order::where('status', 'ملغى')->whereBetween('created_at', [$date_picker_start, $date_picker_end])->count();
                $delivered = Order::where('status', 'تم التوصيل')->whereBetween('created_at', [$date_picker_start, $date_picker_end])->count();
                $shipped = Order::where('status', 'مُرسل')->whereBetween('created_at', [$date_picker_start, $date_picker_end])->count();
                $processing = Order::where('status', 'قيد المعالجة')->whereBetween('created_at', [$date_picker_start, $date_picker_end])->count();
            } catch (\Exception $e) {
                // Handle any date parsing errors
                return back()->withErrors(['error' => 'Invalid date format']);
            }

            return view('back_office.tableau_bord', compact(
                'range', 'date_picker_end', 'date_picker_start',
                 'canceled', 'delivered', 'shipped', 'processing',
                'articles', 'categories', 'tags', 'utilisateurs', 'processing_sum', 'canceled_sum', 'delivered_sum','shipped_sum','utilisateurs_admin'
            ));
        }

        // Default counts if no date filter is applied
        $articles = Article::count();
        $categories = Category::count();
        $tags = Tag::count();
        $utilisateurs_admin = User::where('role', 'admin')->count();
        $utilisateurs = User::where('role', 'user')->count();

        $processing_sum = Order::where('status', 'قيد المعالجة')->sum('total');
        $canceled_sum = Order::where('status', 'ملغى')->sum('total');
        $delivered_sum = Order::where('status', 'تم التوصيل')->sum('total');
        $shipped_sum = Order::where('status', 'مُرسل')->sum('total');

        $canceled = Order::where('status', 'ملغى')->count();
        $delivered = Order::where('status', 'تم التوصيل')->count();
        $shipped = Order::where('status', 'مُرسل')->count();
        $processing = Order::where('status', 'قيد المعالجة')->count();

        return view('back_office.tableau_bord', compact(
            'range', 'date_picker_end', 'date_picker_start',
            'canceled', 'delivered', 'shipped', 'processing',
            'articles', 'categories', 'tags', 'utilisateurs' ,'processing_sum', 'canceled_sum', 'delivered_sum','shipped_sum','utilisateurs_admin'
        ));
    }

}
