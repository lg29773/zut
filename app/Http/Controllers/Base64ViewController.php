<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Base64ViewController extends Controller
{
    public function index(){

        $files = scandir('files');
        $files2 = scandir('files_enc');

        return view('showBase')->with('files' , $files)->with('files2' , $files2);
    }
}
