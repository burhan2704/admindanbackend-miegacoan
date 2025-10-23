<?php

namespace App\Models\CompanyManagement;

use App\Models\UserManagement\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DepartmentModel extends Model
{
    use HasFactory;

    protected $table = 'departments';
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


    public function company()
    {
        return $this->hasOne(CompanyModel::class, 'id', 'company_id');
    }
    

    public function scopeAuthCompany($query)
    {
        if (Auth::check() && !Auth::user()->is_superadmin) {
            return $query->where("company_id", Auth::user()->company_id);
        }
        return $query;
    }



}
