<?php

namespace App\Models\Traits;

trait LazyAppends
{
    /**
     * Append attributes to query when building a query.
     *
     * @param  array|string  $attributes
     * @return $this
     */
    public function lazyAppend($attributes)
    {
        $attributes = collect(is_string($attributes) ? func_get_args() : $attributes);

        if (!$attributes->count()) {
            return $this;
        }

        $attributes->each(function ($attribute) {
            if (!in_array($attribute, $this->appendable)) {
                throw new \Exception("No está permitido agregar el atributo dinámico.");
            }
        });

        return parent::append($attributes->toArray());
    }
}
