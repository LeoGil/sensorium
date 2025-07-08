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
        Schema::create('coffees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('sensory')->nullable();
            $table->string('farm')->nullable();
            $table->string('variety')->nullable();
            $table->string('region')->nullable();
            $table->integer('altitude')->nullable();
            $table->string('producer')->nullable();
            $table->string('processing_method')->nullable();
            $table->string('roaster')->nullable();
            $table->integer('score')->nullable();
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable();
            $table->foreignId('roast_level_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coffees');
    }
};
