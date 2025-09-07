<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'user_privacy')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('user_privacy',['Private','Public'])->default('Private');
            });
            DB::table('users')->update(['user_privacy' => 'Private']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_privacy');
        });
    }
};
