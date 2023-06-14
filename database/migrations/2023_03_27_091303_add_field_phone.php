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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->unique()->after('email')->comment('Телефон');
            $table->string('last_name')->after('name')->comment('Фамилия')->nullable();
            $table->string('middle_name')->after('last_name')->comment('Отчество')->nullable();
            $table->boolean('actual')->default(true)->comment('Актуальность');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('last_name');
            $table->dropColumn('middle_name');
            $table->dropColumn('actual');
        });
    }
};
