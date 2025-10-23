<?php

namespace App\Services;

use App\Models\UserManagement\Menu;
use App\Models\UserManagement\MenuModel;

class Service
{
    public static function listStatusMaster()
    {
        return [
            [
                "id" => true,
                "code" => "Active",
                "badge" => "primary"
            ],
            [
                "id" => false,
                "code" => "Inactive",
                "badge" => "danger"

            ]
        ];
    }

    public static function statusMaster($activeFlag)
    {
        $status = collect(self::listStatusMaster())->firstWhere('id', $activeFlag);
        
        return [
            "code" => $status['code'] ?? null,
            "badge" => $status['badge'] ?? null
        ];
    }


    public static function listMenuTree() {
        return MenuModel::with(['children' => function ($query) {
            $query->with('children')->orderBy('seq_id');
        }])
        ->whereNull('parent_id')
        ->orderBy('seq_id')
        ->get();
    }
    
    
   
}
