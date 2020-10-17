<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceCodeToCashbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashbook', function (Blueprint $table) {
            $table->text('invoice_id')->nullable()->after('company_name');
            $table->text('invoice_code')->nullable()->after('invoice_id');
            $table->date('invoice_date')->nullable()->after('invoice_code');
            $table->float('amount',15,2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashbook', function (Blueprint $table) {
            $table->dropColumn('invoice_code');
            $table->dropColumn('invoice_id');
            $table->dropColumn('invoice_date');
        });
    }
}
