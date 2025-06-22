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
        if (!Schema::hasTable('user_stats')) {

            Schema::create('user_stats', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('site_id');
                $table->date('date');
                $table->integer('count_pageviews')->default(0);
                $table->integer('count_events')->default(0);
                $table->integer('count_actions')->default(0);
                $table->timestamps();

                $table->foreign('site_id')->references('id')->on('sites')->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_stats');
    }
};
