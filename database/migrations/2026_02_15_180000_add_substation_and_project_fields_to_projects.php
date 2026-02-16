<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('substation_id')->nullable()->after('project_manager_id')->constrained()->nullOnDelete();
            $table->string('timeline')->nullable()->after('description');
            $table->date('date_of_commissioning')->nullable()->after('deadline');
            $table->date('scheduled_date_of_completion')->nullable()->after('date_of_commissioning');
            $table->decimal('project_cost', 15, 2)->nullable()->after('scheduled_date_of_completion');
            $table->string('scheme')->nullable()->after('project_cost');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['substation_id']);
            $table->dropColumn([
                'timeline',
                'date_of_commissioning',
                'scheduled_date_of_completion',
                'project_cost',
                'scheme',
            ]);
        });
    }
};
