<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;

class adminBannerController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'banner']);
            return $next($request);
        });
    }

    function index()
    {
        $banners = Banner::all();
        return view('admin.banner.list', compact('banners'));
    }

    function add()
    {
        return view('admin.banner.add');
    }

    function handle_add(Request $request)
    {

        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'sort' => ['required', 'unique:banners'],
                'file' => ['required', 'max:5242880', 'image', 'mimes:jpeg,jpg,png,gif'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => ':attribute đã tồn tại trong hệ thống!',
                'image' => ':attribute phải là một hình ảnh!',
                'mimes' => ':attribute phải có định dạng jpg, png, jpeg, gif',
            ],
            [
                'name' => 'Tên banner',
                'sort' => 'Thứ tự',
                'file' => 'Banner',
            ]
        );

        // return $request->input();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                $destinationPath = 'public/uploads';
                $file->move($destinationPath, $fileName);
            } else {
                echo 'Ảnh không hợp lệ';
            }
        }

        $link = $request->input('link') ? $request->input('link') : '#';
        $banner = Banner::create([
            'name' => $request->input('name'),
            'link' => $link,
            'thumb_banner' => 'uploads/' . $fileName,
            'sort' => $request->input('sort'),
            'creator' => session('userID'),
            'status' => $request->input('status')
        ]);
        return redirect('admin/banner/add')->with('status', '▶Thêm banner thành công!');
    }

    function edit(Banner $banner)
    {
        $data = array(
            'id' => $banner->id,
            'name' => $banner->name,
            'url' => $banner->link,
            'link' => $banner->thumb_banner,
            'creator' => $banner->Users->name,
            'sort' => $banner->sort,
            'status' => $banner->status,
            'created_at' => $banner->created_at,
            'updated_at' => $banner->updated_at,
        );
        echo json_encode($data);
    }

    function update(Banner $banner, Request $request)
    {

        // return dd($request->all());
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'sort' => ['required', 'unique:banners,sort,' . $banner->id],
                'file' => ['max:5242880', 'image', 'mimes:jpeg,jpg,png,gif'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => ':attribute đã tồn tại trong hệ thống!',
                'image' => ':attribute phải là một hình ảnh!',
                'mimes' => ':attribute phải có định dạng jpg, png, jpeg, gif',
            ],
            [
                'name' => 'Tên banner',
                'sort' => 'Thứ tự',
                'file' => 'Banner',
            ]
        );

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                session(['file' => $fileName]);
                $destinationPath = 'public/uploads';
                $file->move($destinationPath, $fileName);

                $banner->update([
                    'name' => $request->input('name'),
                    'link' => $request->input('link'),
                    'thumb_banner' => 'uploads/' . $fileName,
                    'sort' => $request->input('sort'),
                    'status' => $request->input('status')
                ]);
                return redirect('admin/banner/list')->with('status', '▶Cập nhật thành công!');
            } else {
                echo 'Ảnh không hợp lệ';
            }
        }

        $banner->update([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
            'sort' => $request->input('sort'),
            'status' => $request->input('status')
        ]);

        return redirect('admin/banner/list')->with('status', '▶Cập nhật thành công!');
    }

    function delete(Banner $banner)
    {
        $banner->delete();
        return redirect('admin/banner/list')->with('status', '▶Đã xóa Banner!');
    }
}
