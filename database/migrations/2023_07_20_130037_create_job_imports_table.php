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
        Schema::create('job_imports', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->text('site')->nullable()->comment('название сайта');
            $table->text('name')->nullable()->comment('Название лиги');
            $table->text('slug_league')->nullable()->comment('Название лиги на сайте');
            $table->boolean('actual')->comment('Актуальность');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_imports');
    }
};
