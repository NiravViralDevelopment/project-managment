<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('voltage_level', 50)->nullable()->after('description');
            $table->decimal('line_length_km', 12, 2)->nullable()->after('voltage_level');
            $table->decimal('approved_cost_cr', 15, 2)->nullable()->after('line_length_km');
            $table->date('scheduled_cod')->nullable()->after('approved_cost_cr');
            $table->date('target_cod')->nullable()->after('scheduled_cod');
            $table->string('executing_agency')->nullable()->after('target_cod');
            $table->string('review_period')->nullable()->after('executing_agency');
            $table->string('overall_status', 20)->nullable()->after('review_period'); // On Track, At Risk, Delayed
            $table->decimal('expenditure_till_date', 15, 2)->nullable()->after('overall_status');
            $table->decimal('billing_pending', 15, 2)->nullable()->after('expenditure_till_date');
            $table->decimal('cost_overrun', 15, 2)->nullable()->after('billing_pending');
            $table->string('financial_health', 50)->nullable()->after('cost_overrun');
            $table->text('summary_text')->nullable()->after('financial_health');
            $table->integer('expected_foundation_nos')->nullable()->after('summary_text');
            $table->integer('expected_erection_nos')->nullable()->after('expected_foundation_nos');
            $table->decimal('expected_stringing_km', 12, 2)->nullable()->after('expected_erection_nos');
            $table->string('clearance_expected')->nullable()->after('expected_stringing_km');
        });

        Schema::create('project_physical_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('activity');
            $table->decimal('total_scope', 12, 2)->default(0);
            $table->decimal('achieved', 12, 2)->default(0);
            $table->decimal('balance', 12, 2)->default(0);
            $table->decimal('progress_pct', 5, 2)->default(0);
            $table->string('unit', 20)->nullable(); // km or Nos
            $table->timestamps();
        });

        Schema::create('project_clearances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('clearance_type');
            $table->integer('total')->default(0);
            $table->integer('obtained')->default(0);
            $table->integer('pending')->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('project_bottlenecks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('location'); // Village/Taluka/District
            $table->text('issue_summary')->nullable();
            $table->timestamps();
        });

        Schema::create('project_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('milestone_name');
            $table->date('planned_date')->nullable();
            $table->date('actual_date')->nullable();
            $table->string('status', 50)->nullable(); // On Track, Delayed
            $table->integer('schedule_variance_days')->nullable(); // +/-
            $table->timestamps();
        });

        Schema::create('project_risks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('issue');
            $table->string('impact', 50)->nullable(); // High, Medium
            $table->string('responsibility')->nullable();
            $table->text('action_plan')->nullable();
            $table->date('target_date')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('project_manpower', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('parameter'); // Manpower Deployment, etc.
            $table->string('status')->nullable(); // Adequate, Satisfactory, etc.
            $table->timestamps();
        });

        Schema::create('project_decisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->text('decision_text');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'voltage_level', 'line_length_km', 'approved_cost_cr', 'scheduled_cod', 'target_cod',
                'executing_agency', 'review_period', 'overall_status', 'expenditure_till_date',
                'billing_pending', 'cost_overrun', 'financial_health', 'summary_text',
                'expected_foundation_nos', 'expected_erection_nos', 'expected_stringing_km', 'clearance_expected',
            ]);
        });
        Schema::dropIfExists('project_decisions');
        Schema::dropIfExists('project_manpower');
        Schema::dropIfExists('project_risks');
        Schema::dropIfExists('project_milestones');
        Schema::dropIfExists('project_bottlenecks');
        Schema::dropIfExists('project_clearances');
        Schema::dropIfExists('project_physical_progress');
    }
};
