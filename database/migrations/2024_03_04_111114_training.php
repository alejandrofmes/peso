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
        Schema::create('training', function (Blueprint $table) {
            $table->id('training_id');
            $table->unsignedBigInteger('employee_id')->comment('Foreign Key');
            $table->string('training_Name', 255);
            $table->string('training_From', 255);
            $table->string('training_Cert', 255);
            $table->date('training_Start');
            $table->date('training_End')->nullable();
            $table->tinyInteger('training_Status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('employee_id')->on('employee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('training');
    }
};
