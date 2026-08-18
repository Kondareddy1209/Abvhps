<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        /**
     * Run the migrations to deploy the core Blogs and religious articles repository database table.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id(); // Unique Serial Key (S.NO Mapping)
            $table->string('title'); // Official Heading / Blog Name title of the article
            $table->string('image_path')->nullable(); // Main full-size image file directory destination locator
            $table->string('thumbnail_path')->nullable(); // Small preview thumbnail image file directory locator
            $table->text('content')->nullable(); // Comprehensive description body context or Rich Text parameters
            $table->enum('status', ['active', 'draft'])->default('active'); // Status flag boundary control (Active / Published / Draft)
            $table->timestamps(); // System automated created_at and updated_at records logs
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
