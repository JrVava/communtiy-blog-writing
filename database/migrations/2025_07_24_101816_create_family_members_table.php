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
        Schema::create('family_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('family_member_id')->nullable();
            $table->enum('relationship', [
                'Parent',
                'Mother',
                'Father',
                'Sibling',
                'Brother',
                'Sister',
                'Child',
                'Son',
                'Daughter',
                'Grandparent',
                'Grandmother',
                'Grandfather',
                'Uncle',
                'Aunt',
                'Cousin',
                'Nephew',
                'Niece',
                'Spouse',
                'Partner'
            ])->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('family_member_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
