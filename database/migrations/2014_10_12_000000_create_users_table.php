<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mpid');

            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('spec')->nullable();
            $table->enum('role', ['superAdmin', 'subAdmin', 'physician', 'patient', 'norole'])->default('physician');
            $table->string('password');
            $table->string('photofile');
            $table->enum('active', ['yes', 'no'])->default('no'); // y: active, n: disable
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
