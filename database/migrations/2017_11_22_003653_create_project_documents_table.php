<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->nullable()->unsigned();
            $table->enum('category', ['company', 'key', 'extra'])->default('company');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('file_name');
            $table->integer('size')->nullable();
            $table->string('mime')->nullable();
            $table->string('extension')->nullable();
            $table->integer('download_count')->default(0);
            $table->timestamp('downloaded_at')->nullable();
            $table->boolean('is_public')->default(0);

            $table->timestamps();

            $table->foreign('project_id')
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
        Schema::dropIfExists('project_documents');
    }
}
