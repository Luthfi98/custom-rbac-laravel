<?php

namespace App\Http\Controllers\Cms\Article;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\TagArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $access;

    public function __construct() {
        $this->access = new GeneralHelper();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->access->canAccess('tags-article-read');

        if(request()->ajax()) {

            return datatables()->of(TagArticle::select('*'))
            ->addColumn('action', function ($row) {
                $edit = '';
                $delete = '';

                if ($this->access->canAccess('tags-article-update', true)) {
                    $edit .= '<a href="'.route('tags-article.edit', $row->id).'" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fa-solid fa-pencil"></i>
                            </a>';
                }

                if ($this->access->canAccess('tags-article-delete', true)) {
                    $delete .= '<form id="delete-form-'.$row->id.'" action="'.route('tags-article.destroy', $row->id).'" method="POST" style="display: none;">
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
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        $data = ['title' => 'List Tag Article'];
        return view('cms.article.tags.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->access->canAccess('tags-article-create');

        $data = ['title' => 'Create Tag'];
        return view('cms.article.tags.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->access->canAccess('tags-article-create');
        $rules = [
            'name' => 'required|string|max:255|'.Rule::unique('tag_articles', 'name'),
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect(route('tags-article.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $tag = new TagArticle();
        $tag->name = $request->name;
        $tag->save();

        session()->flash('success', 'Successfully Created Tag');

        return redirect(route('tags-article.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->access->canAccess('tags-article-detail');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->access->canAccess('tags-article-update');
        $tag = TagArticle::find($id);

        $data = [
            'title' => 'Edit Tag Article',
            'tag' => $tag,
        ];

        return view('cms.article.tags.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->access->canAccess('tags-article-update');

        $rules = [
            'name' => 'required|string|max:255|'.Rule::unique('tag_articles', 'name')->ignore($id),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect(route('tags-article.edit', $id))
                ->withErrors($validator)
                ->withInput();
        }
        $tag = TagArticle::find($id);

        $tag->name = $request->name;
        $tag->save();

        session()->flash('success', 'Successfully Updated Tag');

        return redirect(route('tags-article.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->access->canAccess('tags-article-delete');
        $tag = TagArticle::find($id);

        $tag->delete();
        session()->flash('success', 'Successfully Deleted Tag');

        return redirect(route('tags-article.index'));
    }
}
