<?php

namespace App\Http\Controllers;

use App\Models\ProductBrand;
use Carbon\Carbon;
use App\Models\StoreArea;
use Illuminate\Http\Request;
use App\Models\ReportProduct;
use Illuminate\Support\Facades\DB;

class ReportPitjarusController extends Controller
{
    

    public function view(Request $request){

        $storeAreas = StoreArea::all();

        $reports = DB::table("report_product")
        ->join('store', 'report_product.store_id', '=', 'store.store_id')
        ->join('store_area', function($join){
            $join->on("report_product.store_id", "=", "store.store_id")
            ->on("store.area_id", "=", "store_area.area_id");
        })
        ->select("area_name")
        ->selectRaw("(SUM(compliance) / COUNT(*)) * 100 as sum_compliance")
        ->groupBy("area_name")
        ->get();

        $productBrands = ProductBrand::all();

        $table = DB::table("report_product")
        ->join('product', 'report_product.product_id', '=', 'product.product_id')
        ->join('store', 'report_product.store_id', '=', 'store.store_id')
        ->join('store_area', function($join){
            $join->on("report_product.store_id", "=", "store.store_id")
            ->on("store.area_id", "=", "store_area.area_id");
        })
        ->join('product_brand', function($join){
            $join->on("report_product.product_id", "=", "product.product_id")
            ->on("product.brand_id", "=", "product_brand.brand_id");
        })
        ->get();

        $arrayTemp = [];
        $arrayTemp[0][] = "Brand";

        foreach($storeAreas as $storeArea){
            $arrayTemp[0][] = $storeArea->area_name;
        }
        
        $i = 1;
        foreach($productBrands as $productBrand){
            $tests = collect($table)
            ->where("brand_name", "=", $productBrand->brand_name)
            ->groupBy("area_name");
            
            $counts = $tests->map(function($test)    {
                return $test->sum("compliance") / $test->count() * 100;
            });

            $arrayTemp[$i][] = $productBrand->brand_name;
            foreach($counts as $count){
                $arrayTemp[$i][] = (int)$count;
            }
            $i++;
        }

        return view("report", [
            "reports" => $reports,
            "storeAreas" => $storeAreas,
            "repotTables" => $arrayTemp
        ]);
    }

    public function filter(Request $request){
        $starDate = $request->input("date-from");
        $endDate = $request->input("date-to");
        $filterAreas = $request->input("area");
        
        $storeAreas = StoreArea::all();

        $reports = DB::table("report_product")
        ->join('store', 'report_product.store_id', '=', 'store.store_id')
        ->join('store_area', function($join){
            $join->on("report_product.store_id", "=", "store.store_id")
            ->on("store.area_id", "=", "store_area.area_id");
        })->where(function($query) use($starDate, $endDate, $filterAreas){
            if(!is_null($starDate)){
                $query->whereDate('tanggal', ">", $starDate);
            }
    
            if(!is_null($endDate)){
                $query->whereDate('tanggal', "<", $endDate);
            }
    
            if(!is_null($filterAreas)){
                $query->whereIn("store_area.area_id", $filterAreas);
            }
        })->select("area_name")
        ->selectRaw("(SUM(compliance) / COUNT(*)) * 100 as sum_compliance")
        ->groupBy("area_name")
        ->get();

        $productBrands = ProductBrand::all();

        $table = DB::table("report_product")
        ->join('product', 'report_product.product_id', '=', 'product.product_id')
        ->join('store', 'report_product.store_id', '=', 'store.store_id')
        ->join('store_area', function($join){
            $join->on("report_product.store_id", "=", "store.store_id")
            ->on("store.area_id", "=", "store_area.area_id");
        })
        ->join('product_brand', function($join){
            $join->on("report_product.product_id", "=", "product.product_id")
            ->on("product.brand_id", "=", "product_brand.brand_id");
        })->where(function($query) use($starDate, $endDate, $filterAreas){
            if(!is_null($starDate)){
                $query->whereDate('tanggal', ">", $starDate);
            }
    
            if(!is_null($endDate)){
                $query->whereDate('tanggal', "<", $endDate);
            }
    
            if(!is_null($filterAreas)){
                $query->whereIn("store_area.area_id", $filterAreas);
            }
        })->get();

        $arrayTemp = [];
        $arrayTemp[0][] = "Brand";
        if(!is_null($filterAreas)){
        $areaStores = $storeAreas->whereIn("area_id",$filterAreas);
        }else{
            $areaStores = $storeAreas;
        }
        foreach($areaStores as $storeArea){
            
            $arrayTemp[0][] = $storeArea->area_name;
        }
        
        $i = 1;
        foreach($productBrands as $productBrand){
            $tests = collect($table)
            ->where("brand_name", "=", $productBrand->brand_name)
            ->groupBy("area_name");
            
            $counts = $tests->map(function($test)    {
                return $test->sum("compliance") / $test->count() * 100;
            });

            $arrayTemp[$i][] = $productBrand->brand_name;
            foreach($counts as $count){
                $arrayTemp[$i][] = (int)$count;
            }
            $i++;
        }

        return view("report", [
            "reports" => $reports,
            "storeAreas" => $storeAreas,
            "repotTables" => $arrayTemp
        ]);
    }
    
}
