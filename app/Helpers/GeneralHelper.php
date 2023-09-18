<?php

namespace App\Helpers;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\UserRole;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GeneralHelper {
    function getMenu()
    {
        // $menus = Menu::with(['child.child' => function($query) {
        //     $query->orderBy('sort', 'asc');
        // }])
        // ->orderBy('sort', 'asc')
        // ->whereNull('parent_id')
        // ->get();
        $currentRole = session('current_role');
        $requiredPermission = 'show'; // Izin yang mengandung "show"

        $menus = Menu::with([
            'child' => function ($query) use ($currentRole, $requiredPermission) {
                $query->with(['child' => function($subQuery) use ($currentRole, $requiredPermission) {
                    $subQuery->orderBy('sort', 'asc')
                             ->whereHas('permissions', function ($subSubQuery) use ($currentRole, $requiredPermission) {
                                $subSubQuery->where('role_permissions.role_id', $currentRole)
                                            ->where('permissions.name', 'LIKE', "%$requiredPermission%")
                                            ->join('role_permissions', 'permissions.id', '=', 'role_permissions.permission_id');
                            });
                }])
                ->whereHas('permissions', function ($subQuery) use ($currentRole, $requiredPermission) {
                    $subQuery->where('role_permissions.role_id', $currentRole)
                             ->where('permissions.name', 'LIKE', "%$requiredPermission%")
                             ->join('role_permissions', 'permissions.id', '=', 'role_permissions.permission_id');
                })
                ->orderBy('sort', 'asc');
            }
        ])
        ->orderBy('sort', 'asc')
        ->whereNull('parent_id')
        ->whereHas('permissions', function ($query) use ($currentRole, $requiredPermission) {
            $query->where('role_permissions.role_id', $currentRole)
                  ->where('permissions.name', 'LIKE', "%$requiredPermission%")
                  ->join('role_permissions', 'permissions.id', '=', 'role_permissions.permission_id');
        })
        ->get();

        return $menus;
    }

    function canAccess($access, $isMenu = false )
    {
        $user_id = Auth::user()->id;
        $role_id = session('current_role');

        $permission = Permission::where(['name' => $access])->first();

        $userRole = UserRole::where(['role_id' => $role_id, 'user_id' => $user_id])->first();

        $rolePermission = RolePermission::where(['role_id' => $role_id, 'permission_id' => $permission?->id])->first();
        // return true;
        if(!$userRole || !$rolePermission)
        {
            if($isMenu){
                return false;
            }else{
                return abort(Response::HTTP_FORBIDDEN, '403 Unauthorized');
            }

        }else{
            return true;
        }

        // dd();
    }
}
