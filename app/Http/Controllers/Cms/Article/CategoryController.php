<?php

namespace App\Http\Controllers\Cms\Article;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\CategoryArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CategoryController extends Controller
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
        $this->access->canAccess('module-category-article-show');
        if(request()->ajax()) {

            return datatables()->of(CategoryArticle::select('category_articles.*', 'parent.name as parent_name')
            ->leftJoin('category_articles as parent', 'category_articles.parent_id', '=', 'parent.id'))
            ->addColumn('action', function ($row) {
                $edit = '';
                $delete = '';
                if ($this->access->canAccess('module-category-article-update', true)) {
                    $edit .= '<a href="'.route('article-category.edit', $row->id).'" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fa-solid fa-pencil"></i>
                            </a>';
                }

                if ($this->access->canAccess('module-category-article-delete', true)) {
                    $delete .= '<form id="delete-form-'.$row->id.'" action="'.route('article-category.destroy', $row->id).'" method="POST" style="display: none;">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                            </form>
                            <a href="#" onclick="showConfirm('.$row->id.')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>';
                }

                $button = $edit.$delete;

                return '
                    <div class="btn-group">
                        '.$button.'
                    </div>';

            })
            ->editColumn('image', function($row){
                return $row->image ? '<img src="'.url($row->image).'" width="50px" alt="Image '.$row->name.'">' : 'No Image' ;
            })
            ->rawColumns(['action', 'image'])
            ->addIndexColumn()
            ->make(true);
        }
        $data = ['title' => 'List Category Article'];
        return view('cms.article.categories.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->access->canAccess('module-category-article-create');
        $parents = CategoryArticle::with([
        'child' => function ($query) {
            $query->with(['child' => function($subQuery) {
                $subQuery->orderBy('name', 'asc');
            }])
            ->orderBy('name', 'asc');
        }
        ])
        ->orderBy('name', 'asc')
        ->whereNull('parent_id')
        ->get();

        $data = ['title' => 'Create Category', 'parents' => $parents];
        return view('cms.article.categories.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->access->canAccess('module-category-article-create');
        $rules = [
            'name' => 'required|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($request->hasFile('image'))
        {
            $rules[] = [
                'image' => 'required|file|max:2048|mimes:jpeg,png,jpg'
            ];
        }
        if ($validator->fails()) {
            return redirect(route('article-category.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $category = new CategoryArticle();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/article/category'), $filename);
            $fileUrl = 'uploads/article/category/' . $filename;
            $category->image = $fileUrl;
        }

        $category->name = $request->name;
        $category->slug =  Str::slug($request->name);
        $category->parent_id = $request->parent_id;
        $category->save();

        session()->flash('success', 'Successfully Created Category Article');

        return redirect(route('article-category.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->access->canAccess('module-category-article-create');
        $parents = CategoryArticle::with([
        'child' => function ($query) {
            $query->with(['child' => function($subQuery) {
                $subQuery->orderBy('name', 'asc');
            }])
            ->orderBy('name', 'asc');
        }
        ])
        ->orderBy('name', 'asc')
        ->whereNull('parent_id')
        ->get();

        $category = CategoryArticle::find($id);

        $data = ['title' => 'Create Category', 'parents' => $parents, 'category'=> $category];
        return view('cms.article.categories.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->access->canAccess('module-category-article-update');

        $rules = [
            'name' => 'required|string|max:255',
        ];
        if($request->hasFile('image'))
        {
            $rules[] = [
                'image' => 'required|file|max:2048|mimes:jpeg,png,jpg'
            ];
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect(route('article-category.edit', $id))
                ->withErrors($validator)
                ->withInput();
        }
        $category = CategoryArticle::find($id);

        if ($request->hasFile('image')) {
            if ($category->image) {
                $oldFilePath = public_path($category->image);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/article/category'), $filename);
            $fileUrl = 'uploads/article/category/' . $filename;
            $category->image = $fileUrl;
        }

        $category->name = $request->name;
        $category->slug =  Str::slug($request->name);
        $category->parent_id = $request->parent_id;
        $category->save();

        session()->flash('success', 'Successfully Updated Category Article');

        return redirect(route('article-category.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->access->canAccess('module-category-article-delete');
        $category = CategoryArticle::find($id);

        $category->delete();
        session()->flash('success', 'Successfully Deleted Category Article');

        return redirect(route('article-category.index'));
    }
}
