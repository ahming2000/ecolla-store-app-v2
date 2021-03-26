<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportExampleData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('system_configs')->insert(
            array(
                'name' => '脉动维生素功能饮料',
                'name_en' => 'MaiDong Energy Drink',
                'desc' => '好喝的饮料',
                'desc_en' => 'Delicious Drink',
                'brand' => '脉动',
                'brand_en' => 'Mai Dong',
                'origin' => '中国',
                'origin_en' => 'China'
            )
        );
        DB::table('system_configs')->insert(
            array(
                'name' => '脉动维生素功能饮料',
                'name_en' => 'MaiDong Energy Drink',
                'desc' => '好喝的饮料',
                'desc_en' => 'Delicious Drink',
                'brand' => '脉动',
                'brand_en' => 'Mai Dong',
                'origin' => '中国',
                'origin_en' => 'China'
            )
        );
        DB::table('system_configs')->insert(
            array(
                'name' => '脉动维生素功能饮料',
                'name_en' => 'MaiDong Energy Drink',
                'desc' => '好喝的饮料',
                'desc_en' => 'Delicious Drink',
                'brand' => '脉动',
                'brand_en' => 'Mai Dong',
                'origin' => '中国',
                'origin_en' => 'China'
            )
        );
        DB::table('system_configs')->insert(
            array(
                'name' => '脉动维生素功能饮料',
                'name_en' => 'MaiDong Energy Drink',
                'desc' => '好喝的饮料',
                'desc_en' => 'Delicious Drink',
                'brand' => '脉动',
                'brand_en' => 'Mai Dong',
                'origin' => '中国',
                'origin_en' => 'China'
            )
        );
        DB::table('system_configs')->insert(
            array(
                'name' => '脉动维生素功能饮料',
                'name_en' => 'MaiDong Energy Drink',
                'desc' => '来一杯，享受好时光',
                'desc_en' => 'Enjoy life',
                'brand' => 'RIO',
                'brand_en' => 'RIO',
                'origin' => '中国',
                'origin_en' => 'China'
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
