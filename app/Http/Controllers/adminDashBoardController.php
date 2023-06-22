<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class adminDashBoardController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }
    function dashboard(Request $request)
    {
        // $user = User::find(22);
        // return $user->hasPermission('user.view');

        return view('admin.dashboard');
    }
}
