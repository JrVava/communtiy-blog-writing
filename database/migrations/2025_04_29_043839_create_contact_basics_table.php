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
        Schema::create('contact_basics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('relationship_status')->nullable();
            $table->string('birthday')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->longText('bio')->nullable();
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
        Schema::dropIfExists('contact_basics');
    }
};
