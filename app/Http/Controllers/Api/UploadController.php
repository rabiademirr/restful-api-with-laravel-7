<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;

class UploadController extends Controller
{
    public function upload(UploadRequest $request)
    {
        $file = $request->file('uploadFile');
        $fileNameWithExtension = $file->getClientOriginalName();

        if ($file->move(public_path('/'), $fileNameWithExtension)) {
            $fileUrl = url('/' . $fileNameWithExtension);
            return response()->json(['url' => $fileUrl]);
        }

    }
}
