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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id('announcement_id');
            $table->string('announcement_Title', 255)->nullable();
            $table->text('announcement_Content')->nullable();
            $table->string('announcement_pubmat', 255)->nullable();
            $table->string('announcement_Status', 255)->nullable();
            $table->unsignedBigInteger('peso_id')->comment('Foreign Key');
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes();

            $table->foreign('peso_id')->references('peso_id')->on('peso');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('programs');
    }
};
