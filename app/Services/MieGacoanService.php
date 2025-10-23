<?php

namespace App\Services;

use App\Models\Inventory\Master\ProvinceModel;
use App\Models\MieGacoan\Product;

class MieGacoanService
{
    public static function listProduct($request = NULL)
    {
        return  Product::where("is_active", true)
        // ->when($request == "FINISH GOODS", function($q)use($request) {
        //     $q->where('type_desc', ["RAW MATERIAL"]);
        // })
        ->when($request && $request == "RAW MATERIAL", function($q)use($request) {
            $q->where("type_desc", $request);
        })
        ->when($request && $request <> "RAW MATERIAL", function($q)use($request) {
            $q->where("type_desc", "<>", "RAW MATERIAL");
        })
        ->get()
        ->map(function($v) {
            return [
                "id" => $v->id,
                "code" => $v->prd_desc,
            ];
        });


    }






}
