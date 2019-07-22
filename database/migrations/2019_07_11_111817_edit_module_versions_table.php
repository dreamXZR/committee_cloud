<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditModuleVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('module_versions', function (Blueprint $table) {
            $table->dropColumn('file_path');
            $table->string('upgrade_file_path')->after('frame_version');
            $table->string('complete_file_path')->after('upgrade_file_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('module_versions', function (Blueprint $table) {
            $table->string('file_path')->after('frame_version');
            $table->dropColumn('upgrade_file_path');
            $table->dropColumn('complete_file_path');
        });
    }
}
