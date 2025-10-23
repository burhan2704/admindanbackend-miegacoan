<?php

namespace App\Models\Inventory\Master;

use App\Models\UserManagement\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GroupModel extends Model
{
    use HasFactory;

    protected $table = 'im_groups';
    protected $guarded = [];

      public function createdBy()
    {
        return $this->hasOne(UserModel::class, 'id', 'created_by')->withDefault();
    }

    public function updatedBy()
    {
        return $this->hasOne(UserModel::class, 'id', 'updated_by')->withDefault();
    }

    public function deletedBy()
    {
        return $this->hasOne(UserModel::class, 'id', 'deleted_by')->withDefault();
    }

     public function scopeAuthCompany($query)
    {
        if (Auth::check() && !Auth::user()->is_superadmin) {
            return $query->where("company_id", Auth::user()->company_id);
        }
        
        return $query;
    }

    

}
