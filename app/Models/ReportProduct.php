<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportProduct extends Model
{
    use HasFactory;

    protected $table = 'report_product';
    protected $primaryKey = 'report_id';
    public $timestamps = false;

    public function products(){
        return $this->hasMany(Product::class, "product_id", "product_id");
    }

    public function stores(){
        return $this->hasMany(Store::class, "store_id", "store_id");
    }

    public function storeAreas()
    {
        return $this->belongsToMany(StoreArea::class, "store", "store_id", "area_id");
    }
}
