<?php

use App\Models\Sector;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectorsTable extends Migration
{
    protected $default_sectors = [
        'Biocombustibles',
        'Drones',
        'Maquinaria',
        'Tecnología Agrícola',
        'Biotecnología',
        'Hidroponia',
        'Irrigación',
        'Big Data',
        'Comida',
        'Logística',
        'Producción',
        'Almacenamiento',
        'Robótica',
        'Otro',
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
        });

        collect($this->default_sectors)->each(function ($sector) {
            Sector::forceCreate(['label' => $sector]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sectors');
    }
}
