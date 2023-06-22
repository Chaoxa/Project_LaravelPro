<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use Illuminate\Support\Facades\Auth;

class adminUserController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }
    //
    public function list(request $request)
    {
        if ($request->input('status') == 'active' && $request->input('status') != '' || $request->input('status') == '') {;
            $keyword = "";
            // dd($request->input());
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $users = User::where('name', 'LIKE', "%{$keyword}%")->paginate(10);
            $list_act = [
                'disable' => 'Vô hiệu hóa'
            ];
            $url_delete = 'admin/user/delete/';
            $url_btn_success = 'admin/user/edit/';
        } else {
            $keyword = "";
            // dd($request->input());
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $users = User::onlyTrashed()->where('name', 'LIKE', "%{$keyword}%")->paginate(10);
            $list_act = [
                'restore' => 'Kích hoạt',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $url_delete = 'admin/user/forcedelete/';
            $url_btn_success = 'admin/user/restore/';
        }
        $numUsersActive = User::count();
        $numSoftDelete = User::onlyTrashed()->count();

        return view('admin.user.list', compact('users', 'keyword', 'numUsersActive', 'numSoftDelete', 'list_act', 'url_delete', 'url_btn_success'));
    }

    public function add(Request $request)
    {
        $roles = Role::all();
        return view('admin.user.add', compact('roles'));
    }

    public function delete($id)
    {
        if (session('userID') != $id) {
            User::find($id)->delete();
            return redirect('admin/user/list')->with([
                'status' => 'Đã xóa tài khoản thành công!',
                'color' => 'alert-success'
            ]);
        } else {
            return redirect('admin/user/list')->with(['status' => 'Không thể xóa chính bạn!', 'color' => 'alert-warning']);
        }
    }
    public function forceDelete($id)
    {
        if (session('userID') != $id) {
            User::withTrashed()->find($id)->forceDelete();
            return redirect('admin/user/list')->with([
                'status' => 'Đã xóa tài khoản vĩnh viễn!',
                'color' => 'alert-success'
            ]);
        } else {
            return redirect('admin/user/list')->with(['status' => 'Không thể xóa chính bạn!', 'color' => 'alert-warning']);
        }
    }
    public function restore($id)
    {
        User::withTrashed()->find($id)->restore();
        return redirect('admin/user/list')->with([
            'status' => 'Tài khoản đã được kích hoạt!',
            'color' => 'alert-success'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'username' => ['required', 'string', 'min:8', 'max:50', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password_confirmation'  => ['required', 'string', 'min:8']
            ],
            [
                'required' => ':attribute không được để trống!',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài lớn nhất :max ký tự',
                'confirmed' => 'Mật khẩu xác nhận không đúng!',
                'unique' => ':attribute đã tồn tại trong cơ sở dữ liệu!',
            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'username' => 'Tài khoản',
                'password_confirmation' => 'Mật khẩu xác nhận'
            ]
        );

        $data = $request->input();
        // return $data;
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);
        $user->roles()->sync($request->input('roles', []));

        return redirect('admin/user/list')->with([
            'status' => 'Đã thêm tài khoản thành công!',
            'color' => 'alert-success'
        ]);
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            foreach ($list_check as $k => $v) {
                if (Auth::id() ==  $v) {
                    unset($list_check[$k]);
                }
            }
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'disable') {
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with([
                        'status' => 'Đã vô hiệu hóa thành công!',
                        'color' => 'alert-danger'
                    ]);
                } elseif ($act == 'restore') {
                    User::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect('admin/user/list')->with([
                        'status' => 'Đã khôi phục thành công!',
                        'color' => 'alert-success'
                    ]);
                } elseif ($act == 'forceDelete') {
                    User::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete($list_check);
                    return redirect('admin/user/list')->with('status', 'Tài khoản đã được xóa vĩnh viễn!');
                }
            } else {
                return redirect('admin/user/list')->with([
                    'status' => 'Bạn không thể vô hiệu hóa chính mình!',
                    'color' => 'alert-danger'
                ]);
            }
        } else {
            return redirect('admin/user/list')->with([
                'status' => 'Bạn cần chọn phần tử trước khi thực thi!',
                'color' => 'alert-danger'
            ]);
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('admin.user.update', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'min' => ':attribute có độ dài ít nhất :min ký tự!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
            ],
            [
                'name' => 'Tên người dùng',
            ]
        );
        $user = User::find($id);
        User::where('id', $id)->update([
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password'))
        ]);

        // return $user->hasPermission('post.add');

        $user->roles()->sync($request->input('roles', []));

        return redirect('admin/user/list')->with([
            'status' => 'Cập nhật thành công!',
            'color' => 'alert-success'
        ]);
    }
}
