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
        if (!Schema::hasColumn('users', 'counsellor_name') &&
            !Schema::hasColumn('users', 'university_name') &&
            !Schema::hasColumn('users', 'year_of_admission')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('counsellor_name')->nullable();
                    $table->string('university_name')->nullable();
                    $table->string('year_of_admission')->nullable();
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
