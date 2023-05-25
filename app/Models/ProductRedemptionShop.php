<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRedemptionShop extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'product_id',
        'product_category',
        'product_variant',
        'vendor_id',
        'sku_code',
        'uom',
        'points',
        'quantity',
        'images'
    ];
}
