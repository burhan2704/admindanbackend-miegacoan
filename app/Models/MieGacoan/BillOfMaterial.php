<?php

namespace App\Models\MieGacoan;

use App\Models\UserManagement\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfMaterial extends Model
{
    use HasFactory;

    protected $table = 'gms_boms';
    protected $guarded = [];

      public function createdBy()
    {
        return $this->hasOne(UserModel::class, 'id', 'created_by')->withDefault();
    }

    public function updatedBy()
    {
        return $this->hasOne(UserModel::class, 'id', 'updated_by')->withDefault();
    }

      public function finishGoods()
    {
        return $this->hasOne(Product::class, 'id', 'prd_id')->withDefault();
    }


}
