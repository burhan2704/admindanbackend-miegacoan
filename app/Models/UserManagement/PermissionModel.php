<?php

namespace App\Models\UserManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    use HasFactory;

    protected $table = 'permissions';
    protected $guarded = [];

    public function view_menu_tree()
    {
        return $this->hasOne(ViewMenuTreeModel::class, 'id', 'menu_id')->withDefault();
    }

    
}
