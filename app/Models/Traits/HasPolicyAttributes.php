<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Gate;

trait HasPolicyAttributes
{
    /**
     * Revisa si el usuario logueado tiene permisos para ejecutar el permiso enviado
     *
     * @param  string $permission
     * @return boolean
     */
    private function getGateAttribute($permission)
    {
        // Debe de haber un usuario logueado para revisar estos permisos
        if (!auth()->user()) {
            return false;
        }

        return Gate::allows($permission, $this);
    }

    /**
     * Convierte el atributo recibido con prefijo can_ en el permiso buscado
     * y llama a la función que verifica los permisos
     *
     * @param  string $key
     * @return boolen
     */
    private function callGateAttribute($key)
    {
        if (starts_with($key, 'can_')) {
            $attribute = collect(explode('_', $key))->forget(0)->implode('.');
            return $this->getGateAttribute($attribute);
        }

        return null;
    }

    /**
     * Filtra el atributo que se quiere obtener si es una imagen
     * devuelve el nombre o la url de la misma según el caso
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        $result = $this->callGateAttribute($key);
        if ($result !== null) {
            return $result;
        }

        return parent::getAttribute($key);
    }

    /**
     * Llama a la función encargada de revisar los permisos cuando aplique
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function mutateAttribute($key, $value)
    {
        $result = $this->callGateAttribute($key);
        if ($result !== null) {
            return $result;
        }

        return parent::mutateAttribute($key, $value);
    }
}
