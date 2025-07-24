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
        Schema::create('relationships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->enum('status', [
                'Single',
                'In a relationship',
                'Engaged',
                'Married',
                'In a civil union',
                'In a domestic partnership',
                'In an open relationship',
                "Complicated",
                'Separated',
                'Divorced',
                'Widowed'
            ])->nullable();
            $table->uuid('partner_id')->nullable();
            $table->date('anniversary_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('partner_id')
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
        Schema::dropIfExists('relationships');
    }
};
