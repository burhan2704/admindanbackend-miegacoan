<?php
namespace App\Http\Controllers;

use App\Models\MieGacoan\BillOfMaterial;
use App\Models\MieGacoan\PointOfSale;
use App\Models\MieGacoan\PointOfSaleDetail;
use App\Models\MieGacoan\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelfOrderController extends Controller
{
     public function index()
    {

        $type = DB::select("
            select type_desc from gms_products
            where is_active = true and type_desc <>  'RAW MATERIAL'
            group by 1
        ");

        $finish_goods = DB::select("

            select id, prd_desc name, concat(type_desc, ' ',prd_code,' ',prd_desc) description, round(sales_price,0) price, type_desc category, 'images/logo/miegacoan.png' image from gms_products
            where is_active = true and type_desc <>  'RAW MATERIAL'
            and qoh > 0
        ");

        return view("self-order.main",[
            "type" => $type,
            "finish_goods" => $finish_goods,
        ]);
    }


        public function store(Request $request)
        {
            try {
                DB::beginTransaction();

                // return $request->all();

                $header = PointOfSale::create([
                    "trans_date" => date("Y-m-d", strtotime("now")),
                    "store_name" => "POS CABANG MALANG",
                    "shift_name" => "LONG SHIFT CABANG MALANG",
                    "station_name" => "POS 2",
                    "beginning_amount" => 0,
                    "ending_amount" => 0,
                    "seat_no" => $request->table_number,
                    "cust_name" => $request->customer_name,
                    "created_at" => now(),
                    "created_by" => Auth::user()->id ?? 1,

                ]);

                $data_detail = collect($request->items);

                if($data_detail->count() == 0) {
                    throw new \Exception("Detail can not be empty.");
                }

                $totalPayment = 0;
                $tempDetail = [];
                $data_detail->each(function ($v) use(&$tempDetail, &$totalPayment, $header) {
                    if (!isset($v['product_id']) || !$v['product_id']) {
                        throw new \Exception("Raw Material can't be empty", 400);
                    }
                    if (!isset($v['quantity']) || floatval($v['quantity']) <= 0) {
                        throw new \Exception("Qty can't be empty", 400);
                    }

                    $subTotal = floatval($v['quantity']) * floatval($v['price']);
                    $totalPayment += $subTotal;

                    $tempDetail[] = [
                        'trans_id' => $header->id,
                        'prd_id' => $v['product_id'],
                        'qty' => $v['quantity'],
                        'price' => $v['price'],
                        'sub_total' => $subTotal,
                    ];

                    $product = Product::find($v['product_id']);
                    if ($product) {
                        $product->decrement('qoh', $v['quantity']);
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
                    "data" => [
                        "trans_no" => $header->trans_no,
                        "order_id" => $header->id,
                        "customer_name" => $header->cust_name,
                        "table_number" => $header->seat_no,
                        "total_payment" => $header->total_payment,
                        "order_date" => $header->trans_date
                    ],
                    "message" => "Order berhasil dibuat dan sedang diproses"
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
