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
        Schema::create('extractions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->constrained()->onDelete('cascade');
            $table->foreignId('filter_id')->constrained()->onDelete('cascade');
            $table->foreignId('brewing_method_id')->constrained()->onDelete('cascade');
            $table->foreignId('grinder_id')->constrained()->onDelete('cascade');
            $table->decimal('coffee_dose', 5, 2);
            $table->decimal('water_amount', 6, 2);
            $table->decimal('ratio', 5, 2);
            $table->string('grind_setting')->comment('Grind setting used for the extraction');
            $table->foreignId('water_id')->constrained()->onDelete('cascade');
            $table->decimal('water_temperature', 5, 2)->comment('Temperature in Celsius');
            $table->integer('total_time')->comment('Total brewing time in seconds');
            $table->decimal('tds', 4, 2)->nullable()->comment('Total Dissolved Solids');
            $table->decimal('ey', 4, 2)->nullable()->comment('Extraction Yield (%)');
            $table->integer('acidity')->comment('Acidity rating from 1 to 10');
            $table->integer('sweetness')->comment('Sweetness rating from 1 to 10');
            $table->integer('body')->comment('Body rating from 1 to 10');
            $table->integer('aftertaste')->comment('Aftertaste rating from 1 to 10');
            $table->integer('balance')->comment('Balance rating from 1 to 10');
            $table->text('tasting_notes')->comment('Notes about the tasting experience');
            $table->string('image')->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extractions');
    }
};
