<?php

namespace App\Http\Controllers\Cms;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    private $access;

    public function __construct() {
        $this->access = new GeneralHelper();
    }
    public function index()
    {
        $user = User::with(['roles.role', 'role'])->find(Auth::id());
        // Auth::user()->load(['roles', 'role']);
        $currentRole = Role::find(session('current_role'));
        $data = [
            'title' => "Profile",
            'user' => $user,
            'currentRole' => $currentRole
        ];

        return view('cms.profiles.index', $data);
    }

    public function store(Request $request)
    {
        $user = User::find(Auth::id());

        $rules = [
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:25|'.Rule::unique('users', 'username')->ignore($user->id),
            'email' => 'required|string|'.Rule::unique('users', 'email')->ignore($user->id),
            'phone' => 'required|string|max:15|'.Rule::unique('users', 'phone')->ignore($user->id),
        ];

        if($request->hasFile('image'))
        {
            $rules[] = [
                'image' => 'required|file|max:2048|mimes:jpeg,png,jpg'
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        // dd($request->hasFile('image'));

        if ($validator->fails()) {
            return redirect(route('profile'))
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $filename);
            $fileUrl = 'uploads/profile/' . $filename;
            $user->image = $fileUrl;
        }


        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->default_role = $request->default_role;
        // dd($user);
        $user->save();
        $this->access->log('Edit', 'Update Profile');


        session()->flash('success', 'Successfully Updated Data');

        return redirect(route('profile'));
    }

    public function change($id)
    {
        // dd($id);
        session(['current_role' =>  $id]);

        // dd(session('current_role'));

        session()->flash('success', 'Successfully Change Role');

        return redirect(route('profile'));
    }
}
