<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;
use App\Models\Store;
use App\Models\StoreArea;
use App\Models\ProductBrand;
use App\Models\ReportProduct;
use App\Models\StoreAccount;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModeTest extends TestCase
{
    public function testBrandAll(){
        $brands = ProductBrand::all();
        
        $this->assertNotNull($brands);
    }

    public function testStoreArea(){
        $storeAreas = StoreArea::all();
        
        $this->assertNotNull($storeAreas);
    }

    public function testStoreAccount(){
        $storeAccounts = StoreAccount::all();
        
        $this->assertNotNull($storeAccounts);
    }

    public function testStore(){
        $store = Store::with(["storeArea", "storeAccount"])
        ->get();
        dump($store);
        
        $this->assertNotNull($store);
    }

    public function testProduct(){
        $product = Product::with("productBrands")->get();

        $this->assertNotNull($product);
    }

    public function testReportProduct(){
        $reportProduct = ReportProduct::with(["products", "stores", "storeAreas"])->get();
        dump($reportProduct);
        
        $this->assertNotNull($reportProduct);
    }

    
}
