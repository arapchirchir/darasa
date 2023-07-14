<?php

namespace App\Http\Controllers;

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
        // Defining user roles for redirections
        $role = Auth::user()->user_type;
        $checkrole = explode(',', $role);

        if (in_array('teacher', $checkrole)) {
            return redirect('/teacher');
        } elseif (in_array('student', $checkrole)) {
            return redirect('/student');
        } else {
            return redirect('login');
        }
    }
}
