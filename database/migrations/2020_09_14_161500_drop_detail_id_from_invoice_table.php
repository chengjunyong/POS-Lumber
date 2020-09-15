<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropDetailIdFromInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropColumn('detail_id');
            $table->string('invoice_id')->nullable()->change();
            $table->string('company_id')->nullable()->after('invoice_id');
            $table->float('tonnage',10,4)->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->string('detail_id')->after('id');
            $table->dropColumn('company_id');
        });
    }
}
