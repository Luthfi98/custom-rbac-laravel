<?php

namespace App\Http\Controllers\Cms;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
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
        $this->access->canAccess('module-user-read');

        if (request()->ajax()) {
            $users = User::all();
            return datatables()->of($users)
            ->addColumn('action', function ($row) {
                $edit = '';
                $delete = '';

                if($this->access->canAccess('module-user-update'))
                {
                    $edit .= '<a href="'.route('users.edit', $row->id).'" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fa-solid fa-pencil"></i>
                            </a>';
                }
                if($this->access->canAccess('module-user-delete'))
                {
                    $delete .=  '<form id="delete-form-'.$row->id.'" action="'.route('users.destroy', $row->id).'" method="POST" style="display: none;">
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
            ->editColumn('created_at', function(User $user){
                return Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d M Y, h:i A');
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        $data = [
            'title' => 'User'
        ];

        return view('cms.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->access->canAccess('module-user-create');

        $roles = Role::all();

        $data = [
            'title' => 'Create User',
            'roles' => $roles
        ];

        return view('cms.users.create', $data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->access->canAccess('module-user-create');
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:25|'.Rule::unique('users', 'username'),
            'email' => 'required|string|'.Rule::unique('users', 'email'),
            'phone' => 'required|string|max:15|'.Rule::unique('users', 'phone'),
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'in:'.implode(',',Role::pluck('id')->all())
        ]);

        // dd($validator->fails());

        if ($validator->fails()) {
            return redirect(route('users.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User();
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();
        foreach ($request->roles as $key => $value) {
            $userRole = new UserRole();
            $userRole->user_id = $user->id;
            $userRole->role_id = $value;
            $userRole->save();
        }
        $this->access->log('Create', 'Create User '.$user->fullname);

        session()->flash('success', 'Successfully Created User');
        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->access->canAccess('module-user-detail');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->access->canAccess('module-user-update');
        $roles = Role::all();

        $data = [
            'title' => 'Edit User',
            'roles' => $roles,
            'user' => $user->with('roles')->find($user->id)
        ];

        // dd($data);

        return view('cms.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->access->canAccess('module-user-update');
        $rules = [
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:25|'.Rule::unique('users', 'username')->ignore($user->id),
            'email' => 'required|string|'.Rule::unique('users', 'email')->ignore($user->id),
            'phone' => 'required|string|max:15|'.Rule::unique('users', 'phone')->ignore($user->id),
            'roles' => 'required|array',
            'roles.*' => 'in:'.implode(',',Role::pluck('id')->all())
        ];

        if($request->password && $request->password_confirmation)
        {
            $rules[] = ['password' => 'required|string|min:8|confirmed'];
            $user->password = Hash::make($request->password);
        }

        $validator = Validator::make($request->all(), $rules);

        // dd($validator->fails());

        if ($validator->fails()) {
            return redirect(route('users.edit', $user->id))
                ->withErrors($validator)
                ->withInput();
        }
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
        foreach ($request->roles as $key => $value) {
            $userRole = UserRole::where(['user_id' => $user->id, 'role_id' => $value])->first();

            if (!$userRole) {
                $userRole = new UserRole();
                $userRole->user_id = $user->id;
                $userRole->role_id = $value;
                $userRole->save();
            }

        }

        UserRole::where('user_id', $user->id)
            ->whereNotIn('role_id', $request->roles)
            ->delete();
        $this->access->log('Edit', 'Update User '.$user->fullname);

        session()->flash('success', 'Successfully Updated User');
        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->access->canAccess('module-user-delete');

        $user->delete();
        $this->access->log('Delete', 'Delete User '.$user->fullname);

        session()->flash('success', 'Successfully Deleted User');

        return redirect(route('users.index'));
    }

    function trashed()
    {
        $this->access->canAccess('trashed-user-show');

        if (request()->ajax()) {
            $users = User::onlyTrashed();
            return datatables()->of($users)
            ->editColumn('deleted_at', function(User $user){
                return Carbon::createFromFormat('Y-m-d H:i:s', $user->deleted_at)->format('d M Y, h:i A');
            })
            ->addColumn('select_checkbox', function ($row) {
                return '<input type="checkbox" class="selected" name="selected_users[]" value="' . $row->id . '">';
            })
            ->rawColumns(['select_checkbox'])
            ->addIndexColumn()
            ->make(true);
        }

        $data = [
            'title' => 'Trashed User'
        ];

        return view('cms.users.trashed', $data);
    }

    public function storeTrashed(Request $request)
    {
        $users = $request->users;
        $type = $request->type;
        $count = 0;

        foreach ($users as $key => $value) {
            $user = User::withTrashed()->find($value);
            switch ($type) {
                case 'restore':
                    $user->restore();
                    break;
                case 'delete':
                    $user->forceDelete();
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
}
