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
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('surname');
                $table->string('email')->unique();
                $table->string('password');
                $table->rememberToken();
                $table->enum('countryCRUD', ['Y', 'N'])->default('N');
                $table->enum('companyCRUD', ['Y', 'N'])->default('N');
                $table->enum('departmentCRUD', ['Y', 'N'])->default('N');
                $table->enum('teamCRUD', ['Y', 'N'])->default('N');
                $table->enum('employeeTypeCRUD', ['Y', 'N'])->default('N');
                $table->enum('leaveTypeCRUD', ['Y', 'N'])->default('N');
                $table->enum('employeeCRUD', ['Y', 'N'])->default('N');
                $table->enum('attReg', ['Y', 'N'])->default('N');
                $table->enum('leaveCRUD', ['Y', 'N'])->default('N');
                $table->enum('settings', ['Y', 'N'])->default('N');
                $table->enum('reportView', ['Y', 'N'])->default('N');
                $table->enum('roleCRUD', ['Y', 'N'])->default('N');
                $table->enum('userCRUD', ['Y', 'N'])->default('N');
                $table->unsignedBigInteger('role_id');
                $table->timestamps();
            });
            Schema::table('users', function ($table) {
                $table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('users');
    }
}
