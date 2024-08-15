<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleCollection;
use App\Models\Article;
use App\Models\Cart;
use App\Models\Category;
use App\Models\OrderLine;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopViewsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View|mixed|object|string|null
     */
    public function myAccount(Request $request)
    {
        $auth = $request->user();
        return view('account', compact('auth'));
    }

    /**
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View|mixed|object|string|null
     */
    public function home()
    {
        $latest = Article::limit(4)->get();
        $sales = Article::whereNotNull('sale_price')->inRandomOrder()->limit(8);
        if ($sales->count() >= 8) {
            $sales = $sales->get();
        } else {
            $sales = $sales->limit(4)->get();
        }
        return view('home', compact('latest', 'sales'));
    }

    /**
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View|mixed|object|string|null
     */
    public function cart()
    {
        $cart = cart();
        return view('cart', compact('cart'));
    }

    /**
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View|mixed|object|string|null
     */
    public function checkout()
    {
        return view('checkout');
    }

    /**
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View|mixed|object|string|null
     */
    public function shop()
    {
        $categories = Category::get();
        $articles_sale_count = Article::whereNotNull('sale_price')->count();
        return view('shop', compact('categories', 'articles_sale_count'));
    }

    /**
     * @param Request $request
     * @return ArticleCollection|void
     */
    public function shopAjax(Request $request)
    {
        if ($request->ajax()) {
            $query = Article::query();
            if ($request->input('search')) {
                $search = '%' . $request->input('search') . '%';
                $query->where('title', 'LIKE', $search);
            }
            if ($request->input('min')) {
                $query->where('price', '>=', $request->input('min'));
            }
            if ($request->input('max')) {
                $query->where('price', '<=', $request->input('max'));
            }
            if ($request->input('categories')) {
                $categories = $request->input('categories');
                $query->whereHas('categories', function (Builder $query) use ($categories) {
                    $query->whereIn('categories.id', $categories);
                });
            }
            if ($request->input('sale')) {
                $query->whereNotNull('sale_price');
            }
            return new ArticleCollection($query->paginate(12));
        }
        abort(404);
    }

    /**
     * @param string $slug
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View|mixed|object|string|null
     */
    public function single(string $slug)
    {
        $article = Article::where('slug', $slug)->first();
        $categories = $article->categories->pluck('id');
        $relateds = Article::whereHas('categories', function (Builder $query) use ($categories) {
            $query->whereIn('categories.id', $categories);
        })->inRandomOrder()->limit(4)->get();
        if (!$article) {
            abort(404);
        }
        return view('single-product', compact('article', 'relateds'));
    }

    /**
     * @param string $slug
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View|mixed|object|string|null
     */
    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            abort(404);
        }
        return view('category', compact('category'));
    }

    /**
     * @param Request $request
     * @return ArticleCollection|void
     */
    public function categoryAjax(Request $request)
    {
        if ($request->ajax()) {
            $slug = $request->input('category');
            $articles = Article::whereHas('categories', function (Builder $query) use ($slug) {
                $query->whereIn('categories.slug', [$slug]);
            });
            return new ArticleCollection($articles->paginate(12));
        }
        abort(404);
    }

    public function new()
    {
        return view('new');
    }

    public function newAjax(Request $request)
    {
        if ($request->ajax()) {
            $articles = Article::orderBy('created_at', 'desc');
            return new ArticleCollection($articles->paginate(12));
        }
        abort(404);
    }

    public function bestSeller()
    {
        return view('best-seller');
    }

    public function bestSellerAjax(Request $request)
    {
        if ($request->ajax() || 1) {
            $articles =  Article::leftJoin('order_lines', 'articles.id', '=', 'order_lines.article_id')
                ->select('articles.*', DB::raw('COALESCE(SUM(order_lines.quantity), 0) as total_sales'))
                ->groupBy('articles.id')
                ->orderBy('total_sales', 'desc');
            return new ArticleCollection($articles->paginate(12));
        }
        abort(404);
    }

    public function sale()
    {
        return view('sale');
    }
}
