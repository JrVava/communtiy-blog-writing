<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_reactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('post_id')->constrained()->cascadeOnDelete();
            // $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->json('reactions')->nullable(); // Store multiple reaction types
            $table->timestamps();

            $table->foreign('post_id')
            ->references('id')
            ->on('posts')
            ->onDelete('cascade'); // One reaction row per user per post
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_reactions');
    }
};
