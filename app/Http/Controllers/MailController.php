<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mail;

class MailController extends Controller
{
    public function index()
    {
        return view('mails.index');
    }
    
    public function edit(Mail $mail)
    {
        return view('mails.edit', ["mail" => $mail]);
    }
    
    public function create()
    {
        return view('mails.edit', ["mail" => null]);
    }
}
