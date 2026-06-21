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
        Schema::table('posts', function (Blueprint $table) {
            $table->json('author_roles')->nullable()->after('user_id');
            $table->string('author_treatment_status')->nullable()->after('author_roles');
            $table->json('author_treatment_types')->nullable()->after('author_treatment_status');
            $table->date('author_birth_date')->nullable()->after('author_treatment_types');
            $table->date('author_diagnosed_at')->nullable()->after('author_birth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'author_roles',
                'author_treatment_status',
                'author_treatment_types',
                'author_birth_date',
                'author_diagnosed_at',
            ]);
        });
    }
};
