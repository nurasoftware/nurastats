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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->char('code', 15)->unique();   
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->string('type', 25);            
            $table->string('label', 25);            
            $table->string('slug', 50);           
            $table->text('description')->nullable();            
            $table->boolean('active')->default(false);            
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('sites')->cascadeOnDelete();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
