<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleCollection;
use App\Models\Article;
use App\Models\Cart;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ShopViewsController extends Controller
{
    public function myAccount(Request $request){
        $auth =  $request->user();
        return view('account',compact('auth'));
    }
    public function home(Request $request){
        $latest = Article::limit(4)->get();
        $sales = Article::whereNotNull('sale_price')->inRandomOrder()->limit(8);
        if ($sales->count() == 8){
           $sales = $sales->get();
        }else {
            $sales =  $sales->limit(4)->get();
        }
        return view('home',compact('latest','sales'));
    }
    public function cart(Request $request){
        $cart = cart();
        return view('cart',compact('cart'));
    }

    public function checkout(){
        return view('checkout');
    }
    public function shop(Request $request){
        if ($request->ajax()){
            return  new ArticleCollection(Article::paginate(10));
        }
        $categories = Category::get();
        $articles_sale_count = Article::whereNotNull('sale_price')->count();
        return view('shop',compact('categories','articles_sale_count'));
    }

    public function single(string $slug){
        $article = Article::where('slug',$slug)->first();
        $categories = $article->categories->pluck('id');
        $relateds = Article::whereHas('categories',function (Builder $query) use ($categories) {
            $query->whereIn('categories.id',$categories);
        })->inRandomOrder()->limit(4)->get();
        if (!$article){
        abort(404);
        }
        return view('single-product',compact('article','relateds'));
    }
}
