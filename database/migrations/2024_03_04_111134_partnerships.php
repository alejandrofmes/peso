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
        Schema::create('partnerships', function (Blueprint $table) {
            $table->id('partnership_id');
            $table->unsignedBigInteger('peso_id')->comment('Foreign Key');
            $table->unsignedBigInteger('company_id')->comment('Foreign Key');
            $table->string('partnership_Status', 255)->default('PENDING');
            $table->text('partnership_Remarks')->nullable();
            $table->datetime('responded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('peso_id')->references('peso_id')->on('peso');
            $table->foreign('company_id')->references('company_id')->on('company');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partnerships', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('programs');
    }
};
