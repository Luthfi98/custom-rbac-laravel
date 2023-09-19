<?php

namespace App\Http\Controllers\Cms\Article;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\CategoryArticle;
use App\Models\TagArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class DataController extends Controller
{
    private $access;

    public function __construct() {
        $this->access = new GeneralHelper();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->access->canAccess('module-data-article-read');

        if(request()->ajax()) {
            $article = Article::select(
                'articles.*',
                'category_articles.name as category_name',
            )
            ->leftJoin('category_articles', 'articles.category_article_id', '=', 'category_articles.id');
            if (request()->has('filter')) {
                $filter = request()->input('filter');
                switch ($filter) {
                    case 'trashed':
                        $article->onlyTrashed();
                        break;
                    case 'active':
                        $article->where('articles.status', 'Active');
                        break;
                    case 'inactive':
                        $article->where('articles.status', 'InActive');
                        break;
                    default:
                        break;
                }
            }
            $datatable = datatables()->of($article)
                ->editColumn('image', function ($row) {
                    return '<img src="'.url($row->image).'" width="50%">';
                });

            if ($filter == 'trashed') {
                $datatable->addColumn('select_checkbox', function ($row) {
                    return '<input type="checkbox" class="selected" name="selected_articles[]" value="' . $row->id . '">';
                });
            }else{
                $datatable->addColumn('action', function ($row) {
                    $edit = '';
                    $delete = '';
                    $detail = '';

                    if ($this->access->canAccess('module-data-article-detail', true)) {
                        $detail .= '<a href="'.route('data-article.show', $row->id).'" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fa-solid fa-eye"></i>
                                </a>';
                    }

                    if ($this->access->canAccess('module-data-article-update', true)) {
                        $edit .= '<a href="'.route('data-article.edit', $row->id).'" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>';
                    }

                    if ($this->access->canAccess('module-data-article-delete', true)) {
                        $delete .= '<form id="delete-form-'.$row->id.'" action="'.route('data-article.destroy', $row->id).'" method="POST" style="display: none;">
                                    '.csrf_field().'
                                    '.method_field('DELETE').'
                                </form>
                                <a href="#" onclick="showConfirm('.$row->id.')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>';
                    }

                    $button = $detail.$edit.$delete;

                    return '
                        <div class="btn-group">
                            '.$button.'
                        </div>';
                });
            }

            $datatable->rawColumns(['action', 'image', 'qty', 'price', 'select_checkbox']);

            return $datatable->addIndexColumn()->make(true);
        }
        $data = ['title' => 'List Articles'];
        return view('cms.article.data.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->access->canAccess('module-data-article-create');
        $categories = CategoryArticle::with(['child'])
                    ->get();
        $tags = TagArticle::all();
        $data = [
            'title' => 'Create Article',
            'categories' => $categories,
            'tags' => $tags,
        ];
        // dd($data);

        return view('cms.article.data.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->access->canAccess('module-data-article-create');
        $rules = [
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required',
            'tags' => 'required|array',
            'status' => 'nullable',
            'image' => 'required|file|max:2048|mimes:jpeg,png,jpg,webp'
        ];
        $validator = Validator::make($request->all(), $rules);
        // dd($request, $validator->fails());
        if ($validator->fails()) {
            return redirect(route('data-article.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $article = new Article();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/article/post/article'), $filename);
            $fileUrl = 'uploads/article/post/article/' . $filename;
            $article->image = $fileUrl;
        }

        $article->name = $request->name;
        $article->slug = Str::slug($request->name);
        $article->content = $request->content;
        $article->category_id = $request->category;
        $article->tags = json_encode($request->tags);
        $article->status = $request->status ? 'Active' : 'InActive' ;
        // dd($article);
        $article->save();

        session()->flash('success', 'Successfully Created Article');

        return redirect(route('data-article.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->access->canAccess('module-data-article-read');

        $data = [
            'title' => 'Detail Article',
            'article' => Article::with(['category', 'brand', 'unit'])->withTrashed()->find($id),
        ];

        return view('cms.article.data.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->access->canAccess('module-data-article-update');
        $categories = PosCategory::with(['child.child'])
                    ->whereNull('parent_id')
                    ->get();
        $brands = PosBrand::with(['child.child'])
                    ->whereNull('parent_id')
                    ->get();
        $units = PosUnit::all();
        $data = [
            'title' => 'Edit Article',
            'article' => Article::with(['category', 'brand', 'unit'])->find($id),
            'categories' => $categories,
            'brands' => $brands,
            'units' => $units
        ];

        return view('cms.article.data.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->access->canAccess('module-data-article-create');
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'unit_id' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'status' => 'nullable',
            'image' => 'file|max:2048|mimes:jpeg,png,jpg,webp'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect(route('data-article.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $article = Article::find($id);

        if ($request->hasFile('image')) {
            if ($article->image) {
                $oldFilePath = public_path($article->image);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/article/post/article'), $filename);
            $fileUrl = 'uploads/article/post/article/' . $filename;
            $article->image = $fileUrl;
        }

        $article->name = $request->name;
        $article->description = $request->description;
        $article->price = $request->price;
        $article->qty = $request->qty;
        $article->category_id = $request->category_id;
        $article->brand_id = $request->brand_id;
        $article->unit_id = $request->unit_id;
        $article->status = $request->status ? 'Active' : 'InActive' ;
        // dd($article);
        $article->save();

        session()->flash('success', 'Successfully Updated Article');

        return redirect(route('data-article.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->access->canAccess('module-data-article-delete');
        $article = Article::find($id);
        $article->delete();

        session()->flash('success', 'Successfully Deleted Article');

        return redirect(route('data-article.index'));
    }
}
