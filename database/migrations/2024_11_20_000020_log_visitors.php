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
        Schema::create('log_visitors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id')->index();
            $table->char('hash', 32)->index();           
            $table->string('ip', 50)->nullable();
            $table->char('geo_cc', 3)->nullable(); // Country code: RO, US...
            $table->string('geo_country', 25)->nullable();
            $table->string('geo_region', 25)->nullable();
            $table->string('geo_region_name', 50)->nullable();
            $table->string('geo_city', 75)->nullable();
            $table->string('geo_isp', 200)->nullable();
            $table->decimal('geo_lat', total: 9,places: 6)->nullable();
            $table->decimal('geo_long', total: 9, places: 6)->nullable();
            $table->char('device_type', 1)->nullable(); // m (mobile), t (tablet), d (desktop) or b (bot)
            $table->string('platform_family', 25)->nullable(); // Linux, Windows, Mac...
            $table->string('platform_name', 60)->nullable(); // Windows XP ....
            $table->string('platform_version', 25)->nullable(); // Windows XP ....
            $table->string('browser_family', 25)->nullable(); // Browser's vendor like Chrome, Firefox, Opera.
            $table->string('browser_name', 60)->nullable(); // Browser's human friendly name like Firefox 3.6, Chrome 42.
            $table->string('browser_version', 25)->nullable(); // Browser's human friendly version string.	
            $table->string('device_family', 25)->nullable(); // Device's vendor like Samsung, Apple, Huawei.	
            $table->string('device_model', 60)->nullable(); // Device's brand name like iPad, iPhone, Nexus.
            $table->string('screen_size', 15)->nullable();
            $table->integer('count_visits')->default(0);  
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('sites')->cascadeOnDelete();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_visitors');
    }
};
