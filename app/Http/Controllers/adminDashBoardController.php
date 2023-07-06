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
        return view('admin.dashboard');
    }
}
