<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_versions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('module_id');
            $table->string('version');
            $table->text('introduction');
            $table->string('file_path');
            $table->boolean('is_show');
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
        Schema::dropIfExists('module_versions');
    }
}
