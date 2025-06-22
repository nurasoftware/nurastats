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
        Schema::create('stats_main', function (Blueprint $table) {
            $table->id();
            $table->char('hash', 32);
            $table->unsignedBigInteger('site_id');
            
            $table->mediumInteger('visitors_h')->default(0);            
            $table->mediumInteger('visitors_d')->default(0);            
            $table->mediumInteger('visitors_w')->default(0);            
            $table->mediumInteger('visitors_m')->default(0);            

            

            $table->integer('last')->nullable();
            $table->tinyInteger('scroll_percent')->nullable();     

            $table->foreign('site_id')->references('id')->on('sites')->cascadeOnDelete();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats_main');
    }
};
