<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;

class adminAuthController extends Controller
{

    function check_login($username, $password)
    {
        $user = User::where('username', $username)->first();
        if ($user && Hash::check($password, $user->password)) {
            return $user->id;
        }
        return false;
    }


    public function login()
    {
        // return dd($users = User::all()->toArray());
        return view('admin.auth.login');
    }

    public function logout()
    {
        session()->forget(['is_login', 'username', 'userID']);
        return redirect('admin/dashboard');
    }

    function handle(Request $request)
    {
        // dd($request->input());
        $request->validate(
            [
                'username' => ['required', 'string', 'min:6'],
                'password' => ['required', 'string', 'min:6'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'min' => ':attribute có độ dài ít nhất :min ký tự!',
            ],
            [
                'username' => 'Tên người dùng',
                'password' => 'Mật khẩu'
            ]
        );

        $username = $request->input('username');
        $password = $request->input('password');

        if ($userID = $this->check_login($username, $password)) {
            $userData = [
                'is_login' => true,
                'username' => $request->input('username'),
                'userID' => $userID
            ];

            if ($request->input('remember_me')) {
                $response = new Response();
                $response->cookie('is_login', true, 60);
                $response->cookie('user_login', $username, 60);
            }

            session()->put($userData);

            return redirect('admin/dashboard');
        }
        return redirect()->back()->withErrors(new MessageBag(['password' => 'Tài khoản hoặc mật khẩu không chính xác!']));
    }
}
