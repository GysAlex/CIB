<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DownloadController extends Controller
{
    public function show(Media $media)
    {
        // On retourne simplement l'objet Responsable
        return  $media;
    }
}
