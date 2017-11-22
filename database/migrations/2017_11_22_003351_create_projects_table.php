<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('holder');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('video')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->longText('description')->nullable();
            $table->longText('opportunity')->nullable();
            $table->longText('competition')->nullable();
            $table->integer('stage_id')->unsigned()->nullable();

            $table->longText('business_model')->nullable();

            $table->bigInteger('previous_capital')->nullable();
            $table->bigInteger('total_sales')->nullable();
            $table->bigInteger('round_size')->nullable();
            $table->bigInteger('minimal_needed')->nullable();

            $table->boolean('has_interested_investor')->nullable();

            $table->bigInteger('expected_sales_year_1')->nullable();
            $table->bigInteger('expected_sales_year_2')->nullable();
            $table->bigInteger('expected_sales_year_3')->nullable();

            $table->text('reward')->default('[]');

            $table
                ->foreign('stage_id')
                ->references('id')
                ->on('project_stages')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('projects');
    }
}
