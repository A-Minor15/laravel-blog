<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function show() {
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.show')->with('user', $user);
    }
}
