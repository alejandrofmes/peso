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
        Schema::create('education', function (Blueprint $table) {
            $table->id('education_id');
            $table->unsignedBigInteger('employee_id')->comment('Foreign Key');
            $table->string('edu_School', 255)->nullable();
            $table->tinyInteger('edu_Level');
            $table->string('edu_Course', 255)->nullable();
            $table->date('edu_Started')->nullable();
            $table->date('edu_Ended')->nullable();
            $table->tinyInteger('edu_Ongoing')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Define foreign key constraint
            $table->foreign('employee_id')->references('employee_id')->on('employee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
