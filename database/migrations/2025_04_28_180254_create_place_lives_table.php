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
        Schema::create('place_lives', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('place')->nullable();
            $table->string('date_moved')->nullable();
            $table->enum('place_type',['Moved','Currently Living','Hometown'])->default('Currently Living');
            $table->uuid('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place_lives');
    }
};
