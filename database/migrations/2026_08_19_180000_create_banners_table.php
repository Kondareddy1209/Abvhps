<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('banners')) {
            Schema::create('banners', function (Blueprint $table) {
                $table->id();
                $table->string('page_key', 100)->index();
                $table->string('page_name', 150)->nullable();
                $table->string('title', 255)->nullable();
                $table->text('subtitle')->nullable();
                $table->string('desktop_banner');
                $table->string('mobile_banner')->nullable();
                $table->string('status', 20)->default('show'); // 'show' or 'hide'
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        } else {
            Schema::table('banners', function (Blueprint $table) {
                if (!Schema::hasColumn('banners', 'page_key')) {
                    $table->string('page_key', 100)->default('home')->index()->after('id');
                }
                if (!Schema::hasColumn('banners', 'page_name')) {
                    $table->string('page_name', 150)->nullable()->after('page_key');
                }
                if (!Schema::hasColumn('banners', 'title')) {
                    $table->string('title', 255)->nullable()->after('page_name');
                }
                if (!Schema::hasColumn('banners', 'subtitle')) {
                    $table->text('subtitle')->nullable()->after('title');
                }
                if (!Schema::hasColumn('banners', 'desktop_banner')) {
                    $table->string('desktop_banner')->after('subtitle');
                }
                if (!Schema::hasColumn('banners', 'mobile_banner')) {
                    $table->string('mobile_banner')->nullable()->after('desktop_banner');
                }
                if (!Schema::hasColumn('banners', 'status')) {
                    $table->string('status', 20)->default('show')->after('mobile_banner');
                }
                if (!Schema::hasColumn('banners', 'sort_order')) {
                    $table->integer('sort_order')->default(0)->after('status');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
