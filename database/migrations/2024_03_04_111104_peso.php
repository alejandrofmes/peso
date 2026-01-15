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
        Schema::create('peso', function (Blueprint $table) {
            $table->id('peso_id');
            $table->unsignedBigInteger('municipality_id');
            $table->text('peso_Description')->nullable();
            $table->string('peso_Email', 255)->nullable();
            $table->string('peso_Phone', 15)->nullable();
            $table->string('peso_Tel', 15)->nullable();
            $table->string('peso_Fax', 20)->nullable();
            $table->string('peso_Img', 255)->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes();

            $table->foreign('municipality_id')->references('municipality_id')->on('municipality');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peso', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('peso');
    }
};
