<?php

namespace App\Http\Controllers\CRUD;

use Carbon\Carbon;
use Faker\Provider\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Base64Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->hasFile('fileinput'))
        {
            //var_dump($request->all());
            if($request->file('fileinput')->clientExtension() == "txt"){

               if($request->type == "code"){
                   $code = $this->code(\Illuminate\Support\Facades\File::get($request->file('fileinput')));
                   \Illuminate\Support\Facades\File::put("public/files/".Carbon::now()."_coded.txt",$code);
               }else{
                   $code = base64_decode(\Illuminate\Support\Facades\File::get($request->file('fileinput')));
                   \Illuminate\Support\Facades\File::put("public/files_enc/".Carbon::now()."_encoded.txt",$code);
               }


            }

        }

        return redirect('/base64');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


     private function code($string) {
        $binval = $this->convert($string);
        $final = "";
        $start = 0;
        while ($start < strlen($binval)) {
            if (strlen(substr($binval,$start)) < 6)
                $binval .= str_repeat("0",6-strlen(substr($binval,$start)));
            $tmp = bindec(substr($binval,$start,6));
            if ($tmp < 26)
                $final .= chr($tmp+65);
            elseif ($tmp > 25 && $tmp < 52)
                $final .= chr($tmp+71);
            elseif ($tmp == 62)
                $final .= "+";
            elseif ($tmp == 63)
                $final .= "/";
            elseif (!$tmp)
                $final .= "A";
            else
                $final .= chr($tmp-4);
            $start += 6;
        }
        if (strlen($final)%4>0)
            $final .= str_repeat("=",4-strlen($final)%4);
        return $final;
    }

    private function convert($string) {
        if (strlen($string)<=0) return;
        $tmp = decbin(ord($string[0]));
        $tmp = str_repeat("0",8-strlen($tmp)).$tmp;
        return $tmp.$this->convert(substr($string,1));
    }
}
