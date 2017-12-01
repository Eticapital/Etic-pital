<?php

use App\Models\Reward;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardsTable extends Migration
{
    protected $default_rewards = [
        'Deuda simple',
        'Deuda convertible',
        'Participación',
        'Revenue share',
        'Mixto'
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
        });

        collect($this->default_rewards)->each(function ($sector) {
            Reward::forceCreate(['label' => $sector]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rewards');
    }
}
