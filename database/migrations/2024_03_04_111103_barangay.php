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
        Schema::create('barangay', function (Blueprint $table) {
            $table->id('barangay_id');
            $table->unsignedBigInteger('municipality_id');
            $table->string('barangay_Name', 255);
            $table->string('barangay_Code', 10);
            $table->timestamps();
            $table->softDeletes();
            // Foreign key constraint
            $table->foreign('municipality_id')->references('municipality_id')->on('municipality');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangay', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('barangay');
    }
};
