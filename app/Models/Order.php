<?php

namespace App\Models;

use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Delivery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];

    protected $casts = ['user_obj' => 'array', "address_obj" => "array", "delivery_obj" => "array"];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function address()
    {
        return $this->belongsTo(Address::class)->withTrashed();
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class)->withTrashed();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot("color_name", "color_hex_code", "color_price", "guarantee_persian_name", "guarantee_price", "product_price", "number", "total_price", "product_obj")->withTrashed();
    }
}