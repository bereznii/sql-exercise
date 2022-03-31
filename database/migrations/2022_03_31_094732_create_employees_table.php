<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->uuid('department_id');

            $table->string('first_name');
            $table->string('last_name');
            $table->bigInteger('phone')->unique();
            $table->string('email')->unique();
            $table->string('gender', 10);
            $table->integer('salary');
            $table->date('hired_at');

            $table->timestamps();


            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->cascadeOnDelete();
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
