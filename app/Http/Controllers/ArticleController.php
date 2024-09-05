<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\Console\Application;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function liste(Request $request)
    {
        if ($request->ajax()) {

            $query = Article::with('categories');
            $table = DataTables::of($query);
            $table->addColumn(
                'selectable_td',
                function ($row) {
                    $id = $row['id'];
                    return '<input type="checkbox" class="row-select form-check-input" value="' . $id . '">';
                }
            );
            $table->addColumn('actions', function ($row) {
                $crudRoutePart = 'articles';
                $delete = 'supprimer';
                $edit = 'modifier';
                $id = $row->id;
                return view('partials.__datatable-action', compact('id', 'crudRoutePart', 'edit', 'delete'));
            });
            $table->rawColumns(['actions', 'selectable_td']);
            return $table->make();
        }
        return view('back_office.articles.liste');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function ajouter()
    {
        $categories = Category::all();
        return view('back_office.articles.ajouter', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sauvegarder(Request $request)
    {
        // Start a database transaction

        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'titre' => 'required|string|max:255|unique:articles,title',
                'description' => 'required|string',
                'sale_price' => 'nullable|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'categorie' => 'required|array',
                'tag' => 'nullable|array',
                'quantite' => 'required|numeric|min:0',
                'related_articles' => 'nullable|array',
                'i_image' => 'nullable|image|mimes:jpg,jpeg,png,bmp|max:2048',
                'i_images.*' => 'nullable|image|mimes:jpg,jpeg,png,bmp|max:2048',
                'status'=>'required|in:draft,published',
                'revision_url' => 'nullable|string'
            ], [
                'titre.required' => 'العنوان مطلوب',
                'titre.string' => 'العنوان يجب أن يكون نصاً',
                'titre.max' => 'العنوان يجب أن لا يتجاوز 255 حرفاً',
                'titre.unique' => 'العنوان موجود بالفعل',
                'description.required' => 'الوصف مطلوب',
                'description.string' => 'رابط المراجعة يجب أن يكون نصاً',
                'revision_url.string' => 'الوصف يجب أن يكون نصاً',
                'sale_price.numeric' => 'سعر الخصم يجب أن يكون رقماً',
                'price.required' => 'السعر مطلوب',
                'price.numeric' => 'السعر يجب أن يكون رقماً',
                'categorie.required' => 'الفئة مطلوبة',
                'categorie.array' => 'الفئة يجب أن تكون مصفوفة',
//                'tag.required' => 'الوسوم مطلوبة',
                'tag.array' => 'الوسوم يجب أن تكون مصفوفة',
                'related_articles.required' => 'حقل المنتجات ذات الصلة مطلوب',
                'quantite.required' => 'الكمية مطلوبة',
                'quantite.numeric' => 'الكمية يجب أن تكون رقماً',
                'quantite.min' => 'الكمية يجب أن تكون أكبر من أو تساوي 0',
                'i_image.image' => 'الصورة الرئيسية يجب أن تكون صورة',
                'i_image.mimes' => 'الصورة الرئيسية يجب أن تكون من نوع: jpg, jpeg, png, bmp',
                'i_image.max' => 'الصورة الرئيسية يجب أن لا تتجاوز 2 ميجابايت',
                'i_images.*.image' => 'الصور الأخرى يجب أن تكون صوراً',
                'i_images.*.mimes' => 'الصور الأخرى يجب أن تكون من نوع: jpg, jpeg, png, bmp',
                'i_images.*.max' => 'كل صورة يجب أن لا تتجاوز 2 ميجابايت',
            ]);


            if ($validator->fails()) {
                return redirect()->route('articles.ajouter')->withErrors($validator)->withInput();

            }
            DB::beginTransaction();

            // Create the article
            $article = Article::create([
                'title' => $request->get('titre'),
                'description' => $request->get('description'),
                'sale_price' => $request->get('sale_price') ?? null,
                'price' => $request->get('price') ?? null,
                'slug' => $request->get('titre'),
                'quantite' => $request->get('quantite'),
                'status'=>$request->get('status'),
                'revision_url' => $request->get('revision_url') ?? null,
                ]);

            // Associate categories with the article
            $article->categories()->sync($request->get('categorie'));
            $article->tags()->sync($request->get('tag'));
            $article->relatedArticles()->sync($request->get('related_articles'));


            // Save the principal image
            if ($request->hasFile('i_image')) {
                $article->addMedia($request->file('i_image'))->toMediaCollection('principal');
            }

            // Handle other images upload
            if ($request->hasFile('i_images')) {
                foreach ($request->file('i_images') as $image) {
                    $article->addMedia($image)->toMediaCollection('images');
                }
            }

            // Commit the transaction
            DB::commit();

            return redirect()->route('articles.liste')->with('success', 'تم إنشاء المنتج بنجاح!');

        } catch (\Exception $e) {
            DB::rollBack();
            LogService::logException($e);
            return redirect()->route('articles.liste')->with('error', 'لم يتم إنشاء المنتج!');





        }
    }

    /**
     * Display the specified resource.
     */
    public function afficher($id)
    {
        $o_article = Article::with('categories')->find($id);
        $categories = Category::all();

        return view('back_office.articles.afficher', compact('categories', 'o_article'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function modifier(Request $request, $id)
    {
        $article = Article::find($id);
        $categories = Category::all();
        $tags = Tag::all();
        $principalImage = $article->getFirstMedia('principal');
        $otherImages = $article->getMedia('images');
        $search = '%' . $request->get('term') . '%';

        $relatedArticles = $article->relatedArticles()
            ->where('title', 'LIKE', $search)
            ->get(['related_article_id', 'title as text']);

        return view('back_office.articles.modifier', compact('categories', 'article','principalImage', 'otherImages',
            'tags', 'relatedArticles' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function mettre_a_jour(Request $request, $id)
    {
//        dd($request->all());
        $article = Article::with('categories')->find($id);
        $articleId = $article->id;

        // Update validation rules
        $validator = Validator::make($request->all(), [
            'titre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('articles', 'title')->ignore($articleId)
            ],
            'description' => 'required|string',
            'sale_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'categorie' => 'required|array',
            'related_articles' => 'nullable|array',
            'tag' => 'nullable|array',
            'revision_url.string' => 'nullable|string',

            'quantite' => 'required|numeric|min:0',
            'i_image' => 'nullable|image|mimes:jpg,jpeg,png,bmp|max:2048',
            'i_images.*' => 'nullable|image|mimes:jpg,jpeg,png,bmp|max:2048',
            'status'=>'required|in:draft,published',
        ], [
            'revision_url.string' => 'الوصف يجب أن يكون نصاً',
            'related_articles.required' => 'حقل المنتجات ذات الصلة مطلوب',
            'titre.required' => 'العنوان مطلوب',
            'titre.string' => 'العنوان يجب أن يكون نصاً',
            'titre.max' => 'العنوان يجب أن لا يتجاوز 255 حرفاً',
            'titre.unique' => 'العنوان موجود بالفعل',
            'description.required' => 'الوصف مطلوب',
            'description.string' => 'الوصف يجب أن يكون نصاً',
            'sale_price.numeric' => 'سعر الخصم يجب أن يكون رقماً',
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'السعر يجب أن يكون رقماً',
            'categorie.required' => 'الفئة مطلوبة',
            'categorie.array' => 'الفئة يجب أن تكون مصفوفة',
//            'tag.required' => 'الوسوم مطلوبة',
            'tag.array' => 'الوسوم يجب أن تكون مصفوفة',
            'quantite.required' => 'الكمية مطلوبة',
            'quantite.numeric' => 'الكمية يجب أن تكون رقماً',
            'quantite.min' => 'الكمية يجب أن تكون أكبر من أو تساوي 0',
            'i_image.image' => 'الصورة الرئيسية يجب أن تكون صورة',
            'i_image.mimes' => 'الصورة الرئيسية يجب أن تكون من نوع: jpg, jpeg, png, bmp',
            'i_image.max' => 'الصورة الرئيسية يجب أن لا تتجاوز 2 ميجابايت',
            'i_images.*.image' => 'الصور الأخرى يجب أن تكون صوراً',
            'i_images.*.mimes' => 'الصور الأخرى يجب أن تكون من نوع: jpg, jpeg, png, bmp',
            'i_images.*.max' => 'كل صورة يجب أن لا تتجاوز 2 ميجابايت',
        ]);

        if ($validator->fails()) {
            // Redirect back to the specified error page with validation errors and input data
            return redirect()->route('articles.modifier', $articleId)->withErrors($validator)->withInput();
        }
        try{
            $article->update([
                'title' => $request->input('titre'),
                'description' => $request->input('description'),
                'sale_price' => $request->input('sale_price'),
                'price' => $request->input('price'),
                'slug' => \arabic_slug($request->input('titre')),
                'quantite' => $request->get('quantite'),
                'status' => $request->get('status'),
                'revision_url' => $request->get('revision_url'),
            ]);
            $article->categories()->sync($request->input('categorie'));
            $article->tags()->sync($request->input('tag'));
            $article->relatedArticles()->sync($request->get('related_articles'));


            //Principal image
            if ($request->hasFile('i_image')) {
                $article->clearMediaCollection('principal');
                $article->addMedia($request->file('i_image'))->toMediaCollection('principal');
            }
            if ($request->get('i_supprimer_image')==1) {
                $article->clearMediaCollection('principal');
            }


            //other images

            if ($request->filled('deleted')) {
                $deletedIds = explode(',', $request->input('deleted')[0]);
                foreach ($deletedIds as $deletedId) {
                    $media = $article->getMedia('images')->where('id', $deletedId)->first();
                    if ($media) {
                        $media->delete();
                    }
                }
            }

            // Handle new images
            if ($request->hasFile('i_images')) {
                foreach ($request->file('i_images') as $image) {
                    $article->addMedia($image)->toMediaCollection('images');
                }
            }


            return redirect()->route('articles.liste')->with('success', 'تم تعديل المنتج بنجاح!');

        }catch (\Exception $e){
            LogService::logException($e);
            return redirect()->route('articles.liste')->with('error', 'لم يتم تعديل المنتج!');
        }


    }

    /**
     * Remove the specified resource from storage.
     */

    public function supprimer($id)
    {
        if (\request()->ajax()) {
            $article = Article::find($id);
            if ($article) {
                $article->delete();
                return response('تم حذف المنتج', 200);
            } else {
                return response('خطأ', 404);
            }
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,bmp|max:2048',
        ]);

        // Handle file upload
        $file = $request->file('file');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('public/uploads', $fileName);

        // Create a new media record
        $media = new Media();
        $media->uuid = Str::uuid();
        $media->collection_name = 'other_images';
        $media->name = $fileName;
        $media->file_name = $fileName;
        $media->mime_type = $file->getClientMimeType();
        $media->disk = 'public';
        $media->size = $file->getSize();
        $media->save();

        return response()->json([
            'uuid' => $media->uuid,
            'file' => $fileName,
        ]);
    }

    public function load($media, ResponseFactory $responseFactory)
    {
        $image = Media::find($media);


            header('Content-Type: image/png');
            return $responseFactory->make(readfile($image->getPath()));

    }

    public function articles_select(Request $request)
    {
        if ($request->ajax()) {
            $search = '%' . $request->get('term') . '%';
            $data = Article::where('title', 'LIKE', $search)->get(['id', 'title as text']);
            return response()->json($data, 200);
        }
        abort(404);
    }
    public function articles_select_sale(Request $request)
    {
        if ($request->ajax()) {
            $search = '%' . $request->get('term') . '%';
            $data = Article::where('status', 'published')
                ->whereNotNull('sale_price')
                ->where('title', 'LIKE', $search)
                ->get(['id', 'title as text']);
            return response()->json($data, 200);
        }
        abort(404);
    }
    public function articles_select_latest(Request $request)
    {
        if ($request->ajax()) {
            $search = '%' . $request->get('term') . '%';
            $data = Article::whereNull('sale_price')
                ->where('status', 'published')
                ->where('title', 'LIKE', $search)->get(['id', 'title as text']);
            return response()->json($data, 200);
        }
        abort(404);
    }
}
