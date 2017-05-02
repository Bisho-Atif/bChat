<?php

namespace App\Http\Controllers;

use \Auth;
use Illuminate\Http\Request;
use \App\User;

class ChatController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function private(User $user)
  {
    if($user->name == Auth::user()->name)   return redirect('/');
    return view('privateChat')->with('user', $user);
  }
}