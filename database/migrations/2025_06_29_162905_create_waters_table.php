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
        Schema::create('waters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('chlorine')->nullable();
            $table->decimal('calcium');
            $table->decimal('magnesium');
            $table->decimal('total_dissolved_solids')->nullable();
            $table->decimal('hardness')->nullable()->comment('(Calcium x 2.5) + (Magnesium x 4.2) in mg/L');
            $table->decimal('bicarbonate');
            $table->decimal('alkalinity')->nullable()->comment('Bicarbonate x 0.8 in mg/L');
            $table->decimal('ph')->nullable();
            $table->decimal('sodium')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waters');
    }
};
