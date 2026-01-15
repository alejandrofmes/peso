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
        Schema::create('language', function (Blueprint $table) {
            $table->id('language_id');
            $table->unsignedBigInteger('employee_id')->comment('Foreign Key');
            $table->string('language_Type', 255);
            $table->tinyInteger('language_Read');
            $table->tinyInteger('language_Write');
            $table->tinyInteger('language_Speak');
            $table->tinyInteger('language_Understand');
            $table->timestamps();
            $table->softDeletes(); // Adds created_at and updated_at columns

            $table->foreign('employee_id')->references('employee_id')->on('employee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('language', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('language');
    }
};
