<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->id('employee_id');
            $table->unsignedBigInteger('user_id')->unsigned()->comment('Foreign Key');
            $table->string('fname', 255);
            $table->string('mname', 255)->nullable();
            $table->string('lname', 255);
            $table->string('suffix', 255)->nullable();
            $table->string('height', 3)->nullable();
            $table->tinyInteger('gender');
            $table->tinyInteger('civilstatus');
            $table->tinyInteger('religion')->nullable();
            $table->date('birthdate');
            $table->string('pnumber', 255);
            $table->string('address', 255);
            $table->unsignedBigInteger('barangay_id')->unsigned()->comment('Foreign Key');
            $table->string('tinnum', 15)->nullable();
            $table->tinyInteger('empstatus');
            $table->tinyInteger('empstatusdesc');
            $table->tinyInteger('ofw')->nullable();
            $table->tinyInteger('fourp')->nullable();
            $table->string('fourpID', 20)->nullable();
            $table->string('pimg', 255);
            $table->string('resume', 255)->nullable();
            $table->text('empDesc')->nullable();
            $table->tinyInteger('empprofile')->default(1)->nullable();
            $table->timestamps();
            $table->softDeletes(); // This will add created_at and updated_at columns

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('barangay_id')->references('barangay_id')->on('barangay');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('employee');
    }
};
