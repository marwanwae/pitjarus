<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    use HasFactory;

    protected $table = 'product_brand';
    protected $primaryKey = 'brand_id';
    public $timestamps = false;

    public function product(){
        return $this->belongsTo(Product::class, "brand_id", "brand_id");
    }
}
