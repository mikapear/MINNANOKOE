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
        Schema::create('learn_column_blocks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('learn_column_id')
                ->constrained('learn_columns')
                ->cascadeOnDelete();

            $table->string('subtitle')->nullable();
            $table->longText('body')->nullable();
            $table->string('image_path')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learn_column_blocks');
    }
};
