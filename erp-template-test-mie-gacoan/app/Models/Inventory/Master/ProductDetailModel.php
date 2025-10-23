<?php

namespace App\Models\Inventory\Master;

use App\Models\UserManagement\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductDetailModel extends Model
{
    use HasFactory;

    protected $table = 'im_product_details';
    protected $guarded = [];
    
}
