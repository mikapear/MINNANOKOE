<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->after('email');
            $table->date('diagnosed_at')->nullable()->after('birth_date');
            $table->json('treatment_types')->nullable()->after('diagnosed_at');
            $table->timestamp('privacy_consented_at')->nullable()->after('treatment_types');
            $table->boolean('is_admin')->default(false)->after('privacy_consented_at');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'birth_date',
                'diagnosed_at',
                'treatment_types',
                'privacy_consented_at',
                'is_admin',
            ]);
        });
    }
};
