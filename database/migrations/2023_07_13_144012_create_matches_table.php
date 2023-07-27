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
        Schema::create('matches', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->text('slug')->unique()->nullable()->comment('Альтернативное название');
            $table->text('name')->nullable()->comment('Наименование базовое');
            $table->text('name_ru')->nullable()->comment('Наименование на русском');
            $table->text('description')->nullable()->comment('Комментарий')->nullable();
            $table->unsignedBigInteger('event_id')->comment('События сбора данных');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->unsignedBigInteger('team_home_id')->comment('команда дома');
            $table->foreign('team_home_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unsignedBigInteger('team_away_id')->comment('команда на выезде');
            $table->foreign('team_away_id')->references('id')->on('teams')->onDelete('cascade');
            $table->timestamp('date_event')->useCurrent()->comment('Дата и время матча');
            $table->float('odds', 10, 3)->nullable()->comment('Шансы')->nullable();
            $table->float('all_tips', 10, 3)->nullable()->comment('Всего прогнозов')->nullable();
            $table->float('win_tips', 10, 3)->nullable()->comment('Прогнозы по выигрышу')->nullable();
            $table->text('bet')->nullable()->comment('Ставка/Исход');
            $table->unsignedBigInteger('league_id')->comment('Лига')->nullable();
            $table->foreign('league_id')->references('id')->on('leagues')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
