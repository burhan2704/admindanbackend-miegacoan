<?php

namespace App\Models\UserManagement;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 

class ViewMenuTreeModel extends Model
{
    use HasFactory;

    protected $table = 'vw_menu_tree';
    protected $guarded = [];

}