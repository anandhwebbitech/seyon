<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('type')->nullable()->after('category_id');
            $table->integer('shop_by_age_id')->nullable()->after('type');
            $table->integer('shop_by_price_id')->nullable()->after('shop_by_age_id');
            $table->string('slug')->nullable()->after('product_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['type','shop_by_age_id','shop_by_price_id','slug']);
        });
    }
};
