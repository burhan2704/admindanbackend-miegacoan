<?php

namespace App\Models\CompanyManagement;

use App\Models\UserManagement\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CompanyModel extends Model
{
    use HasFactory;

    protected $table = 'companies';
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

    public function user()
    {
        return $this->hasOne(UserModel::class, 'company_id', 'id')->withDefault();
    }

    public function scopeAuthCompany($query)
    {
        if (Auth::check() && !Auth::user()->is_superadmin) {
            return $query->where("id", Auth::user()->company_id);
        }
        
        return $query;
    }

}
