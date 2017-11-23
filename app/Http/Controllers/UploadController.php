<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Carga la imagen en una carpeta temporal
     *
     * @return Response
     */
    public function uploadToTempFolder(Request $request)
    {
        $this->validate($request, [
            'file' => 'required'
        ]);

        $relative_url = request()->file->store('tmp', 'local');

        return [
            'type' => 'success',
            'name' => basename($relative_url)
        ];
    }
}
