<?php

namespace App\Helpers;

use App\Services\CompanyManagementService;
use App\Services\UserManagementService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Helper
{
    public static function sort($request, $data)
    {
        if (!isset($request->order) || !is_array($request->order)) {
            return $data;
        }

        foreach ($request->order as $v) {
            if (isset($request->columns[$v['column']]['data'])) {
                $ord_col = $request->columns[$v['column']]['data'];
                $ord_dir = $v['dir'] ?? 'asc';

                if ($ord_dir === 'asc') {
                    $data = $data->sortBy($ord_col);
                } else {
                    $data = $data->sortByDesc($ord_col);
                }
            }
        }

        return $data;
    }


    public static function filterDifferentSchema($request, $model, $whereHas)
    {
        if (!$request->prod_code) {return true;}
        return $model->$whereHas ? str_contains($model->$whereHas->prd_desc, $request->prod_code) : false;
    }


     public static function dateFullInd($tanggal = NULL)
    {
        $hari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        $bulan = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];

        $formatTanggal = date("l, d F Y H:i:s", strtotime($tanggal));
        $hariInggris = date("l", strtotime($tanggal));
        $bulanInggris = date("F", strtotime($tanggal));

        $formatTanggal = str_replace($hariInggris, $hari[$hariInggris], $formatTanggal);
        $formatTanggal = str_replace($bulanInggris, $bulan[$bulanInggris], $formatTanggal);

        return $tanggal ? $formatTanggal : NULL;
    }

    public static function rolePermission($URL)
    {

        return (object) [
            // "hasAccess" => null,
            "hasAccess" => self::hasAccess($URL),
            "company" => CompanyManagementService::listCompany(),
            "isSuperAdmin" => Auth::user()->is_superadmin == true ? "Active" : NULL,
            "superAdminDisplay" => Auth::user()->is_superadmin == true ? NULL : "style='display: none;'"
        ];
    }


    public static function hasAccess($URL)
    {
        if(Auth::user()->is_superadmin == true) {
            return DB::table('users as a')
            ->join('permissions as b', 'b.role_id', '=', 'a.role_id')
            ->join('menus as c', 'c.id', '=', 'b.menu_id')
            ->select(
                'a.id as user_id',
                'a.company_id',
                'c.route',
                'b.can_create',
                'b.can_update',
                'b.can_view',
                'b.can_delete',
                'b.can_open',
                'b.can_confirm'
            )
            ->where('a.id', Auth::user()->id)
            ->where('c.route', $URL)
            ->whereRaw("
                (
                    b.can_create = TRUE OR
                    b.can_update = TRUE OR
                    b.can_delete = TRUE OR
                    b.can_view = TRUE OR
                    b.can_print = TRUE OR
                    b.can_open = TRUE OR
                    b.can_confirm = TRUE
                )
            ")
            ->first();

        }

        if(!Auth::user()->is_superadmin || Auth::user()->is_superadmin == false) {
            return DB::table('users as a')
            ->join('permissions as b', function ($join) {
                $join->on('b.role_id', '=', 'a.role_id')
                    ->on('b.company_id', '=', 'a.company_id');
            })
            ->join('menus as c', 'c.id', '=', 'b.menu_id')
            ->select(
                'a.id as user_id',
                'a.company_id',
                'c.route',
                'b.can_create',
                'b.can_update',
                'b.can_view',
                'b.can_delete',
                'b.can_open',
                'b.can_confirm'
            )
            ->where('a.id', Auth::user()->id)
            ->where('a.company_id', Auth::user()->company_id)
            ->where('c.route', $URL)
            ->whereRaw("
                (
                    b.can_create = TRUE OR
                    b.can_update = TRUE OR
                    b.can_delete = TRUE OR
                    b.can_view = TRUE OR
                    b.can_print = TRUE OR
                    b.can_open = TRUE OR
                    b.can_confirm = TRUE
                )
            ")
            ->first();
        }

    }

    public static function breadcrumb($url)
    {

        return collect(DB::select("select * from fn_breadcrumb('$url')"))
        ->values();
    }


   public static function validateForeignTable($primaryKeyValues, $foreignChecks)
    {
        if (!is_array($primaryKeyValues)) {
            $primaryKeyValues = [$primaryKeyValues];
        }

        $usedTables = [];

        foreach ($foreignChecks as $check) {
            $table = $check['table'];
            $field = $check['field'];

            $exists = DB::table($table)
                ->whereIn($field, $primaryKeyValues)
                ->exists();

            if ($exists) {
                $usedTables[] = str_replace('public.', '', $table);
            }
        }

        if (!empty($usedTables)) {
            throw new \Exception("Data ini masih digunakan di tabel: " . implode(', ', $usedTables));
        }
    }


    public static function cleanNum($str = "0")
	{
		return preg_replace("/[^\d\.]/", "", $str);
	}



}
