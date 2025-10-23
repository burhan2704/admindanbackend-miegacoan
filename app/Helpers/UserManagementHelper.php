<?php

namespace App\Helpers;

use App\Models\UserManagement\MenuModel;
use App\Models\UserManagement\ViewMenuTreeModel;
use Illuminate\Support\Facades\Route;
use Str;
use Illuminate\Support\Facades\Request;
class UserManagementHelper
{
    public static function sidebarMenus(){
        return self::buildNestedMenu(ViewMenuTreeModel::get());
    }

    public static function sidebarMenusPermission(){
        return self::buildNestedMenu(MenuModel::getMenuTreePermission());
    }

    protected static function buildNestedMenu($menus, $parentId = null)
    {
        $data = [];

        foreach ($menus as $menu) {
            if ($menu->parent_id == $parentId) {
                $children = self::buildNestedMenu($menus, $menu->id);
                if ($children) {
                    $menu->children = $children;
                }
                $data[] = $menu;
            }
        }
        return $data;
    }

    public static function isUrlInChildren($menu, $currentUrl)
    {
        if (!isset($menu->children)) {
            return false;
        }

        foreach ($menu->children as $child) {
            if (url($child->route) == $currentUrl) {
                return true;
            }
            
            if (isset($child->children) && self::isUrlInChildren($child, $currentUrl)) {
                return true;
            }
        }

        return false;
    }
}
