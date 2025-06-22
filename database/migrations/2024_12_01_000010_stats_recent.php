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
        Schema::create('stats_recent', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id')->index();
            $table->date('day');
            $table->integer('visitors')->default(0);
            $table->integer('views')->default(0);
            $table->smallInteger('average_time')->nullable();
            $table->text('devices')->nullable();
            $table->mediumText('countries')->nullable();
            $table->mediumText('top_pages')->nullable();
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('sites')->cascadeOnDelete();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats_recent');
    }
};
