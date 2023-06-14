<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');;
            $table->string('name')->comment('Наименование');
            $table->string('url')->nullable()->comment('URL адрес');
            $table->boolean('actual')->default(true)->comment('Актуальность');
            $table->text('icon')->nullable()->comment('Иконка');
            $table->integer('sort',false)->default(10)->comment('Сортировка');
            $table->bigInteger('menu_id',false,true)->nullable()->comment('Родительский пункт');
            $table->foreign('menu_id')->references('id')->on('menus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign('menus_menu_id_foreign');
        });
        Schema::dropIfExists('menus');
    }
}
