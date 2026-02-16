<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    public function show($filename)
    {
        $path = 'assets/private/' . $filename;

        if(!Storage::exists($path)){
            abort(404);
        }

        // Fix MIME type for JavaScript files
        $response = Storage::response($path);
        
        if (str_ends_with($filename, '.js')) {
            $response->headers->set('Content-Type', 'application/javascript');
        }

        return $response;
    }
}
