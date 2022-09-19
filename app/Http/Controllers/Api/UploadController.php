<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;

class UploadController extends Controller
{
    public function upload(UploadRequest $request)
    {
        /*$file = $request->file('uploadFile');
        $path = $request->uploadFile->path();
        $extension = $request->uploadFile->extension();
        $fileNameWithExtension = $file->getClientOriginalName();
        $fileNameWithExtension = $request->userId . '-' . time() .'.'. $extension;*/

        $path = $request->uploadFile->store('uploads/images');

        return response()->json(['uploadFileMessage' => "image uploaded successfully!"]);


    }
}
