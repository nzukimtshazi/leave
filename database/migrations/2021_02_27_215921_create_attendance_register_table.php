<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('attendanceRegister')) {
            Schema::create('attendanceRegister', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('dayOfWeek');
                $table->string('register');
                $table->unsignedBigInteger('employeeType_id');
                $table->unsignedBigInteger('employee_id');
                $table->timestamps();
            });
            Schema::table('attendanceRegister', function ($table) {
                $table->foreign('employeeType_id')->references('id')->on('employeeTypes');
                $table->foreign('employee_id')->references('id')->on('employees');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendanceRegister');
    }
}
