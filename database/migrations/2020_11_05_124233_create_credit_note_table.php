<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_note', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('credit_note_code')->nullable();
            $table->string('do_number')->nullable();
            $table->string('year')->nullable();
            $table->string('index')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('pieces')->nullable();
            $table->float('tonnage',14,2)->nullable();
            $table->double('total_cost',15,2)->nullable();
            $table->double('amount')->nullable();
            $table->date('credit_note_date')->nullable();
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
        Schema::dropIfExists('credit_note');
    }
}
