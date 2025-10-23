<?php

namespace App\Models\MieGacoan;

use App\Models\UserManagement\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfMaterialDetail extends Model
{
    use HasFactory;

    protected $table = 'gms_bom_details';
    protected $guarded = [];

      public function createdBy()
    {
        return $this->hasOne(UserModel::class, 'id', 'created_by')->withDefault();
    }

    public function updatedBy()
    {
        return $this->hasOne(UserModel::class, 'id', 'updated_by')->withDefault();
    }


    public function rawMaterial()
    {
        return $this->hasOne(Product::class, 'id', 'rm_id')->withDefault();
    }

}
