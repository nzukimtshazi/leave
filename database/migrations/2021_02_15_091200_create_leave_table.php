<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('leave')) {
            Schema::create('leave', function (Blueprint $table) {
                $table->increments('id');
                $table->date('start_date');
                $table->date('end_date');
                $table->unsignedBigInteger('leaveType_id');
                $table->unsignedBigInteger('employee_id');
                $table->timestamps();
            });
            Schema::table('leave', function ($table) {
                $table->foreign('leaveType_id')->references('id')->on('leaveTypes');
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
        Schema::dropIfExists('leave');
    }
}
