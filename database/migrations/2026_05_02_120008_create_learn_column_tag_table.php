<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learn_column_tag', function (Blueprint $table) {
            $table->foreignId('learn_column_id')->constrained('learn_columns')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['learn_column_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learn_column_tag');
    }
};
