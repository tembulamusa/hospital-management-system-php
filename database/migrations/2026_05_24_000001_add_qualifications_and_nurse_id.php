<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('qualifications')->nullable()->after('specialization');
        });

        Schema::table('nurse_triages', function (Blueprint $table) {
            $table->foreignId('nurse_id')->nullable()->after('visit_id')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('nurse_triages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('nurse_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('qualifications');
        });
    }
};
