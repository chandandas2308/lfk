<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'product_name',
        'chinese_product_name',
        'barcode',
        'barcode_id',
        'product_varient',
        'description',
        'product_category',
        'category_id',
        'featured_product',
        'img_path',
        'uom',
        'sku_code',
        'batch_code',
        'min_sale_price',
        'discount_price'      ,
        'images',
        'discount_percentage' ,
        'discount_type'       ,
        'discount_face_value' ,
        'discount_start_date' ,
        'discount_end_date'   ,
        'tax',
        'supplier_id',
        'supplier_code',
    ];
}