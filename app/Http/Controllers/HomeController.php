<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>'upload-form']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function uploadForm()
    {
        return view('upload-form');
    }

    public function download($fileName)
    {
        //return Storage::disk('s3')->download(public_path("uploads/$fileName"));
        return response()->download(public_path("uploads/$fileName"));
    }
}

