<?php

namespace App\Services;

use App\Models\UserManagement\MenuModel;
use App\Models\UserManagement\RoleModel;
use App\Models\UserManagement\UserModel;
use Illuminate\Support\Facades\Auth;

class UserManagementService
{
    public static function listUser()
    {
        return  UserModel::when(Auth::user()->is_superadmin == false, function($q){
            $q->where("company_id", Auth::user()->company_id);
        })
        ->get()
        ->map(function($v) {
            return [
                'id' => $v->id,
                'code' => $v->name,

            ];
        });
    }

    public static function listRole()
    {
        return  RoleModel::where("is_active", true)
        ->get()
        ->map(function($v) {
            return [
                'id' => $v->id,
                'code' => $v->role_name,

            ];
        });
    }

    public static function menuName($url)
    {
        $data = MenuModel::where("route", $url);
        return  $data->first() ? $data->first()->name : "N/A"; 
    }


}