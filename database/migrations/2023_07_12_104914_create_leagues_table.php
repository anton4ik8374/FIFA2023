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
        Schema::create('leagues', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->text('name')->nullable()->comment('Наименование базовое');
            $table->text('name_ru')->nullable()->comment('Наименование на русском');
            $table->text('slug')->nullable()->comment('Альтернативное название');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leagues');
    }
};
