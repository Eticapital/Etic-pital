<?php

namespace App\Models\Traits;

use App\Extensions\MimeIconParser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

trait HasFile
{
    /**
     * Genera el response de descarga del documento
     *
     * @return Illuminate\Http\Response
     */
    public function download()
    {
        if (!file_exists($this->file_path)) {
            abort(404, "Documento no encotrado");
        }

        $this->download_count++;
        $this->downloaded_at = Carbon::now();
        $this->save();
        if ($this->is_embedeable) {
            return response()->file($this->file_path, $this->headers());
        }

        return response()->download($this->file_path, $this->name, $this->headers());
    }

    /**
     * Si se puede mostrar en la ventana
     *
     * @return boolean
     */
    public function getIsEmbedeableAttribute()
    {
        if ($this->mime == 'application/pdf') {
            return true;
        }

        return false;
    }

    /**
     * Recibe el archivo como arreglo
     * @return array
     */
    public function getFileAttribute()
    {
        return [
            'name' => $this->name,
            'file_name' => $this->file_name,
            'is_new'=> false,
        ];
    }

    /**
     * Recibe el archivo como un arreglo
     * @param array $file
     *
     */
    public function setFileAttribute($file)
    {
        if ($file && !$file['is_new']) {
            return;
        }

        $file_name = @$file['file_name'];
        $name = @$file['file'];

        if (!$name) {
            print_r($file);
            die();
        }

        if (!Storage::disk('local')->exists('tmp/' . $file_name)) {
            throw new \Exception("El archivo no existe");
        }

        $storage_path = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . 'tmp/';
        $uploadedFile = new File($storage_path . $file_name);

        $size = $uploadedFile->getSize();
        $mime = $uploadedFile->getMimeType();
        $extension = $uploadedFile->getExtension();

        Storage::disk('local')->move('tmp/' . $file_name, 'documents/' .  $file_name);

        $this->attributes['file_name'] = $file_name;
        $this->attributes['name'] = $name;
        $this->attributes['mime'] = $mime;
        $this->attributes['extension'] = $extension;
        $this->attributes['size'] = $size;
    }

    /**
     * Borra el archivo del discto
     *
     * @return
     */
    public function unlinkFile()
    {
        return Storage::disk('local')->delete('documents/' . $this->file_name);
    }
    /**
     * Devuelve el tamaño del archivo en Kb
     *
     * @return float
     */
    public function getSizeKbAttribute()
    {
        return $this->size / 1024;
    }

    /**
     * Devuelve el tamaño del archivo en Kb
     *
     * @return float
     */
    public function getSizeMbAttribute()
    {
        return $this->size_kb / 1024;
    }

    /**
     * El tamaño como texto amigable al usuario
     *
     * @return string
     */
    public function getSizeLabelAttribute()
    {
        $mb = $this->size_mb;

        // Es menor a un mega
        if ($mb < 1) {
            return  number_format($this->size_kb, 2) . 'KB';
        }

        return number_format($mb, 2) . 'MB';
    }

    /**
     * Devuelve la clase de icomoon segun el tipo de archivos permitidos
     *
     * @return strin
     * @return strin
     */
    public function getIconAttribute()
    {
        $icon_parser = new MimeIconParser();

        if ($this->extension) {
            return $icon_parser->getIconByExtension($this->extension);
        }

        if ($this->mime) {
            return $icon_parser->getIconByMime($this->mime);
        }

        return 'file-empty';
    }

    /**
     * Devuelve la ruta completa del archivo
     *
     * @return string
     */
    public function getFilePathAttribute()
    {
        $file = 'documents/' . $this->file_name;
        return Storage::disk('local')->getDriver()->getAdapter()->applyPathPrefix($file);
    }

    /**
     * Devuelve los headers para la descarga del archivo
     *
     * @return array
     */
    protected function headers()
    {
        $headers = [
            'Content-Length' => $this->size ? $this->size : filesize($this->file_path),
        ];

        if ($this->mime) {
            $headers['Content-Type'] = $this->mime;
        }

        return $headers;
    }


    /**
     * Copia el archivo y devuelve el nombre del nuevo archivo, es util
     * cuando se reutiliza el documento para por ejemplo crear ofertas y
     * asi si este se borrar la ofera sigue teninedo acceso
     *
     * @return string
     */
    public function copy()
    {
        $extension = pathinfo($this->file_name, PATHINFO_EXTENSION);
        // Mismo que uso laravel para nombrar imagenes
        $new_name = \Illuminate\Support\Str::random(40) . '.' . $extension;

        Storage::disk('local')->copy('documents/' . $this->file_name, 'documents/' . $new_name);

        return $new_name;
    }

    /**
     * Si el documento es un pdf
     *
     * @return boolean
     */
    public function getIsPdfAttribute()
    {
        return $this->extension == 'pdf';
    }
}