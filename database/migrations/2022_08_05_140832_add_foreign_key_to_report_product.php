<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_product', function (Blueprint $table) {
            $table->foreign("store_id")->references("store_id")->on("store");
            $table->foreign("product_id")->references("product_id")->on("product");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_product', function (Blueprint $table) {
            //
        });
    }
};
