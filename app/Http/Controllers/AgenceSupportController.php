<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Mail\SupportForms;
use Illuminate\Http\Request;
use App\Models\AgenceSupport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AgenceSupportController extends Controller
{
    public function index(){
        $contacts = Setting::getContact(['whatsapp_link']);
        return view('agence.support')->with(['contacts'=> $contacts]);
    }

    public function support(Request $request)
    {
        // Save ticket
        $user_id = Auth::user()->id;

        $mail = [
            'message' => $request->message,
            'from_name' => $request->name,
            'from_email' => $request->email,
            'subject' => $request->subject,
        ];

        // Send Email
        Mail::to("support@autodrive.ma")->queue(new SupportForms($mail));
        
        return redirect()->route('support')->with('status', 'message envoyé avec succès!');
    }
}
