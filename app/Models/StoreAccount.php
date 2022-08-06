<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreAccount extends Model
{
    use HasFactory;

    protected $table = 'store_account';
    protected $primaryKey = 'account_id';
    public $timestamps = false;

    public function store(){
        return $this->belongsTo(Store::class, "account_id", "account_id");
    }
}
