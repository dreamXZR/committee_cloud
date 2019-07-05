<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->string('alias')->after('module_name');
            $table->text('detail')->after('introduction');
            $table->string('identifier')->nullable()->after('detail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->string('image')->after('module_name');
            $table->dropColumn('alias');
            $table->dropColumn('detail');
            $table->dropColumn('identifier');
        });
    }
}
