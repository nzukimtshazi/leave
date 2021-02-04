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
                $table->date('day1');
                $table->string('day1Register');
                $table->date('day2');
                $table->string('day2Register');
                $table->date('day3');
                $table->string('day3Register');
                $table->date('day4');
                $table->string('day4Register');
                $table->date('day5');
                $table->string('day5Register');
                $table->date('day6');
                $table->string('day6Register');
                $table->date('day7');
                $table->string('day7Register');
                $table->date('last_captureDate');
                $table->unsignedBigInteger('employee_id');
                $table->timestamps();
            });
            Schema::table('attendanceRegister', function ($table) {
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
