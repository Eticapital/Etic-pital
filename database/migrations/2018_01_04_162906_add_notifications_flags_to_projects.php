<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotificationsFlagsToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('notification_project_approved_sended')->default(0);
            $table->boolean('notification_project_rejected_sended')->default(0);
            $table->boolean('notification_project_finished_sended')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('notification_project_approved_sended');
            $table->dropColumn('notification_project_rejected_sended');
            $table->dropColumn('notification_project_finished_sended');
        });
    }
}
