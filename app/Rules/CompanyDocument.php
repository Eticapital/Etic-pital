<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CompanyDocument implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$value) {
            return true;
        }

        if (@$value['tmp_name']) {
            return Storage::disk('local')->exists('tmp/' . $value['tmp_name']);
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No se encontró el archivo, por favor vuelve a cargarlo o contacta al administrador';
    }
}
