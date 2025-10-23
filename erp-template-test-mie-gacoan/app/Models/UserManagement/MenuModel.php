<?php

namespace App\Models\UserManagement;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class MenuModel extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $guarded = [];

    protected $fillable = [
        'name',
        'url',
        'icon',
        'parent_id',
        'seq_id',
        'is_active',
    ];

    /**
     * Dapatkan item menu induk.
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Dapatkan item menu anak.
     */
    public function children()
    {
        return $this->hasMany(MenuModel::class, 'parent_id')->orderBy('seq_id');
    }

    /**
     * Lingkup query untuk hanya menyertakan menu aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    
    public static function getMenuTreePermission()
    {
        $roleId = Auth::user()->role_id;
        return collect(DB::select("SELECT * FROM fn_permission_menu($roleId)"));
    }

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