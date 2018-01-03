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

    /**
     * Convert the model's attributes to an array.
     *
     * @return array
     */
    public function attributesToArray()
    {
        // If an attribute is a date, we will cast it to a string after converting it
        // to a DateTime / Carbon instance. This is so we will get some consistent
        // formatting while accessing attributes vs. arraying / JSONing a model.
        $attributes = $this->addDateAttributesToArray(
            $attributes = $this->getArrayableAttributes()
        );

        $attributes = $this->addMutatedAttributesToArray(
            $attributes, $mutatedAttributes = $this->getMutatedAttributes()
        );

        // Next we will handle any casts that have been setup for this model and cast
        // the values to their appropriate type. If the attribute has a mutator we
        // will not perform the cast on those attributes to avoid any confusion.
        $attributes = $this->addCastAttributesToArray(
            $attributes, $mutatedAttributes
        );

        // Here we will grab all of the appended, calculated attributes to this model
        // as these attributes are not really in the attributes array, but are run
        // when we need to array or JSON the model for convenience to the coder.
        foreach ($this->getArrayableAppends() as $key) {
            $attributes[$key] = $this->mutateAttributeForArray($key, null);
        }

        // Nueva función que agrega sub-elementos dinámicamente, en la practica es
        // util para en un solo query agregar más elementos
        foreach ($this->getSubArrayableAppends() as $key) {
            list($model, $key) = explode('.', $key);
            if ($this->{$model}) {
                $attributes[$model][$key] = $this->{$model}->mutateAttributeForArray($key, null);
            }
        }

        return $attributes;
    }

    /**
     * Get all of the appendable values that are arrayable.
     *
     * @return array
     */
    protected function getArrayableAppends()
    {
        if (! count($this->appends)) {
            return [];
        }

        $appends = collect($this->appends)->filter(function ($append) {
            return !str_contains($append, '.');
        })->toArray();

        return $this->getArrayableItems(
            array_combine($appends, $appends)
        );
    }

    /**
     * Get all of the sub appendable values that are arrayable.
     *
     * @return array
     */
    protected function getSubArrayableAppends()
    {
        if (! count($this->appends)) {
            return [];
        }

        $appends = collect($this->appends)->filter(function ($append) {
            return str_contains($append, '.');
        })->toArray();

        return $this->getArrayableItems(
            array_combine($appends, $appends)
        );
    }
}
