<?php

namespace App\Http\Controllers;

use App\Models\ProjectDocument;
use Illuminate\Http\Request;

class ProjectDocumentController extends Controller
{
    /**
     * Descarga el archivo
     *
     * @return Response
     */
    public function download(ProjectDocument $document)
    {
        $this->authorize('download', $document);

        return $document->download();
    }
}
