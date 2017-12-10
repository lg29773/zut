<?php

namespace App\Http\Controllers;

use App\Mail\simple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use PhpImap\Mailbox;

class mailController extends Controller
{


    public function showEmail(){
        $mailbox = new Mailbox('{'.env('MAIL_HOST').'}'.'INBOX', env('MAIL_USERNAME'), env('MAIL_PASSWORD'), __DIR__,'UTF-8');
        $mailbox_id = $mailbox->searchMailbox('ALL');
        $mail = $mailbox->getMail( $mailbox_id[sizeof(  $mailbox_id ) - 1]);

        return view('email')->with('mailbox', $mail);

    }

    public function sendEmail(){

       Mail::to( Input::get('email'))->send(new simple( Input::get('tresc'), Input::get('email'), Input::get('temat')));
       return Redirect::to('/email');
    }
}
