<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Advanced Multi-Media Fundraising Engine.
     */
    public function up(): void
    {
        Schema::create('fundraising_campaigns', function (Blueprint $table) {
            $table->id();
            
            // Core Identity Parameters
            $table->string('title');
            $table->text('description');
            
            // Financial Ledger Metrics
            $table->decimal('target_amount', 12, 2); // Supporting large target sums up to crores
            $table->decimal('raised_amount', 12, 2)->default(0.00); // Initialized at zero
            
            // Expiry Matrix Node
            $table->date('end_date');
            
            // Primary Media Asset Paths
            $table->string('cover_image');
            
            // Up to 4 Additional Contextual Gallery Images Repository (Nullable Nodes)
            $table->string('image_1')->nullable();
            $table->string('image_2')->nullable();
            $table->string('image_3')->nullable();
            $table->string('image_4')->nullable();
            
            // Emergency Explainer Video Asset Path (Nullable Node)
            $table->string('video_path')->nullable();
            
            // Campaign Lifecycle State Configuration
            $table->enum('status', ['active', 'expired'])->default('active');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fundraising_campaigns');
    }
};
