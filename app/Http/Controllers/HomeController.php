<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::whereNotIn('id', [Auth::id()])->latest()->take(10)->get();
        $usersArray = $users->toArray();
        $lastSuggestionId = $users[count($usersArray) -1]['id'];
        $suggestionsCount = $users->count();
        $sentRequestsCount = Connection::where("sender", Auth::id())->where('status', 0)->count();
        $receivedRequestsCount = Connection::where("receiver", Auth::id())->where('status', 0)->count();
        $connectionsCount = Connection::where("sender", Auth::id())->where('status', 1)->count();
        return view('home', compact('users', 'lastSuggestionId', 'suggestionsCount', 'sentRequestsCount', 'receivedRequestsCount', 'connectionsCount'));
    }

    public function index1(){
        return view('homeOld');
    }
}
