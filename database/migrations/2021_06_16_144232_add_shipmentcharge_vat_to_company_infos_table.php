<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShipmentchargeVatToCompanyInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_infos', function (Blueprint $table) {
            $table->integer('shipment_charge')->nullable()->after('iframe_location');
            $table->integer('vat_percentage')->nullable()->after('shipment_charge');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_infos', function (Blueprint $table) {
            $table->dropColumn('shipment_charge');
            $table->integer('vat_percentage');
        });
    }
}
