<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\ChatEvent;
use App\Models\User;

class ChatController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }
    
    public function chat()
    {
        return view('chat');
    }

    
    public function send(Request $request)
    {
        $user = Auth::user();
        event(new ChatEvent($request->message, $user));
        $this->saveToSession($request);
    }

    public function saveToSession(Request $request) {
        session()->put('chat', $request->chat);
    }

    public function getOldMessage() {
        return session('chat');
    }

    public function deleteSession() {
        return session()->forget('chat');
    }

    // public function send()
    // {
    //     $message = "Hello";
    //     $user = User::find(Auth::id());
    //     event(new ChatEvent($message, $user));
    // }
}
