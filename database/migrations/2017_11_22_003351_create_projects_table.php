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
            // 1.
            $table->string('name');
            $table->string('holder');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('holder_links')->default('[]');
            $table->string('video')->nullable();
            $table->mediumText('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            // 2.
            $table->longText('description')->nullable();
            // 3.
            $table->longText('opportunity')->nullable();
            // 4.
            $table->longText('competition')->nullable();

            // 8.
            $table->integer('stage_id')->unsigned()->nullable();
            // 9.
            $table->longText('business_model')->nullable();

            // 10.
            $table->bigInteger('previous_capital')->nullable();
            $table->bigInteger('total_sales')->nullable();
            $table->bigInteger('round_size')->nullable();
            $table->bigInteger('minimal_needed')->nullable();

            $table->boolean('has_interested_investor')->nullable();
            $table->string('interested_investor_name')->nullable();

            $table->bigInteger('expected_sales_year_1')->nullable();
            $table->bigInteger('expected_sales_year_2')->nullable();
            $table->bigInteger('expected_sales_year_3')->nullable();

            $table->longText('rewards')->nullable();

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
