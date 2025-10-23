<?php

namespace App\Http\Controllers\MieGacoan;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\MieGacoan\BillOfMaterial;
use App\Models\MieGacoan\BillOfMaterialDetail;
use App\Models\MieGacoan\Product;
use App\Services\MieGacoanService;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use DB;

class BillOfMaterialController extends Controller
{
    const URL = "mie-gacoan-bom";
    const menuName = "Bill Of Material (BOM)";

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
            "content" => 'mie-gacoan.bill-of-material.index',
            "data" => $this->data,
            "status" => Service::listStatusMaster()
        ]);


    }

    public function createData(Request $request)
    {

        self::withValidate($request);


        DB::beginTransaction();
        try {

            $header = BillOfMaterial::create([
                'bom_code' => $request->bom_code,
                'bom_desc' => $request->bom_desc,
                'prd_id' => $request->prd_id,
                'is_active' => $request->is_active ?? false,
                "created_by" => auth()->id(),
            ]);


            $data_detail = collect($request->details);

            if($data_detail->count() == 0) {
                throw new \Exception("Detail can not be empty.");
            }


            $data_detail->chunk(100)
            ->each(function ($chunk) use($header){
                $tempDetail = $chunk->map(function ($v) use($header){
                    if (!$v['rm_id']) {throw new \Exception("Raw Material cant be empty");}
                    if (floatval($v['qty']) <= 0) {throw new \Exception("Qty can't be empty");}

                    return [
                        'bom_id' => $header->id,
                        'rm_id' => $v['rm_id'],
                        'qty' => $v['qty'],
                         "created_by" => auth()->id(),
                    ];
                })->toArray();

                BillOfMaterialDetail::insert($tempDetail);
            });


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

            $header = BillOfMaterial::where("id", $request->id)->first();
            $detail = BillOfMaterialDetail::where("bom_id", $header->id)->get();


            return view('mie-gacoan.bill-of-material.main', [
                'data'=>$this->data,
                'disab'=> $request->disab,
                'ke'=>'updateData',
                'header' => $header,
                'detail' => $detail,
                'finish_goods' => MieGacoanService::listProduct("FINISH GOODS"),
                'raw_material' => MieGacoanService::listProduct("RAW MATERIAL"),
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

            $user = BillOfMaterial::find($request->id);
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


            $header = BillOfMaterial::where("id", $request->id)
            ->first();

            $header->fill([
                 'bom_code' => $request->bom_code,
                'bom_desc' => $request->bom_desc,
                'prd_id' => $request->prd_id,
                'is_active' => $request->is_active ?? false,
                "updated_by" => auth()->id(),
            ])
            ->save();

            $delete_details = collect($request->delete_details);

            BillOfMaterialDetail::where("bom_id", $header->id)
            ->whereIn("id", $delete_details)
            ->delete();

            $data_detail = collect($request->details);

            if($data_detail->count() == 0) {
                throw new \Exception("Detail can not be empty.");
            }

            $data_detail->each(function ($v) use($header){

                if (!$v['rm_id']) {throw new \Exception("Raw Material cant be empty");}
                if (floatval($v['qty']) <= 0) {throw new \Exception("Qty can't be empty");}


                BillOfMaterialDetail::updateOrCreate(
                    [
                        'rm_id' => $v['rm_id'],
                        'bom_id' => $header->id,
                    ],
                    [
                        'qty' => $v['qty'],
                        'updated_by' => auth()->id()
                    ]
                );
            });

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

            $total_data = BillOfMaterial::count();

            $data = BillOfMaterial::when($request->bom_code, function($q) use($request){
                $q->where('bom_code', 'ilike', "%$request->bom_code%");
            })
            ->when($request->bom_desc, function($q) use($request){
                $q->where('bom_desc', 'ilike', "%$request->bom_desc%");
            })
            ->when($request->prd_desc, function($q) use($request){
                $q->whereHas('finishGoods', function($qq) use($request){
                     $qq->where('prd_code', 'ilike', "%{$request->prd_desc}%")
                    ->orWhere('prd_desc', 'ilike', "%{$request->prd_desc}%");
                });
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
                    "bom_code" => $row->bom_code,
                    "bom_desc" => $row->bom_desc,
                    "prd_desc" => $row->finishGoods->prd_desc,
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

            return view('mie-gacoan.bill-of-material.main', [
                'data'=>$this->data,
                'disab'=>'',
                'ke'=>'createData',
                'header' => null,
                'detail' => [],
                'finish_goods' => MieGacoanService::listProduct("FINISH GOODS"),
                'raw_material' => MieGacoanService::listProduct("RAW MATERIAL"),
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
                'bom_code' => 'required',
                'bom_desc' => 'required',
                'prd_id' => 'required'
            ])
            ->merge($rules)
            ->toArray(),
            collect([
                'bom_code.required' => "Bom Code can't be empty.",
                'bom_desc.required' => "Bom Desc can't be empty.",
                'prd_id.required' => "Finish Goods can't be empty."
            ])
            ->merge($messages)
            ->toArray()
        );
    }


}
