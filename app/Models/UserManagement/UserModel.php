<?php

namespace App\Models\UserManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class UserModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'users';
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            if (! $user->isForceDeleting() && auth()->check()) {
                $user->deleted_by = auth()->id();
                $user->save();
            }
        });
    }

    public function createdBy()
    {
        return $this->hasOne(self::class, 'id', 'created_by')->withDefault();
    }

    public function updatedBy()
    {
        return $this->hasOne(self::class, 'id', 'updated_by')->withDefault();
    }

    public function deletedBy()
    {
        return $this->hasOne(self::class, 'id', 'deleted_by')->withDefault();
    }

     public function scopeAuthCompany($query)
    {
        if (Auth::check() && !Auth::user()->is_superadmin) {
            return $query->where("company_id", Auth::user()->company_id);
        }
        
        return $query;
    }

}
