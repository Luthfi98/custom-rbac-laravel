<?php

namespace App\Http\Controllers\Cms;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
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
        $this->access->canAccess('module-role-read');

        if(request()->ajax()) {

            return datatables()->of(Role::select('*'))
            ->addColumn('action', function ($row) {
                $edit = '';
                $delete = '';
                $access = '';
                if ($this->access->canAccess('module-role-access', true)) {
                    $access .= '<a href="/cms/roles/permission/'.$row->id.'" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Permission">
                                <i class="fa-solid fa-wrench"></i>
                            </a>';
                }

                if ($this->access->canAccess('module-role-update', true)) {
                    $edit .= '<a href="'.route('roles.edit', $row->id).'" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fa-solid fa-pencil"></i>
                            </a>';
                }

                if ($this->access->canAccess('module-role-delete', true)) {
                    $delete .= '<form id="delete-form-'.$row->id.'" action="'.route('roles.destroy', $row->id).'" method="POST" style="display: none;">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                            </form>
                            <a href="#" onclick="showConfirm('.$row->id.')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>';
                }

                $button = $access.$edit.$delete;

                return '
                    <div class="btn-group">
                        '.$button.'
                    </div>';

            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        $data = ['title' => 'List Role'];
        return view('cms.roles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->access->canAccess('module-role-create');

        $data = ['title' => 'Create Role'];
        return view('cms.roles.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->access->canAccess('module-role-create');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect(route('roles.index'))
                ->withErrors($validator)
                ->withInput();
        }

        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        session()->flash('success', 'Successfully Created Role');

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->access->canAccess('module-role-detail');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $this->access->canAccess('module-role-update');

        $data = [
            'title' => 'Edit Role',
            'role' => $role
        ];

        return view('cms.roles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $this->access->canAccess('module-role-update');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect(route('roles.index'))
                ->withErrors($validator)
                ->withInput();
        }
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        session()->flash('success', 'Successfully Updated Role');

        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->access->canAccess('module-role-delete');

        $role->delete();
        session()->flash('success', 'Successfully Deleted Role');

        return redirect(route('roles.index'));
    }
    public function permission($id)
    {
        $this->access->canAccess('module-role-access');

        $role = Role::with(['permissions', 'users'])->find($id);
        $permissions = $menus = Menu::with([
            'permissions',
            'child' => function ($query) {
                $query->orderBy('sort', 'asc');
                $query->with([
                    'permissions',
                    'child' => function ($query) {
                        $query->orderBy('sort', 'asc');
                        $query->with('permissions');
                    }
                ]);
            }
        ])
        ->whereNull('parent_id')
        ->orderBy('sort', 'asc')
        ->get();
        $users = User::all();
        $data = [
            'title' => 'Permission to '.$role->name,
            'role' => $role,
            'menus' => $permissions,
            'users' => $users
        ];
        return view('cms.roles.permission', $data);
    }

    function storePermission(Request $request)
    {
        $this->access->canAccess('module-role-access');

        $validator = Validator::make($request->all(), [
            'permissions' => 'required|array',
        ]);
        if ($validator->fails()) {
            return redirect('/cms/roles/permission/'.$request->id)
                ->withErrors($validator)
                ->withInput();
        }
        $permissions = $request->permissions;

        foreach ($permissions as $key => $value) {
            $rolePermission = RolePermission::where(['role_id' => $request->id, 'permission_id' => $value])->first();

            if (!$rolePermission) {
                $rolePermission = new RolePermission();
                $rolePermission->role_id = $request->id;
                $rolePermission->permission_id = $value;
                $rolePermission->save();
            }
        }

        RolePermission::where('role_id', $request->id)
            ->whereNotIn('permission_id', $permissions)
            ->delete();

        if ($request->users) {
            foreach ($request->users as $key => $value) {
                $userRole = UserRole::where(['role_id' => $request->id, 'user_id' => $value])->first();

                if (!$userRole) {
                    $userRole = new UserRole();
                    $userRole->role_id = $request->id;
                    $userRole->user_id = $value;
                    $userRole->save();
                }

            }

            UserRole::where('role_id', $request->id)
                ->whereNotIn('user_id', $request->users)
                ->delete();

        }



        session()->flash('success', 'Successfully Updated Permissions');

        return redirect()->back();
    }
}
