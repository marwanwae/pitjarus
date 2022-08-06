<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'product_id';
    public $timestamps = false;

    public function productBrands(){
        return $this->hasMany(ProductBrand::class, "brand_id", "brand_id");
    }

    public function reportProduct(){
        return $this->belongsTo(ReportProduct::class, "product_id", "product_id");
    }
}
