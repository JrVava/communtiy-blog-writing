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
        //

        if (!Schema::hasColumn('users', 'country')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('country')->nullable();
                $table->unsignedBigInteger('o_country')->nullable();

                $table->foreign('country')->references('id')->on('countries');
                $table->foreign('o_country')->references('id')->on('countries');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
