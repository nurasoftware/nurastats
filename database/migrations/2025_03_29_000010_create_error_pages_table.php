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
        if (!Schema::hasTable('error_pages')) {

            Schema::create('error_pages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('site_id');                
                $table->text('path')->nullable();        
                $table->text('referrer')->nullable();                
                $table->text('data')->nullable();        
                $table->integer('counter')->nullable();
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
        Schema::dropIfExists('error_pages');
    }
};
