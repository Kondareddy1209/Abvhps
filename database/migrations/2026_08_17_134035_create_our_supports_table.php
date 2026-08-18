<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        /**
     * Run the migrations to deploy the core Our Support mission tracking database table.
     */
    public function up(): void
    {
        Schema::create('our_supports', function (Blueprint $table) {
            $table->id(); // Unique Serial Key (S.NO Mapping)
            $table->string('name'); // Official Core Project Name (e.g., ANNAPURNA, COW-SAMRAKSHA)
            $table->integer('sort_order')->default(1); // Priority weight ordering for homepage rendering layouts
            $table->string('image_path')->nullable(); // Disk storage locator for official project icons/images
            $table->text('short_info')->nullable(); // Brief mission statement description text fragment (Short Description)
            $table->enum('status', ['show', 'hide'])->default('show'); // Status flag parameter boundary
            $table->timestamps(); // System automated created_at and updated_at records logs
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_supports');
    }
};
