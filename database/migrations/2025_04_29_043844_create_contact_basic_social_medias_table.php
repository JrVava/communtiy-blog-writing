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
        Schema::create('contact_basic_social_medias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('social_media_url')->nullable();
            $table->uuid('contact_basic_id');
            $table->timestamps();
            $table->foreign('contact_basic_id')->references('id')->on('contact_basics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_basic_social_medias');
    }
};
