<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('circles', function (Blueprint $table) {
            if (! Schema::hasColumn('circles', 'name')) {
                $table->string('name')->after('id');
            }
            if (! Schema::hasColumn('circles', 'zone_id')) {
                $table->foreignId('zone_id')->after('name')->constrained()->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('circles', function (Blueprint $table) {
            if (Schema::hasColumn('circles', 'zone_id')) {
                $table->dropForeign(['zone_id']);
            }
            if (Schema::hasColumn('circles', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
