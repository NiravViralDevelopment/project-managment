<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('circle_id')->nullable()->after('zone_id')->constrained()->nullOnDelete();
            $table->foreignId('division_id')->nullable()->after('circle_id')->constrained()->nullOnDelete();
            $table->foreignId('substation_id')->nullable()->after('division_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['circle_id']);
            $table->dropForeign(['division_id']);
            $table->dropForeign(['substation_id']);
        });
    }
};
