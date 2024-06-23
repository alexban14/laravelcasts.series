<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function show(User $user, string $filename)
    {
        $document = $user->documents()->firstWhere('filename', $filename);

        if (! request()->user()->isAdmin()) {
            abort(403);
        }

//        if ($document->extension == 'pdf') {
        return response(Storage::disk('s3')->get('/documents/' . $user->id . '/' . $filename))
            ->header('Content-Type', 'application/pdf');
//        }
    }
}
