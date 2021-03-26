<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportSystemConfigs extends Migration
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
                'name' => 'orderCodePrefix',
                'value' => 'ECOLLA',
                'desc' => 'Prefix for order code which used to track delivery id in the website.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            )
        );
        DB::table('system_configs')->insert(
            array(
                'name' => 'maxRecordsPerPage',
                'value' => '8',
                'desc' => 'Prefix for order code which used to track delivery id in the website.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            )
        );
        DB::table('system_configs')->insert(
            array(
                'name' => 'maxManagementContent',
                'value' => '5',
                'desc' => 'Maximum content viewing at order-management.php and item-management.php page.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            )
        );
        DB::table('system_configs')->insert(
            array(
                'name' => 'shippingFeeEast',
                'value' => '5.66',
                'desc' => 'Shipping Fee in RM (Malaysia Ringgit) per kilogram for east Malaysia',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            )
        );
        DB::table('system_configs')->insert(
            array(
                'name' => 'shippingFeeWest',
                'value' => '4.77',
                'desc' => 'Shipping Fee in RM (Malaysia Ringgit) per kilogram for west Malaysia',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            )
        );
        DB::table('system_configs')->insert(
            array(
                'name' => 'shippingFeeKampar',
                'value' => '2.00',
                'desc' => 'Shipping Fee in RM (Malaysia Ringgit) per kilogram for Kampar, Perak, Malaysia',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
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
        DB::table('system_configs')->where('name', '=', 'orderCodePrefix')->delete();
        DB::table('system_configs')->where('name', '=', 'maxRecordsPerPage')->delete();
        DB::table('system_configs')->where('name', '=', 'maxManagementContent')->delete();
        DB::table('system_configs')->where('name', '=', 'shippingFeeEast')->delete();
        DB::table('system_configs')->where('name', '=', 'shippingFeeWest')->delete();
        DB::table('system_configs')->where('name', '=', 'shippingFeeKampar')->delete();
    }
}
