<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PtpyrelTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //$table->integer('votes');
        Schema::create('ptpyrel_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ptid');
            $table->integer('pyid');
            $table->string('att_file');
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
        //
    }
}
