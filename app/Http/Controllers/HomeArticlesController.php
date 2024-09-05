<?php

namespace App\Http\Controllers;

use App\Models\HomeArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeArticlesController extends Controller
{
    public function liste(Request $request)
    {
        $latestProducts = HomeArticle::where('type', 'latest')->with('article')
            ->orderBy('display_order')
            ->get();
        $selectedProducts = HomeArticle::select('home_articles.article_id', 'articles.title as text')
            ->join('articles', 'home_articles.article_id', '=', 'articles.id') // Adjust foreign key and primary key names as needed
            ->where('home_articles.type', 'latest')
            ->get();


        $saleProducts = HomeArticle::where('type', 'sale')->with('article')
            ->orderBy('display_order')
            ->get();
        $selectedSaleProducts = HomeArticle::select('home_articles.article_id', 'articles.title as text')
            ->join('articles', 'home_articles.article_id', '=', 'articles.id') // Adjust foreign key and primary key names as needed
            ->where('home_articles.type', 'sale')
            ->get();
        return view('back_office.home_articles.liste', compact('latestProducts', 'selectedProducts', 'saleProducts', 'selectedSaleProducts'));
    }

    public function sauvegarder(Request $request)
    {

        $productOrderData = json_decode($request->input('latest_order_data'), true);
        $saleOrderData = json_decode($request->input('sale_order_data'), true);
        DB::table('home_articles')->delete();
        $insertData = [];
        foreach ($productOrderData as $item) {
            $insertData[] = [
                'article_id' => $item['id'],
                'display_order' => $item['displayOrder'],
                'type' => 'latest'
            ];
        }
        if (!empty($insertData)) {
            DB::table('home_articles')->insert($insertData);
        }

        $insertSaleData = [];
        foreach ($saleOrderData as $item) {
            $insertSaleData[] = [
                'article_id' => $item['id'],
                'display_order' => $item['displayOrder'],
                'type' => 'sale'

            ];
        }
        if (!empty($insertSaleData)) {
            DB::table('home_articles')->insert($insertSaleData);
        }

        return redirect()->route('home_articles.liste')->with('success', 'تم تحديث منتوجات الصفحة الرئيسية');

    }
}
