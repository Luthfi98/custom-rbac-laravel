<?php

namespace App\Helpers;

use App\Models\Activity;
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

    function log($type, $description)
    {
        $activity = new Activity();
        $activity->user_id = Auth::user()->id;
        $activity->url = url()->current();
        $activity->ip = request()->ip();
        $activity->description = $description;
        $activity->data = json_encode(request()->input());
        $activity->type = $type;
        $activity->save();

        return true;
    }

    function getSetting()
    {
        $settingPath = storage_path('settings.json');
        $jsonContents = file_get_contents($settingPath);

        // Decode the JSON content
        $setting = json_decode($jsonContents);
        return $setting;
    }

    function detailActivity($data, $html = null)
    {
        foreach ($data as $key => $value) {
            // var_dump(is_object($value), $value, is_array($value));die;
            $html .= "<li>";
                $html .= '<b>'.$key.' : </b> ';
                if (is_array($value) || is_object($value)) {
                    $html .= '<ul>';
                    $html .= $this->detailActivity($value, $html);
                    $html .= '</ul>';
                }else{
                    // $html .= $value;
                }
            $html .= "</li>";
        }
        var_dump($html);
        // return $html;
    }
}
