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
        Schema::create('status_checker', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id');
            $table->char('code', 32)->unique();           
            $table->mediumInteger('port')->nullable();
            $table->text('url');
            $table->smallInteger('status_code')->nullable(); 
            $table->decimal('response_time', total: 3,places: 3)->nullable();
            $table->text('headers')->nullable();
            $table->timestamp('at');

            $table->foreign('site_id')->references('id')->on('sites')->cascadeOnDelete();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_checker');
    }
};
