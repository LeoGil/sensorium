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
        Schema::create('extraction_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('extraction_id')->constrained()->onDelete('cascade');
            $table->text('description');
            $table->integer('step_order');
            $table->integer('start_step_time')->nullable()->comment('Start time of the step in seconds');
            $table->integer('end_step_time')->nullable()->comment('End time of the step in seconds');
            $table->decimal('water_amount', 5, 2)->nullable()->comment('Amount of water used in this step in grams');
            $table->decimal('total_water_amount', 5, 2)->nullable()->comment('Total amount of water used in the extraction in grams');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extraction_steps');
    }
};
