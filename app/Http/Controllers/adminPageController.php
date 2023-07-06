<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class adminPageController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
    }
    function index()
    {
        $pages = Page::all();
        return view('admin.page.list', compact('pages'));
    }
    function add()
    {
        return view('admin.page.add');
    }
    function handle_add(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:100', 'unique:pages'],
                'slug' => ['required', 'string', 'max:100', 'unique:pages'],
                'title' => ['required', 'string', 'max:500'],
                'content' => ['required', 'string'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => ':attribute đã tồn tại trong cơ sở dữ liệu!',
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Slug',
                'content' => 'Nội dung trang',
                'title' => 'Tiêu đề trang',
            ]
        );

        // return dd($request->input());
        Page::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'creator' => session('userID'),
            'status' => $request->input('status'),
        ]);

        toastr()->success('Thêm trang thành công!');
        return redirect()->route('admin.page.add');
    }

    function edit(Page $page)
    {
        return view('admin.page.edit', compact('page'));
    }

    function update(Page $page, Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:100', 'unique:pages,name,' . $page->id],
                'slug' => ['required', 'string', 'max:100', 'unique:pages,slug,' . $page->id],
                'title' => ['required', 'string', 'max:500'],
                'content' => ['required', 'string'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => ':attribute đã tồn tại trong cơ sở dữ liệu!',
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Slug',
                'content' => 'Nội dung trang',
                'title' => 'Tiêu đề trang',
            ]
        );

        $page->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'status' => $request->input('status'),
        ]);

        toastr()->success('Cập nhật thành công!');
        return redirect()->route('admin.page.edit', $page);
    }

    function delete(Page $page)
    {
        $page->delete();
        toastr()->success('Đã xóa trang!');
        return redirect()->route('admin.page.show');
    }
}
