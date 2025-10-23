<?php

namespace App\Http\Controllers\MieGacoan;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\MieGacoan\PointOfSale;
use App\Models\MieGacoan\Product;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use DB;

class PosController extends Controller
{
    const URL = "mie-gacoan-pos";
    const menuName = "Point of Sale";

    public function __construct() {
        $this->data = [
            "url"=> self::URL,
            "title"=> self::menuName,
        ];

        $this->data=(object) $this->data;
    }

    public function index()
    {

        return view('layouts.content.index', [
            "content" => 'mie-gacoan.pos.index',
            "data" => $this->data,
            "status" => Service::listStatusMaster()
        ]);


    }

    public function show(string $id, Request $request)
    {
        if ($id == 'dataAll') {return $this->dataAll($request);}
    }

    public function dataAll(Request $request)
    {

        try{
            $total_data = PointOfSale::count();

            $data = PointOfSale::when($request->trans_no, function($q) use($request){
                $q->where('trans_no', 'ilike', "%$request->trans_no%");
            })
            ->when($request->store_name, function($q) use($request){
                $q->where('store_name', 'ilike', "%$request->store_name%");
            })
            ->get()
            ->map(function($row){
                App::setLocale('id');
                return [
                    "id" => $row->id,
                    "trans_no" => $row->trans_no,
                    "trans_date" => $row->trans_date,
                    "store_name" => $row->store_name,
                    "total_payment" => $row->total_payment,
                    "created_at" => Helper::dateFullInd($row->created_at),
                    "created_by" => optional($row->createdBy)->name,
                    "access" => (object) [
                        "detail" =>  null,
                        "edit" => null,
                        "delete" => null,
                    ],
                    "print_id" => null
                ];
            });

            $records_filtered = $data->count();
            $start = $request->start;
            $length = $request->length < 0 ? $records_filtered : $request->length;

            $data_page = Helper::sort($request, $data)
            ->values()
            ->slice($start, $length)
            ->values();
        }
        catch (\Exception $e) {
            $total_data = 0;
            $records_filtered = 0;
            $data_page = [];
            $error = $e->getMessage();
        }
        finally {
            return json_encode([
                "draw" => $request->draw,
                "recordsTotal" => $total_data,
                "recordsFiltered" => $records_filtered,
                "data" => $data_page,
                "error" => $error ?? null,
            ]);
        }
    }


}
