<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditNoteDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_note_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('credit_note_id')->nullable();
            $table->string('product_id')->nullable();
            $table->text('product_name')->nullable();
            $table->string('sub')->nullable();
            $table->string('variation_id')->nullable();
            $table->text('variation_display')->nullable();
            $table->text('piece_col')->nullable();
            $table->integer('total_piece')->nullable();
            $table->double('price')->nullable();
            $table->double('cost',10,4)->nullable();
            $table->double('amount',15,5)->nullable();
            $table->double('tonnage',15,4)->nullable();
            $table->double('footrun',10,4)->nullable();
            $table->integer('cal_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_note_detail');
    }
}
