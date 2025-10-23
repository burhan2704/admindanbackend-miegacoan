<?php

namespace App\Http\Controllers\MieGacoan;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\MieGacoan\Product;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use DB;

class ProductController extends Controller
{
    const URL = "mie-gacoan-product";
    const menuName = "Product";

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
            "content" => 'mie-gacoan.product.index',
            "data" => $this->data,
            "status" => Service::listStatusMaster()
        ]);


    }

    public function createData(Request $request)
    {

        self::withValidate($request);


        DB::beginTransaction();
        try {

            Product::create([
                'prd_code' => $request->prd_code,
                'prd_desc' => $request->prd_desc,
                'type_desc' => $request->type_desc,
                'uom_desc' => $request->uom_desc,
                'sales_price' => Helper::cleanNum($request->sales_price ?? "0"),
                'qoh' => Helper::cleanNum($request->qoh ?? "0"),
                'is_active' => $request->is_active ?? false,
                "created_by" => auth()->id(),
            ]);

            DB::commit();

            return response([
                'message' => 'Success! You have successfully created',
            ])->setStatusCode(200);
        }
        catch(\PDOException $e) {
            DB::rollback();

            return response([
                'message' => "Failed! Internal Database Error. " .$e->getMessage(),
                'errors' => $e,
            ])->setStatusCode(500);
        }
        catch(\Exception $e) {
            DB::rollback();

            return response([
                'message' => "Failed! ". $e->getMessage(),
                'errors' => $e,
            ])->setStatusCode(500);
        }
    }

    public function editData(Request $request)
    {
        try {

            $header = Product::where("id", $request->id)->first();

            return view('mie-gacoan.product.main', [
                'data'=>$this->data,
                'disab'=> $request->disab,
                'ke'=>'updateData',
                'header' => $header,
            ]);

        }
        catch(\PDOException $e) {

            return response([
                'message' => "Failed! Internal Database Error. " .$e->getMessage(),
                'errors' => $e,
            ])->setStatusCode(500);
        }
        catch(\Exception $e) {

            return response([
                'message' => "Failed! ". $e->getMessage(),
                'errors' => $e,
            ])->setStatusCode(500);
        }
    }

    public function deleteData(Request $request)
    {

        DB::beginTransaction();
        try {

            $user = Product::find($request->id);
            $user->fill([
                'is_active' => false,
                "deleted_by" => auth()->id(),
                "deleted_at" => now(),
            ])
            ->save();

            DB::commit();

            return response([
                'message' => 'Success! You have successfully deleted.',
            ])->setStatusCode(200);
        }
        catch(\PDOException $e) {
            DB::rollback();

            return response([
                'message' => "Failed! Internal Database Error. " .$e->getMessage(),
                'errors' => $e,
            ])->setStatusCode(500);
        }
        catch(\Exception $e) {
            DB::rollback();

            return response([
                'message' => "Failed! ". $e->getMessage(),
                'errors' => $e,
            ])->setStatusCode(500);
        }
    }

    public function updateData(Request $request)
    {

        self::withValidate($request);


        DB::beginTransaction();
        try {

            $header = Product::where("id", $request->id)
            ->first();

            $header->fill([
                'prd_code' => $request->prd_code,
                'prd_desc' => $request->prd_desc,
                'type_desc' => $request->type_desc,
                'uom_desc' => $request->uom_desc,
                'sales_price' => Helper::cleanNum($request->sales_price ?? "0"),
                'qoh' => Helper::cleanNum($request->qoh ?? "0"),
                'is_active' => $request->is_active ?? false,
                "updated_by" => auth()->id(),
            ])
            ->save();

            DB::commit();

            return response([
                'message' => 'Success! You have successfully updated.',
            ])->setStatusCode(200);
        }
        catch(\PDOException $e) {
            DB::rollback();

            return response([
                'message' => "Failed! Internal Database Error. " .$e->getMessage(),
                'errors' => $e,
            ])->setStatusCode(500);
        }
        catch(\Exception $e) {
            DB::rollback();

            return response([
                'message' => "Failed! ". $e->getMessage(),
                'errors' => $e,
            ])->setStatusCode(500);
        }
    }

    public function store(Request $request)
    {
        if ($request->ke == 'createData'){ return $this->createData($request); }
        if ($request->ke == 'editData'){ return $this->editData($request); }
        if ($request->ke == 'deleteData'){ return $this->deleteData($request); }
        if ($request->ke == 'updateData'){ return $this->updateData($request); }

    }

    public function show(string $id, Request $request)
    {
        if ($id == 'dataAll') {return $this->dataAll($request);}
        if ($id == 'getForm') {return $this->getForm($request);}
    }

    public function dataAll(Request $request)
    {

        try{

            $total_data = Product::count();

            $data = Product::when($request->prd_desc, function($q) use($request){
                $q->where('prd_desc', 'ilike', "%$request->prd_desc%");
            })
            ->when($request->prd_code, function($q) use($request){
                $q->where('prd_code', 'ilike', "%$request->prd_code%");
            })
            ->when($request->status == "1", function($q) use($request){
                $q->whereNull('deleted_at');
            })
            ->when($request->status == "0", function($q) use($request){
                $q->whereNotNull('deleted_at');
            })
            ->get()
            ->map(function($row){
                App::setLocale('id');
                return [
                    "id" => $row->id,
                    "prd_code" => $row->prd_code,
                    "prd_desc" => $row->prd_desc,
                    "type_desc" => $row->type_desc,
                    "created_at" => Helper::dateFullInd($row->created_at),
                    "deleted_at" => Helper::dateFullInd($row->deleted_at),
                    "created_by" => optional($row->createdBy)->name,
                    "deleted_by" => optional($row->deletedBy)->name,
                    "status" => $row->deleted_at,
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



    public function getForm(Request $request)
    {
        try {

            return view('mie-gacoan.product.main', [
                'data'=>$this->data,
                'disab'=>'',
                'ke'=>'createData',
                'header' => null,
            ]);

        }
        catch(\PDOException $e) {

            return response([
                'message' => "Failed! Internal Database Error. " .$e->getMessage(),
                'errors' => $e,
            ])->setStatusCode(500);
        }
        catch(\Exception $e) {

            return response([
                'message' => "Failed! ". $e->getMessage(),
                'errors' => $e,
            ])->setStatusCode(500);
        }
    }

    public static function withValidate(Request $request, array $rules = [], array $messages = [])
    {
        return $request->validate(
            collect([
                'prd_code' => 'required',
                'prd_desc' => 'required',
                'type_desc' => 'required',
                'uom_desc' => 'required',
            ])
            ->merge($rules)
            ->toArray(),
            collect([
                'prd_code.required' => "Item Code can't be empty.",
                'prd_desc.required' => "Item Desc can't be empty.",
                'type_desc.required' => "Type can't be empty.",
                'uom_desc.required' => "UoM can't be empty.",
            ])
            ->merge($messages)
            ->toArray()
        );
    }


}
