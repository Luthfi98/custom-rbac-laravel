<?php

namespace App\Http\Controllers\Cms;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
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
        $this->access->canAccess('permission-show');

        if(request()->ajax()) {
            $this->access->canAccess('permission-read');
            $permission = Permission::select('*');
            if (request()->has('menu_id')) {
                $menuId = request()->input('menu_id');
                if (!empty($menuId)) {
                    $permission->where('menu_id', $menuId);
                }
            }

            return datatables()->of($permission)
            ->addColumn('action', function ($row) {

                $edit = '';
                $delete = '';

                if($this->access->canAccess('permission-update', true))
                {
                    $edit .= '<a href="'.route('permissions.edit', $row->id).'" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fa-solid fa-pencil"></i>
                            </a>';
                }
                if($this->access->canAccess('permission-delete', true))
                {
                    $delete .=  '<form id="delete-form-'.$row->id.'" action="'.route('permissions.destroy', $row->id).'" method="POST" style="display: none;">
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


        $data = [
            'title' => 'Permission',
            'menus' => Menu::all()
        ];

        return view('cms.permissions.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
