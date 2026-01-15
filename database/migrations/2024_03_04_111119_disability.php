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
        Schema::create('disability', function (Blueprint $table) {
            $table->id('disability_id');
            $table->unsignedBigInteger('employee_id')->comment('Foreign Key');
            $table->string('disability_Type', 256);
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
        Schema::table('disability', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('disability');
    }
};
