<?php

namespace App\Services;

use App\Models\CompanyManagement\CompanyModel;
use App\Models\CompanyManagement\DepartmentModel;
use App\Models\CompanyManagement\LevelModel;
use App\Models\CompanyManagement\PositionModel;
use Illuminate\Support\Facades\Auth;

class CompanyManagementService
{

    public static function listCompany()
    {
        return  CompanyModel::where("is_active", true)
        ->when(Auth::user()->is_superadmin == false, function($q){
            $q->where("id", Auth::user()->company_id);
        })
        ->get()
        ->map(function($v) {
            return [
                'id' => $v->id,
                'code' => $v->name,

            ];
        });
    }

       public static function listDepartment($request = NULL)
    {
        return  DepartmentModel::where("is_active", true)
        ->when(Auth::user()->is_superadmin == false, function($q){
            $q->where("company_id", Auth::user()->company_id);
        })
        ->when($request && $request->company_id, function($q)use($request) {
            $q->where('company_id', $request->company_id);
        })
        ->get()
        ->map(function($v) {
            return [
                'id' => $v->id,
                'code' => $v->name,

            ];
        });
    }


    public static function listPosition($request = NULL)
    {
        return  PositionModel::where("is_active", true)
         ->when($request && $request->department_id, function($q)use($request) {
            $q->where('department_id', $request->department_id);
        })
        ->when(Auth::user()->is_superadmin == false, function($q){
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

    public static function listLevel($request = NULL)
    {
        return  LevelModel::where("is_active", true)
         ->when($request && $request->position_id, function($q)use($request) {
            $q->where('position_id', $request->position_id);
        })->when(Auth::user()->is_superadmin == false, function($q){
            $q->where("company_id", Auth::user()->company_id);
        })
        ->when(Auth::user()->is_superadmin == false, function($q){
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
}