<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table = 'store';
    protected $primaryKey = 'store_id';
    public $timestamps = false;

    public function storeArea(){
        return $this->hasMany(StoreArea::class, "area_id", "area_id");
    }

    public function storeaccount(){
        return $this->hasMany(StoreAccount::class, "account_id", "account_id");
    }

    public function reportProduct(){
        return $this->belongsTo(ReportProduct::class, "store_id", "store_id");
    }
}
