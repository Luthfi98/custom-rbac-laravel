<?php

namespace App\Http\Controllers\Cms;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    private $listAccess = ['access', 'create', 'delete', 'detail', 'export', 'import', 'read', 'restore', 'show', 'trash', 'update'];

    private $access;

    public function __construct() {
        $this->access = new GeneralHelper();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->access->canAccess('menu-show');
        if(request()->ajax()) {

            return datatables()->of(Menu::select('menus.*', 'parent.name as parent_name')
            ->leftJoin('menus as parent', 'menus.parent_id', '=', 'parent.id'))
            ->addColumn('action', function ($row) {
                $edit = '';
                $delete = '';
                if ($this->access->canAccess('menu-update', true)) {
                    $edit .= '<a href="'.route('menus.edit', $row->id).'" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fa-solid fa-pencil"></i>
                            </a>';
                }

                if ($this->access->canAccess('menu-delete', true)) {
                    $delete .= '<form id="delete-form-'.$row->id.'" action="'.route('menus.destroy', $row->id).'" method="POST" style="display: none;">
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
        $data = ['title' => 'List Menu'];
        return view('cms.menus.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->access->canAccess('menu-create');
        $parents = Menu::with([
        'child' => function ($query) {
            $query->with(['child' => function($subQuery) {
                $subQuery->orderBy('sort', 'asc');
            }])
            ->orderBy('sort', 'asc');
        }
        ])
        ->orderBy('sort', 'asc')
        ->whereNull('parent_id')
        ->get();

        $data = ['title' => 'Create Menu', 'parents' => $parents, 'listAccess' => $this->listAccess];
        return view('cms.menus.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->access->canAccess('menu-create');
        $validator = Validator::make($request->all(), [
            'parent' => 'nullable', // Add your validation rules
            'name' => 'required|string|max:100',
            'module' => 'required|string|max:100',
            'path' => 'required|string|max:50',
            'icon' => 'required|string',
            'type' => 'required|in:cms,landing',
            'is_label' => 'nullable',
            'permissions' => 'required|array',
            'permissions.*' => 'in:'.implode(',', $this->listAccess)
        ]);

        if ($validator->fails()) {
            return redirect(route('menus.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $menu = new Menu();
        $menu->parent_id    = $request->parent;
        $menu->name         = $request->name;
        $menu->module       = $request->module;
        $menu->path         = $request->path;
        $menu->icon         = $request->icon;
        $menu->type         = $request->type;
        $menu->is_label     = $request->is_label ? 1 : 0;

        $menu->save();

        $this->createPermissionByMenu($request, $menu);


        session()->flash('success', 'Successfully Created Menu');

        return redirect(route('menus.index'));


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->access->canAccess('menu-detail');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $this->access->canAccess('menu-update');

        $data = [
            'title' => 'Create Menu',
            'parents' => Menu::get(),
            'menu' => $menu->with('permissions')->where('id', $menu->id)->first(),
            'listAccess' => $this->listAccess];
        // dd($data);
        return view('cms.menus.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $this->access->canAccess('menu-update');

        $validator = Validator::make($request->all(), [
            'parent' => 'nullable', // Add your validation rules
            'name' => 'required|string|max:100',
            'module' => 'required|string|max:100',
            'path' => 'required|string|max:50',
            'icon' => 'required|string',
            'type' => 'required|in:cms,landing',
            'is_label' => 'nullable',
            'permissions' => 'required|array',
            'permissions.*' => 'in:'.implode(',', $this->listAccess)
        ]);

        // dd($validator->fails());

        if ($validator->fails()) {
            return redirect(route('menus.edit', $menu->id))
                ->withErrors($validator)
                ->withInput();
        }


        $menu->parent_id = $request->parent;
        $menu->name = $request->name;
        $menu->path = $request->path;
        $menu->icon = $request->icon;
        $menu->type = $request->type;
        $menu->is_label = $request->is_label ? 1 : 0;


        $menu->save();

        $this->createPermissionByMenu($request, $menu);


        session()->flash('success', 'Successfully Updated Menu');

        return redirect(route('menus.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $this->access->canAccess('menu-delete');

        $menu->delete();
        session()->flash('success', 'Successfully Deleted Menu');

        return redirect(route('menus.index'));
    }

    private function createPermissionByMenu($request, $menu)
    {
        $permissions = $request->permissions;
        $prefix = Str::slug($request->name);

        $existingPermissions = Permission::where('menu_id', $menu->id)->pluck('name')->toArray();
        $newPermissions = [];
        $nameBefore = [];
        foreach ($permissions as $value) {
            $permissionName = $prefix . '-' . Str::slug($value);
            $nameBefore[] = Str::slug($menu->name.'-'.$value);

            if (in_array($permissionName, $existingPermissions)) {
                // Update existing permission
                Permission::where('name', Str::slug($menu->name.'-'.$value))
                    ->update(['menu_id' => $menu->id, 'prefix' => $prefix, 'name' => $permissionName]);
            } else {
                // Insert new permission
                $newPermissions[] = [
                    'menu_id' => $menu->id,
                    'prefix' => $prefix,
                    'name' => $permissionName,
                ];
            }
        }
        // Insert new permissions
        Permission::insert($newPermissions);

        // Delete outdated permissions
        $permissionsToDelete = array_diff($existingPermissions, $nameBefore);
        // dd($permissionsToDelete, $nameBefore);
        Permission::whereIn('name', $permissionsToDelete)->delete();

        return true;
    }

    function trashed()
    {
        $this->access->canAccess('trashed-menu-show');

        if(request()->ajax()) {

            return datatables()->of(Menu::select('menus.*', 'parent.name as parent_name')
            ->leftJoin('menus as parent', 'menus.parent_id', '=', 'parent.id')
            ->onlyTrashed())
            ->editColumn('deleted_at', function(Menu $menu){
                return Carbon::createFromFormat('Y-m-d H:i:s', $menu->deleted_at)->format('d M Y, h:i A');
            })
            ->addColumn('select_checkbox', function ($row) {
                return '<input type="checkbox" class="selected" name="selected_menus[]" value="' . $row->id . '">';
            })
            ->rawColumns(['select_checkbox'])
            ->addIndexColumn()
            ->make(true);
        }
        $data = ['title' => 'List Trashed Menu'];
        return view('cms.menus.trashed', $data);
    }

    public function storeTrashed(Request $request)
    {
        $menus = $request->menus;
        $type = $request->type;
        $count = 0;

        foreach ($menus as $key => $value) {
            $menu = Menu::withTrashed()->find($value);
            switch ($type) {
                case 'restore':
                    if(!$this->access->canAccess('trashed-menu-restore', true)){
                        $response = [
                            'message' => "Access Denied to $type records.",
                        ];

                        return response()->json($response, HttpResponse::HTTP_FORBIDDEN);
                    }
                    $menu->restore();
                    break;
                case 'delete':
                    if(!$this->access->canAccess('trashed-menu-delete', true)){
                        $response = [
                            'message' => "Access Denied to $type records.",
                        ];

                        return response()->json($response, HttpResponse::HTTP_FORBIDDEN);
                    }
                    $menu->forceDelete();
                    break;
                default:
                    # code...
                    break;
            }

            $count++;
        }

        $response = [
            'message' => "Successfully $type {$count} records.",
        ];

        return response()->json($response, HttpResponse::HTTP_OK);

    }

    public function sorting()
    {
        $this->access->canAccess('sorting-menu-show');
        $menus = Menu::with([
            'child' => function ($query) {
                $query->with(['child' => function($subQuery) {
                    $subQuery->orderBy('sort', 'asc');
                }])
                ->orderBy('sort', 'asc');
            }
            ])
            ->orderBy('sort', 'asc')
            ->whereNull('parent_id')
            ->get();

            $data = [
                'title' => 'Sorting Menu',
                'menus' => $menus,
            ];

            return view('cms.menus.sorting', $data);
        }

    public function storeSorting(Request $request)
    {
        $this->access->canAccess('sorting-menu-update');
        // dd($request->data);
        $this->updateSorting($request->data);
        $response = [
            'message' => "Successfully Reordering menus.",
        ];

        return response()->json($response, HttpResponse::HTTP_OK);
    }

    private function updateSorting($items, $parentId = null, $parentSort = 1, $isLabel = 1)
    {

        foreach ($items as $index => $item) {
            $menu = Menu::find($item['id']);

            if ($menu) {
                $menu->parent_id = $parentId;
                $menu->sort = $parentSort;
                $menu->is_label = $menu->path == '#' ? $isLabel : 0;
                $menu->save();

                if (isset($item['children'])) {
                    $this->updateSorting($item['children'], $menu->id, 1, 0); // Set is_label to 0 for child items
                }
            }

            $parentSort++;
        }
    }
}
