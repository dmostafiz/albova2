<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class publicProfileController extends Controller
{
    function index($id)
    {
        $user = User::where('id', $id)->first();

        if(!$user) abort(404);

        $data['user'] = $user;

        return view('frontend.user.profile', $data);
    }
}
