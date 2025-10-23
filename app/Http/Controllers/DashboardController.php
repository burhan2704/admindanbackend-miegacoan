<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\RouteHelper;
use App\Http\Controllers\Controller;
use App\Models\UserManagement\Menu;
use App\Models\UserManagement\PermissionModel;
use App\Models\UserManagement\RoleModel;
use App\Models\UserManagement\UserModel;
use App\Models\User;
use App\Services\Service;
use App\Services\UserManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use DB;

class DashboardController extends Controller
{
    const URL = "home";

    public function __construct() {
        $this->data = [
            "url"=> self::URL,
            "title"=> UserManagementService::menuName(self::URL),
            "breadcrumb" => Helper::breadcrumb(self::URL)
        ];

        $this->data=(object) $this->data;
    }

    public function index()
    {
        return view('layouts.content.index', [
            "content" => 'dashboard',
            "data" => $this->data
        ]);


    }


}
