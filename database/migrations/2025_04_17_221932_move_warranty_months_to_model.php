<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->date('warranty_expires_at')->nullable();
        });
        Schema::table('models', function (Blueprint $table) {
            $table->integer('warranty_months')->nullable();
        });
//
//        $assetsToUpdate = DB::table('assets')->where('warranty_months', '>', 0)
//            ->orWhere('warranty_months', '!=', null)->get();
//        foreach ($assetsToUpdate as $asset) {
//            $months = $asset->warranty_months;
//            $asset->warranty_expires_at = now()->addMonths($months);
//        }
//        DB::table('assets')->update($assetsToUpdate->toArray());
//
//        Schema::table('assets', function (Blueprint $table) {
//            $table->dropColumn('warranty_months');
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->integer('warranty_months')->nullable();
        });

        //stuff to do here. need to extract the warranty months and then add those months to each asset of that model


        Schema::table('model', function (Blueprint $table) {
            $table->dropColumn('warranty_months');
        });
    }
};
