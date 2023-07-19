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
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->integer('external_id', false)->nullable()->comment('Идентификатор процесса в A-parser');
            $table->string('name')->comment('Наименование cron');
            $table->boolean('status')->default(true)->comment('Статус (данные получены = true, не получены = false)')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
