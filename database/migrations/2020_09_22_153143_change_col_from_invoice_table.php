<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColFromInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->string('invoice_date')->nullable()->after('amount');
            $table->string('year')->nullable()->after('invoice_code');
            $table->string('index')->nullable()->after('year');
            $table->string('do_number')->nullable()->after('invoice_code');
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
            $table->dropColumn('invoice_date');
            $table->dropColumn('year');
            $table->dropColumn('index');
            $table->dropColumn('do_number');
        });
    }
}
