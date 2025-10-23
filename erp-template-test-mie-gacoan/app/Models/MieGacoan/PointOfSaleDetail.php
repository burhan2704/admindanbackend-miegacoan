<?php

namespace App\Models\MieGacoan;

use App\Models\UserManagement\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointOfSaleDetail extends Model
{
    use HasFactory;

    protected $table = 'gms_pos_details';
    protected $guarded = [];

      public function createdBy()
    {
        return $this->hasOne(UserModel::class, 'id', 'created_by')->withDefault();
    }

    public function updatedBy()
    {
        return $this->hasOne(UserModel::class, 'id', 'updated_by')->withDefault();
    }


}
