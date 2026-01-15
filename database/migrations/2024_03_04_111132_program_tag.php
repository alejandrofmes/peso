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
        Schema::create('program_tags', function (Blueprint $table) {
            $table->id('program_tags_id');
            $table->unsignedBigInteger('program_id')->comment('Foreign Key');
            $table->unsignedBigInteger('position_id')->comment('Foreign Key');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('program_id')->references('program_id')->on('programs');
            $table->foreign('position_id')->references('position_id')->on('job_positions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_tag', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('program_tag');
    }
};
