<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveCalculationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('leaveCalculation')) {
            Schema::create('leaveCalculation', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->decimal('leaveDays_available', 4, 2);
                $table->unsignedBigInteger('leaveType_id');
                $table->unsignedBigInteger('employee_id');
                $table->timestamps();
            });
            Schema::table('leaveCalculation', function ($table) {
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
        Schema::dropIfExists('leaveCalculation');
    }
}
