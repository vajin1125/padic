<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhysicTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physic_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pin')->unique();

            $table->char('first_name', 150);
            $table->char('last_name', 150);
            $table->char('midd_name', 150);
            
            $table->char('bir_mm', 10);
            $table->char('bir_dd', 2);
            $table->char('bir_yy', 4);

            $table->enum('gender', ['male', 'female']);

            $table->string('email');

            $table->string('phone_num1');
            $table->string('phone_num2')->nullable();
            $table->string('phone_num3')->nullable();

            $table->string('address1');
            $table->string('address2')->nullable();

            $table->string('city');
            $table->string('state');

            $table->string('med_spec');
        
            $table->char('added_mm', 10);
            $table->char('added_dd', 2);
            $table->char('added_yy', 4);
            
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
