<?php

namespace App\Models\Finance\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupAccountModel extends Model
{
    use HasFactory;

    protected $table = 'fm_group_accounts';
    protected $guarded = [];

}
