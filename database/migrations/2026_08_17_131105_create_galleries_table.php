<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        /**
     * Run the migrations to deploy the core Galleries photo and video tracking database table.
     */
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id(); // Unique Serial Key (S.NO Mapping)
            $table->string('image_path')->nullable(); // Disk storage locator for uploaded service event photos
            $table->string('video_url')->nullable(); // Dynamic embedded link reference for official videos
            $table->enum('media_type', ['image', 'video'])->default('image'); // Media categorisation parameter boundary
            $table->timestamps(); // System automated created_at and updated_at records logs
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
