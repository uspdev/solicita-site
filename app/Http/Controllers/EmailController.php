<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use Uspdev\Replicado\Pessoa;

class EmailController extends Controller
{
    public function emails(){
    
        $owners = Site::select('owner')->get()->toArray();
        $owners = array_unique(array_column($owners,'owner'));
        $owners_emails = [];
        foreach($owners as $codpes){
            $email = Pessoa::email($codpes);
            if(!empty($email))
                array_push($owners_emails,$email);
        }

        $admins = Site::select('numeros_usp')->get()->toArray();
        $admins = array_unique(array_column($admins,'numeros_usp'));
        $admins_emails = [];
        foreach($admins as $codpes){
            $email = Pessoa::email($codpes);
            if(!empty($email))
                array_push($admins_emails,$email);
        }

        return view('emails.export')->with([
            'owners_emails' => $owners_emails,
            'admins_emails' => $admins_emails
        ]);
    }
}
