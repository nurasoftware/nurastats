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
        Schema::create('log_session', function (Blueprint $table) {
            $table->id();
            $table->char('hash', 36)->index();
            $table->unsignedBigInteger('visitor_id')->index();
            $table->unsignedBigInteger('site_id')->index();
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('event_id')->nullable();
            $table->text('referrer')->nullable();
            $table->string('referrer_host', 250)->nullable();
            $table->integer('first');
            $table->integer('last')->nullable();
            $table->tinyInteger('scroll_percent')->nullable();
            $table->tinyInteger('seconds_min')->nullable();
            $table->timestamp('created_at');

            $table->foreign('visitor_id')->references('id')->on('log_visitors')->cascadeOnDelete();
            $table->foreign('site_id')->references('id')->on('sites')->cascadeOnDelete();
            $table->foreign('page_id')->references('id')->on('log_pages')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_session');
    }
};
