<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('var_name', 100);
            $table->string('var_last_name', 100);
            $table->char('var_dni', 8);
            $table->string('var_address', 100)->nullable();
            $table->string('var_phone', 50)->nullable();
            $table->string('var_mobile', 50)->nullable();
            $table->string('var_email', 100)->nullable();
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
        Schema::dropIfExists('employees');
    }
}
