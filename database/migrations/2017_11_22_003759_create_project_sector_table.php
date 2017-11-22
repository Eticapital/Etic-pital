<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectSectorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_sector', function (Blueprint $table) {
            $table->integer('sector_id')->unsigned();
            $table->integer('project_id')->unsigned();

            $table
                ->foreign('sector_id')
                ->references('id')
                ->on('sectors')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_sector');
    }
}
