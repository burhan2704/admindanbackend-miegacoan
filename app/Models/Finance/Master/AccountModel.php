<?php

namespace App\Models\Finance\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountModel extends Model
{
    use HasFactory;

    protected $table = 'fm_accounts';
    protected $guarded = [];

}
