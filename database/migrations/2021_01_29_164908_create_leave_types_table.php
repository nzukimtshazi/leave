<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('leaveTypes')) {
            Schema::create('leaveTypes', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('type');
                $table->integer('daysPerCycle');
                $table->integer('cycle_length');
                $table->timestamps();
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
        Schema::dropIfExists('leaveTypes');
    }
}
