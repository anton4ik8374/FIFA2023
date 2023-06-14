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
        Schema::create('cheques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('query_request')->comment('Данные запроса');
            $table->json('response')->nullable()->comment('Данные ответа');
            $table->integer('response_code', false)->nullable()->comment('Код ответа');
            $table->float('price', 15, 2)->comment('Цена')->nullable();
            $table->timestamp('date_cheque')->comment('Дата чека')->nullable();
            $table->boolean('is_credit')->default(false)->comment('Используется кредитный лимит');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE cheques COMMENT 'Данные по запросам для чеков'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheques');
    }
};
