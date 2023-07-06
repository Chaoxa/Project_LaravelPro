<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;

class adminSliderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }
    function index()
    {
        $sliders = Slider::all();
        return view('admin.slider.list', compact('sliders'));
    }

    function add()
    {
        return view('admin.slider.add');
    }

    function handle_add(Request $request)
    {

        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'sort' => ['required', 'unique:sliders'],
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
                'name' => 'Tên slider',
                'sort' => 'Thứ tự',
                'file' => 'Slider',
            ]
        );

        // return $request->input();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                session(['file' => $fileName]);
                $destinationPath = 'public/uploads';
                $file->move($destinationPath, $fileName);
            } else {
                echo 'Ảnh không hợp lệ';
            }
        }

        $link = $request->input('link') ? $request->input('link') : '#';
        $slider = Slider::create([
            'name' => $request->input('name'),
            'link' => $link,
            'thumb_slider' => 'uploads/' . $fileName,
            'sort' => $request->input('sort'),
            'creator' => session('userID'),
            'status' => $request->input('status')
        ]);
        return redirect('admin/slider/add')->with('status', '▶Đã thêm slider thành công!');
    }

    function edit(Slider $slider)
    {
        $data = array(
            'id' => $slider->id,
            'name' => $slider->name,
            'url' => $slider->link,
            'link' => $slider->thumb_slider,
            'creator' => $slider->Users->name,
            'sort' => $slider->sort,
            'status' => $slider->status,
            'created_at' => $slider->created_at,
            'updated_at' => $slider->updated_at,
        );
        echo json_encode($data);
    }

    function update(Slider $slider, Request $request)
    {

        // return dd($request->all());
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'sort' => ['required', 'unique:sliders,sort,' . $slider->id],
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
                'name' => 'Tên slider',
                'sort' => 'Thứ tự',
                'file' => 'Slider',
            ]
        );

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                session(['file' => $fileName]);
                $destinationPath = 'public/uploads';
                $file->move($destinationPath, $fileName);

                $slider->update([
                    'name' => $request->input('name'),
                    'link' => $request->input('link'),
                    'thumb_slider' => 'uploads/' . $fileName,
                    'sort' => $request->input('sort'),
                    'status' => $request->input('status')
                ]);
                return redirect('admin/slider/list')->with('status', '▶Cập nhật thành công!');
            } else {
                echo 'Ảnh không hợp lệ';
            }
        }

        $slider->update([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
            'sort' => $request->input('sort'),
            'status' => $request->input('status')
        ]);

        return redirect('admin/slider/list')->with('status', '▶Cập nhật thành công!');
    }

    function delete(Slider $slider)
    {
        $slider->delete();
        return redirect('admin/slider/list')->with('status', '▶Đã xóa slider!');
    }
}
