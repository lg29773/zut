<?php

namespace App\Http\Controllers;

use Anchu\Ftp\Ftp;
use Illuminate\Http\Request;
use League\Flysystem\Config;

class ftpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $auth = \Illuminate\Support\Facades\Config::get('ftp.connections.key');
        $ftp = new Ftp($auth);
        $listing = $ftp->connect($auth);
        //return $ftp->getDirListingDetailed();
        return view('ftp')->with('directory', $ftp->getDirListingDetailed())->with('current', $ftp->currentDir());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $auth = \Illuminate\Support\Facades\Config::get('ftp.connections.key');
        $ftp = new Ftp($auth);
        $listing = $ftp->connect($auth);
        if ($request->type == 'create_dir') {
            $ftp->makeDir($request->dir);

        }
        if ($request->type == 'delete') {
            $dir = substr($request->dir, 1, (intval(strlen($request->dir)) - 2));
            var_dump($dir);
            var_dump($ftp->delete($dir));

        }
        if ($request->type == 'delete_dir') {
            $dir = substr($request->dir, 1, (intval(strlen($request->dir)) - 2));
            var_dump($ftp->removeDir($dir));

        }
        if ($request->type == 'upload') {

            if ($request->hasFile('fileinput')) {

                $dir =$request->catalog;
                $request->file('fileinput')->move(public_path().'/pliki',$request->file('fileinput')->getClientOriginalName());
              $ftp->uploadFile(public_path().'/pliki/'.$request->file('fileinput')->getClientOriginalName(),substr($dir, 1, (intval(strlen($dir))))."/".$request->file('fileinput')->getClientOriginalName());

                return view('ftp')->with('directory', $ftp->getDirListingDetailed(str_replace('_', '/', $request->catalog)))->with('current', str_replace('_', '/', $request->catalog));

            }


        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $auth = \Illuminate\Support\Facades\Config::get('ftp.connections.key');
        $ftp = new Ftp($auth);
        $listing = $ftp->connect($auth);
        //return $ftp->getDirListingDetailed();
        return view('ftp')->with('directory', $ftp->getDirListingDetailed(str_replace('_', '/', $id)))->with('current', str_replace('_', '/', $id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
