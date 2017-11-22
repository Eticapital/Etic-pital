<?php

use App\Models\ProjectStage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectStagesTable extends Migration
{
    protected $default_stages = [
        [
            'label' => 'Inicial',
            'description' => 'Menos de un año trabajando y requieres máximo $100,000 en capital'
        ],
        [
            'label' => 'Validación',
            'description' => 'Menos de dos años, algunas ventas y buscas menos de $200,000 en capital'
        ],
        [
            'label' => 'Crecimiento',
            'description' => 'Más de dos años, ventas recurrentes y buscas más de $200,000 en capital'
        ]
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_stages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('description');
        });

        collect($this->default_stages)->map(function ($stage) {
            ProjectStage::forceCreate($stage);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_stages');
    }
}
