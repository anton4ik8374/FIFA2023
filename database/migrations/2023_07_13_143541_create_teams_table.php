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
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->text('name_en')->nullable()->comment('Наименование на русском');
            $table->text('name_ru')->nullable()->comment('Наименование на английском');
            $table->text('alter_name')->nullable()->comment('Альтернативное название');
            $table->text('description')->nullable()->comment('Описание');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
