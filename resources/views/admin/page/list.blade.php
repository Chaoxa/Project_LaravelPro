@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách trang</h5>
            <div class="form-search form-inline">
                <form action="#" class="d-flex">
                    <input type="" class="form-control form-search" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary ml-1">
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên trang</th>
                        <th scope="col">Slug</th>
                        <th scope="col" class="text-center">Người tạo</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($pages as $page)
                    <tr>
                        <td scope="row">{{++$i}}</td>
                        <td><a href="{{route('admin.page.edit',$page)}}" class="font-weight-bold">{{$page->name}}</a>
                        </td>
                        <td>{{$page->slug}}</td>
                        <td class="text-center"><small><b>{{$page->users->name}}</b></small>
                            <br>
                            <b class="btn-sm btn-primary text-center">{{$page->users->roles[0]['name']}}</b>
                        </td>
                        <td>{{$page->created_at}}</td>
                        <td>
                            <a href="{{route('admin.page.edit',$page)}}"
                                class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{route('admin.page.delete',$page)}}"
                                class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection