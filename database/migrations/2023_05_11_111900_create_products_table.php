<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique()->comment('Название');
            $table->float('price', 15, 2)->comment('Цена')->nullable();
            $table->float('sum', 15, 2)->comment('Сумма')->nullable();
            $table->float('count', 15, 2)->comment('Количество')->nullable();
            $table->longText('description')->comment('Описание')->nullable();
            $table->boolean('is_credit')->default(false)->comment('Используется кредитный лимит');
            $table->unsignedBigInteger('cheque_id');
            $table->foreign('cheque_id')->references('id')->on('cheques')->onDelete('cascade');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('products_types')->onDelete('cascade');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE cheques COMMENT 'Товары из чеков'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
