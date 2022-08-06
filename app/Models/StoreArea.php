<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreArea extends Model
{
    use HasFactory;

    protected $table = 'store_area';
    protected $primaryKey = 'area_id';
    public $timestamps = false;

    public function store(){
        return $this->belongsTo(Store::class, "area_id", "area_id");
    }

    public function reportProducts()
    {
        return $this->belongsToMany(ReportProduct::class, "store", "area_id", "store_id");
    }
}
