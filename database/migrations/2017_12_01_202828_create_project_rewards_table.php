<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_reward', function (Blueprint $table) {
            $table->integer('reward_id')->unsigned();
            $table->integer('project_id')->unsigned();

            $table
                ->foreign('reward_id')
                ->references('id')
                ->on('rewards')
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
        Schema::dropIfExists('project_reward');
    }
}
