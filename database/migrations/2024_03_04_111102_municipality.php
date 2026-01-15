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
        Schema::create('municipality', function (Blueprint $table) {
            $table->id('municipality_id');
            $table->unsignedBigInteger('province_id');
            $table->string('municipality_Name', 255);
            $table->string('municipality_Code', 10);
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes();

            $table->foreign('province_id')->references('province_id')->on('province');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('municipality', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('municipality');
    }
};
