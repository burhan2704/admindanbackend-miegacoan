<?php

namespace App\Http\Controllers\MieGacoan\Api;

use App\Http\Controllers\Controller;
use App\Models\MieGacoan\BillOfMaterial;
use App\Models\MieGacoan\PointOfSale;
use App\Models\MieGacoan\PointOfSaleDetail;
use App\Models\MieGacoan\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PointOfSaleController extends Controller
{

     public function listStockProduct(Request $request)
    {
        try {


            $cekStock = Product::whereRaw("type_desc <> 'RAW MATERIAL' and qoh > 0")
            ->count();

            if ($cekStock == 0) {throw new \Exception("Stok produk telah habis", 400);}


            $data = Product::whereRaw("type_desc <> 'RAW MATERIAL' and qoh > 0")
            ->get()
            ->map(function ($item) {
                return [
                    "prd_id" => $item->id,
                    "prd_code" => $item->prd_code,
                    "prd_desc" => $item->prd_desc,
                    "type_desc" => $item->type_desc,
                    "uom_desc" => $item->uom_desc,
                    "qoh" => $item->qoh,
                    "sales_price" => $item->sales_price,
                ];
            });

            return response()->json([
                "response_code" => 200,
                "data" => $data,
                "message" => "Success"
            ], 200);

        } catch (\Exception $e) {
            $statusCode = ($e->getCode() && $e->getCode() >= 100 && $e->getCode() < 600)
                ? $e->getCode()
                : 500;

            return response()->json([
                "response_code" => $statusCode,
                "data" => [],
                "message" => "Failed! " . $e->getMessage(),
                "line" => $e->getLine(),
            ], $statusCode);
        }
    }

      public function scanStockBarcode(Request $request)
    {
        try {

            $checkProduct = Product::where("prd_code",  $request->prd_code)
            ->whereRaw("type_desc <> 'RAW MATERIAL'")
            ->first();

            if (!$checkProduct) {throw new \Exception("Barcode $request->prd_code tidak ditemukan", 400);}


            $checkStock = Product::where("prd_code",  $request->prd_code)
            ->whereRaw("type_desc <> 'RAW MATERIAL' and qoh > 0")
            ->first();

            if (!$checkStock) {throw new \Exception("Barcode $request->prd_code stok habis", 400);}


            return response()->json([
                "response_code" => 200,
                "data" => [
                    "prd_id" => $checkStock->id,
                    "prd_code" => $checkStock->prd_code,
                    "prd_desc" => $checkStock->prd_desc,
                    "type_desc" => $checkStock->type_desc,
                    "uom_desc" => $checkStock->uom_desc,
                    "qoh" => $checkStock->qoh,
                    "sales_price" => $checkStock->sales_price,
                ],
                "message" => "Success"
            ], 200);

        } catch (\Exception $e) {
            $statusCode = ($e->getCode() && $e->getCode() >= 100 && $e->getCode() < 600)
                ? $e->getCode()
                : 500;

            return response()->json([
                "response_code" => $statusCode,
                "data" => [],
                "message" => "Failed! " . $e->getMessage(),
                "line" => $e->getLine(),
            ], $statusCode);
        }
    }


     public function createPointOfSale(Request $request)
    {
        try {
            DB::beginTransaction();


            $header = PointOfSale::create([
                "trans_date" => date("Y-m-d", strtotime("now")),
                "store_name" => $request->store_name,
                "shift_name" => $request->shift_name,
                "station_name" => $request->station_name,
                "beginning_amount" => $request->beginning_amount,
                "ending_amount" => $request->ending_amount,
                "seat_no" => $request->seat_no,
                "cust_name" => $request->cust_name,
                "created_at" => now(),
                "created_by" => Auth::user()->id ?? 1,

            ]);

            $data_detail = collect($request->details);

            if($data_detail->count() == 0) {
                throw new \Exception("Detail can not be empty.");
            }

            $totalPayment = 0;
            $tempDetail = [];
            $data_detail->each(function ($v) use(&$tempDetail, &$totalPayment, $header) {
                if (!isset($v['prd_id']) || !$v['prd_id']) {
                    throw new \Exception("Raw Material can't be empty", 400);
                }
                if (!isset($v['qty']) || floatval($v['qty']) <= 0) {
                    throw new \Exception("Qty can't be empty", 400);
                }

                $subTotal = floatval($v['qty']) * floatval($v['price']);
                $totalPayment += $subTotal;

                $tempDetail[] = [
                    'trans_id' => $header->id,
                    'prd_id' => $v['prd_id'],
                    'qty' => $v['qty'],
                    'price' => $v['price'],
                    'sub_total' => $subTotal,
                ];

                $product = Product::find($v['prd_id']);
                if ($product) {
                    $product->decrement('qoh', $v['qty']);
                }

                BillOfMaterial::join("gms_bom_details", "gms_bom_details.bom_id", "=", "gms_boms.id")
                ->where("gms_boms.prd_id", $product->id)
                ->select("gms_bom_details.qty", "gms_bom_details.rm_id")
                ->get()
                ->map(function ($item) {
                    $rmProduct = Product::find($item->rm_id);
                    if ($rmProduct) {
                        $rmProduct->decrement('qoh', $item->qty);
                    }
                });

                $negativeStocks = Product::where('qoh', '<', 0)->get();

                if ($negativeStocks->count() > 0) {
                    $names = $negativeStocks->pluck('name')->join(', ');
                    throw new \Exception("Transaksi dibatalkan! Stok produk berikut menjadi minus: {$names}", 400);
                }

            });

            PointOfSaleDetail::insert($tempDetail);


            $numParam1 = date("Ym", strtotime($request->trans_date));

            $header->fill([
                "total_payment" => $totalPayment,
                "trans_no" => "POS/$numParam1/" . str_pad($header->id, 5, '0', STR_PAD_LEFT),
            ])->save();

            DB::commit();

            return response()->json([
                "response_code" => 200,
                "data" => [],
                "message" => "Created Successfully"
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();

            // Jika exception tidak punya code, fallback ke 500
            $statusCode = ($e->getCode() && $e->getCode() >= 100 && $e->getCode() < 600)
                ? $e->getCode()
                : 500;

            return response()->json([
                "response_code" => $statusCode,
                "data" => [],
                "message" => "Failed! " . $e->getMessage(),
                "line" => $e->getLine(),
                // "trace" => $e->getTrace(),
            ], $statusCode);
        }
    }


}
