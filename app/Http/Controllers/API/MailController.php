<?php

namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
use App\Mail\CspeedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends BaseController
{
    public function sendEmail(Request $request) {

        $this->validate($request,[
            'message' => 'required',]);

        $details=  [
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'message' => $request->message,
        ];

        Mail::to('cspeed@contact.com')->send(new CspeedMail($details));


        return $this->sendResponse("succée", "Votre mail à été envoyer avec succée");
      }
}
