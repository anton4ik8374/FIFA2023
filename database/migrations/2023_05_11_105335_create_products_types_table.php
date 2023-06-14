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
        Schema::create('products_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('code', false)->comment('Код');
            $table->string('name')->unique()->comment('Название');
            $table->longText('description')->comment('Описание')->nullable();
            $table->boolean('actual')->default(true)->comment('Актуальность');
            $table->index('code');
            $table->timestamps();
        });

        \DB::statement("ALTER TABLE cheques COMMENT 'Типы товаров'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_types');
    }
};
