<?php

namespace App\Models\Inventory\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinceModel extends Model
{
    use HasFactory;

    protected $table = 'provinces';
    protected $guarded = [];

}
