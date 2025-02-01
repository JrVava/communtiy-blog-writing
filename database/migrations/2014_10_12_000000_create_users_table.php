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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('user_name')->unique();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('city')->nullable();

            $table->string('home_town')->nullable();
            $table->string('university')->nullable();
            $table->string('passing_year')->nullable();
            $table->string('degree')->nullable();
            $table->string('working_or_business')->nullable();
            $table->string('password');
            $table->boolean('is_approve')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
