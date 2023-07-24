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
        Schema::create('forecasts', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->text('author')->nullable()->comment('Наименование');
            $table->float('roi', 10, 3)->nullable()->comment('Коэффициент рентабельности прогноза')->nullable();
            $table->float('odds', 10, 3)->nullable()->comment('Шансы')->nullable();
            $table->text('bet')->nullable()->comment('Ставка/Исход');
            $table->text('type')->nullable()->comment('Тип прогноза');
            $table->text('outcome')->nullable()->comment('Исход');
            $table->text('forecast')->nullable()->comment('Прогноз');
            $table->float('like', 10, 3)->nullable()->comment('Лайк')->nullable();
            $table->float('dislike', 10, 3)->nullable()->comment('Дизлайк')->nullable();
            $table->timestamp('date_publish')->nullable()->useCurrent()->comment('Дата прогноза');
            $table->unsignedBigInteger('matche_id')->comment('Матч');
            $table->foreign('matche_id')->references('id')->on('matches')->onDelete('cascade');
            $table->unsignedBigInteger('team_home_id')->comment('команда дома');
            $table->foreign('team_home_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unsignedBigInteger('team_away_id')->comment('команда на выезде');
            $table->foreign('team_away_id')->references('id')->on('teams')->onDelete('cascade');
            $table->float('all_tips', 10, 3)->nullable()->comment('Всего прогнозов')->nullable();
            $table->float('win_tips', 10, 3)->nullable()->comment('Прогнозы по выигрышу')->nullable();
            $table->float('confidence', 10, 3)->nullable()->comment('Вероятность')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forecasts');
    }
};
