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
                $table->decimal('annualLeaveCnt', 4, 2);
                $table->decimal('sickLeaveCnt', 4, 2);
                $table->decimal('familyRespLeaveCnt', 4, 2);
                $table->unsignedBigInteger('employee_id');
                $table->timestamps();
            });
            Schema::table('leaveCalculation', function ($table) {
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
