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
        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->unsignedBigInteger('matche_id')->comment('Матч');
            $table->foreign('matche_id')->references('id')->on('matches')->onDelete('cascade');
            $table->unsignedBigInteger('win_team_id')->nullable()->comment('Команда на которую ставить');
            $table->foreign('win_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->text('chat_gpt_result')->nullable()->comment('Результат анализа от ChatGPT');
            $table->text('program_analysis_result')->nullable()->comment('Результат анализа от приложения');
            $table->float('count_forecasts', 10, 3)->nullable()->comment('Количество прогнозов участвующих в анализе')->nullable();
            $table->float('count_forecasts_win', 10, 3)->nullable()->comment('Количество перевесивших прогнозов')->nullable();
            $table->timestampTz('created_at', 0)->nullable()->comment('Дата создания')->nullable();
            $table->timestampTz('updated_at', 0)->nullable()->comment('Дата последнего обновления')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
