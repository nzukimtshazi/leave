<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLeaveCalculationtableWorkdays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leaveCalculation', function (Blueprint $table)
        {
            $table->integer('work_daysPerWeek')->after('id');
            $table->decimal('leaveDays_taken', 4, 2)->after('leaveDays_available');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leaveCalculation', function(Blueprint $table) {
            $table->dropColumn('work_daysPerWeek');
            $table->dropColumn('leaveDays_taken');
        });
    }
}
