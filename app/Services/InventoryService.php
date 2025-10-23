<?php

namespace App\Services;

use App\Models\CompanyManagement\DepartmentModel;
use App\Models\CompanyManagement\LevelModel;
use App\Models\CompanyManagement\PositionModel;
use App\Models\Inventory\Master\CityModel;
use App\Models\Inventory\Master\ProvinceModel;
use App\Models\Inventory\Master\SubDistrictModel;

class InventoryService
{
    public static function listProvince($request = NULL)
    {
        return  ProvinceModel::
        when($request && $request->city_id, function($q)use($request) {
            return $q->whereHas("city", function($v)use($request){
                $v->where("id", $request->city_id);
            });
        })
        ->get()
        ->map(function($v) {
            return [
                'id' => $v->id,
                'code' => $v->name,
            ];
        });


    }

    public static function listCity($request = NULL)
    {
        return  CityModel::
        when($request && $request->province_id, function($q)use($request) {
            $q->where('province_id', $request->province_id);
        })
        ->get()
        ->map(function($v) {
            return [
                'id' => $v->id,
                'code' => $v->name,

            ];
        });
    }

    public static function listSubDistrict($request = NULL)
    {
        return  SubDistrictModel::
        when($request && $request->province_id, function($q)use($request) {
            $q->where('province_id', $request->province_id);
        })
        ->when($request && $request->city_id, function($q)use($request) {
            $q->where('city_id', $request->city_id);
        })
        ->get()
        ->map(function($v) {
            return [
                'id' => $v->id,
                'code' => $v->name,

            ];
        });
        
    }

    public static function listDepartment()
    {
        return  DepartmentModel::where("is_active", true)
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
