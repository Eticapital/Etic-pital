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
            $table->integer('owner_id')->unsigned()->nullable();
            // 1.
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('holder');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('holder_links')->nullable();
            $table->string('image')->nullable();
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
            // 5.
            // company_files
            // 6.
            $table->text('links')->nullable();
            // 7.
            // sectors
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

            $table->boolean('is_featured')->default(0);

            $table->timestamp('published_at');
            $table->timestamps();

            $table
                ->foreign('owner_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('stage_id')
                ->references('id')
                ->on('project_stages')
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
        Schema::dropIfExists('projects');
    }
}
