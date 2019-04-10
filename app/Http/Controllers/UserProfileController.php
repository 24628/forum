<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\User;

class UserProfileController extends Controller
{
    public function index(User $user)
    {

        $feeds = $user->feeds;
        return view('profile.index',compact('feeds'));

    }
}
