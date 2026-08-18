<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to add exam results and winners infrastructure.
     */
    public function up(): void
    {
        Schema::table('exam_applications', function (Blueprint $table) {
            // Standard examination score tracking elements
            $table->integer('marks_obtained')->nullable()->after('hall_ticket_number');
            $table->enum('result_status', ['pending', 'passed', 'failed'])->default('pending')->after('marks_obtained');
            
            // Winners desk layout columns (Strict budget for top 6 profiles)
            $table->integer('winner_rank')->nullable()->after('result_status'); // 1 to 6 numerical allocation
            $table->string('prize_title_won')->nullable()->after('winner_rank'); // Tablet, TV, Dinner Set
            $table->boolean('show_on_winners_wall')->default(false)->after('prize_title_won');
        });
    }
    /**
     * Reverse the migrations to drop exam results and winners infrastructure.
     */
    public function down(): void
    {
        Schema::table('exam_applications', function (Blueprint $table) {
            $table->dropColumn([
                'marks_obtained', 
                'result_status', 
                'winner_rank', 
                'prize_title_won', 
                'show_on_winners_wall'
            ]);
        });
    }
};
