<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleCollection;
use App\Models\Article;
use App\Models\Cart;
use App\Models\Category;
use App\Models\OrderLine;
use App\Models\Tag;
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
        $latest = Article::where('status','published')->limit(4)->get();
        $sales = Article::where('status','published')->whereNotNull('sale_price')->inRandomOrder()->limit(8);
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
    public function shop($selected_tag = null,$selected_category=null,$sort=null,$sale = null)
    {
        $selected_tag =\request()->route()->parameter('selected_tag');
        $selected_category =\request()->route()->parameter('selected_category');
        $sort =\request()->route()->parameter('sort');
        $sale =\request()->route()->parameter('sale');
        $categories = Category::get();
        $ages = Tag::where('type','فئة-عمرية')->get();
        $articles_sale_count = Article::where('status','published')->whereNotNull('sale_price')->count();

        return view('shop', compact('categories', 'articles_sale_count','ages','selected_category','selected_tag','sort','sale'));
    }

    /**
     * @param Request $request
     * @return ArticleCollection
     */
    public function shopAjax(Request $request)
    {
        if ($request->ajax()) {
            $query = Article::where('status','published');
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
            if ($request->input('tags')) {
                $tags = $request->input('tags');
                $query->whereHas('tags', function (Builder $query) use ($tags) {
                    $query->whereIn('tags.id', $tags);
                });
            }
            if ($request->input('sale')) {
                $query->whereNotNull('sale_price');
            }
            if ($request->input('sort')){
                $sort = $request->input('sort');
                switch ($sort){
                    case "date":
                        $query->orderBy('created_at');
                    case "date-desc":
                        $query->orderByDesc('created_at');
                        break;
                    case "price":
                        $query->orderBy('price');
                        break;
                    case "price-desc":
                        $query->orderByDesc('price');
                        break;
                }
            }

            $filteredArticleIds = $query->pluck('id');
            $allTags = Tag::select('tags.id', 'tags.slug')
                ->leftJoin('article_tag', 'tags.id', '=', 'article_tag.tag_id')
                ->where(function ($query) use ($filteredArticleIds) {
                    $query->whereIn('article_tag.article_id', $filteredArticleIds)
                        ->orWhereNull('article_tag.article_id');
                })
                ->groupBy('tags.id', 'tags.slug')
                ->selectRaw('count(article_tag.article_id) as article_count')
                ->get();

            $paginatedArticles = new ArticleCollection($query->paginate(12));

            return $paginatedArticles->additional([
                'tagCounts' => $allTags
            ]);
        }
        abort(404);
    }

    /**
     * @param string $slug
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View|mixed|object|string|null
     */
    public function single(string $slug)
    {
        $article = Article::where('status','published')->where('slug', $slug)->first();
        if (!$article) {
            abort(404);
        }
        $categories = $article->categories->pluck('id');
        $relatedArticleIds = $article->relatedArticles->pluck('id')->toArray();
        $relateds = Article::whereIn('id', $relatedArticleIds)
            ->take(4) // Limit to a maximum of 4 related articles
            ->get();
        $additionalCount = max(0, 4 - $relateds->count());

        $additionalArticles = Article::whereHas('categories', function (Builder $query) use ($categories) {
            $query->whereIn('categories.id', $categories);
                    })->whereNotIn('id', $relatedArticleIds) // Exclude already related articles
                    ->inRandomOrder()
                        ->limit($additionalCount)
                        ->get();
        $relateds = $relateds->merge($additionalArticles);


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
            $articles = Article::where('status','published')->whereHas('categories', function (Builder $query) use ($slug) {
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
            $articles = Article::where('status','published')->orderBy('created_at', 'desc');
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
            $articles =  Article::where('status','published')->leftJoin('order_lines', 'articles.id', '=', 'order_lines.article_id')
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
