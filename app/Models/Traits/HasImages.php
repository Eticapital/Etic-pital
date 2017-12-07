<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait HasImages
{
    /**
     * Revisa si el atributo es una imagen y lo manda a la función adecuada
     *
     * @param  $key
     * @return mixed
     */
    public function getImageAttribute($key)
    {
        foreach (self::$images as $name => $image) {
            if (starts_with($key, $name . '_')) {
                list(, $size) = explode('_', $key);
                if (intval($size)) {
                    if (ends_with($key, '_url')) {
                        return $this->getImageUrl($name, $image, (int) $size);
                    } else {
                        return $this->getImageName($name, $image, (int) $size);
                    }
                }
            }

            if ($key == $name.'_url') {
                return $this->getImageUrl($name, $image);
            }
        }

        return null;
    }

    /**
     * Filtra el atributo para ver si es una imagen
     *
     * @param  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        $result = $this->getImageAttribute($key);
        if ($result !== null) {
            return $result;
        }

        return parent::getAttribute($key);
    }

    /**
     * Filtra el atributo para ver si es una imagen
     *
     * @param  $key
     * @return mixed
     */
    protected function mutateAttribute($key, $value)
    {
        $result = $this->getImageAttribute($key);
        if ($result !== null) {
            return $result;
        }

        return parent::mutateAttribute($key, $value);
    }

    /**
     * Devuelve la URL de la imágen según el tamaño
     *
     * @param  string $name
     * @param  array $image
     * @param  string $size
     * @return string
     */
    public function getImageUrl($name, $image, $size = null)
    {
        if (!$this->{$name}) {
            if (@$image['default_name'] && @$image['default_path']) {
                $ext = pathinfo($image['default_name'], PATHINFO_EXTENSION);
                $name = pathinfo($image['default_name'], PATHINFO_FILENAME);
                $default_name = $name . ($size ? '@' . $size : '') . '.' . $ext;
                $default_image = asset($image['default_path'] . $default_name);
                return $default_image;
                // return 'https://www.gravatar.com/avatar/' . md5($this->email)
                //     . '?s=' . $size
                //     . '&d=' . urlencode($default_image);
            } else {
                return null;
            }
        }

        if ($size) {
            return Storage::disk('public')->url($image['path'] . $this->getImageName($name, $image, $size));
        }

        return Storage::disk('public')->url($image['path'] . $this->getImageName($name, $image, $size));
    }

    /**
     * Devuelve el nombre de la imágen según el tamaño
     *
     * @param  string $name
     * @param  array $image
     * @param  string $size
     * @return string
     */
    public function getImageName($name, $image, $size = null)
    {
        if (!$this->{$name}) {
            return null;
        }

        $ext = pathinfo($this->{$name}, PATHINFO_EXTENSION);
        $name = pathinfo($this->{$name}, PATHINFO_FILENAME);
        return $name . ($size ? '@' . $size : '') . '.' . $ext;
    }

    /**
     * Elimina todas las imagenes relacionadas al atributo
     *
     * @param  string $name
     * @return void
     */
    public function cleanImage($name)
    {
        if (!$this->{$name}) {
            return false;
        }

        $appends = collect(self::$images[$name]['sizes'])->map(function ($size) use ($name) {
            Storage::disk('public')->delete(self::$images[$name]['path'] . $this->{$name . '_' . $size});
        });

        Storage::disk('public')->delete(self::$images[$name]['path'] . $this->{$name});

        $this->{$name} = null;
        $this->save();
    }

    /**
     * Si el atributo es una imágen procesa la imagen cuando está sea un archivo
     *
     * @param string $key
     * @param mixed $value
     *
     */
    public function setAttribute($key, $value)
    {
        if (collect(self::$images)->has($key)) {
            $this->setImage($key, $value);
            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Guarda un nuevo avatar en el disco
     *
     * @param string $name
     * @param mixed $value
     */
    public function setImage($name, $value = null)
    {
        if ($value === null) {
            $this->attributes[$name] = null;
            return false;
        }

        if (is_string($value)) {
            $this->attributes[$name] = $value;
            return false;
        }

        if ($value instanceof \Symfony\Component\HttpFoundation\File\File) {
            $value = \Intervention\Image\Facades\Image::make($value);
        }

        if ($value instanceof \Intervention\Image\Image) {
            $image = $value;

            $slug = md5($image->stream());
            $image_name = $slug . '.jpg';
            Storage::disk('public')->put(self::$images[$name]['path'] . $image_name, $image->stream());

            collect(self::$images[$name]['sizes'])->each(function ($size) use ($image, $slug, $name) {
                if (!str_contains($size, ':')) {
                    $size = $size . ':' . $size;
                }
                list($width, $height) = explode(':', $size);
                $image = $image->fit($width, $width, function ($constraint) {
                    $constraint->upsize();
                });

                $image_name = $slug . '@' . $width . '.jpg';
                Storage::disk('public')->put(self::$images[$name]['path'] . $image_name, $image->stream());
            });

            $this->attributes[$name] = $image_name;
        }
    }
}
