@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
    <div class="{{session('color')?session('color'):'alert-success'}} alert">
        <b>{{session('status')}}</b>
    </div>
    @endif
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh mục sản phẩm
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'product.cat.add']) }}
                    <div class="form-group">
                        {{ Form::label('name', 'Tên danh mục') }}
                        {{ Form::text('name', old('name'), ['class' => 'form-control']) }}
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{ Form::label('parent_category', 'Danh mục cha') }}
                        {{ Form::select('parent_category', collect($categoryOptions)->mapWithKeys(function ($value) {
                        return [$value['id'] => str_repeat('➻❥ ',$value['lever']).$value['name']];
                        }), '', ['class' => 'form-control', 'placeholder' => 'Chọn danh mục']) }}
                        @error('parent_category')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{ Form::label('status', 'Trạng thái') }}
                        <div class="form-check">
                            {{ Form::radio('status', 0, true, ['class' => 'form-check-input', 'id' =>
                            'exampleRadios1']) }}
                            {{ Form::label('exampleRadios1', 'Chờ duyệt', ['class' => 'form-check-label']) }}
                        </div>
                        <div class="form-check">
                            {{ Form::radio('status', 1, false, ['class' => 'form-check-input', 'id' =>
                            'exampleRadios2']) }}
                            {{ Form::label('exampleRadios2', 'Công khai', ['class' => 'form-check-label']) }}
                        </div>
                    </div>

                    {{ Form::submit('Thêm mới', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách danh mục
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Cập nhật gần nhất</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=0;
                            $resultIds = [];
                            @endphp
                            @foreach ($categoryOptions as $cat)

                            @if (!in_array($cat['id'], $resultIds))
                            <tr>
                                <th scope="row">{{++$i}}</th>
                                <td>{{str_repeat('➻❥ ',$cat->lever).$cat -> name}}</td>
                                @if ($cat -> status == 0)
                                <td><span class="text-badge badge badge-warning">Chờ duyệt</span></td>
                                @else
                                <td><span class="text-badge badge badge-success">Công khai</span></td>
                                @endif
                                <td>{{$cat -> created_at}}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#exampleModalCenter"
                                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="{{url('admin/product/cat/delete/'.$cat -> id)}}"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa admin này?')"
                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                            class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $resultIds[] = $cat['id']; ?>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Thông tin danh mục</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title" class="title">Tên danh mục (*)</label>
                    <input id="title" class="form-control" placeholder="Tên danh mục" name="title" type="text" value="">
                </div>
                <div class="form-group">
                    <label for="slug_modal" class="title">Slug (*)</label>
                    <input id="slug_modal" class="form-control" placeholder="Slug" name="slug" type="text" value="">
                </div>
                <div class="form-group">
                    <label class="title" for="">Danh mục</label>
                    <select class="form-control mr-1" name="cat" id="cat_modal">
                        <option value="0">---Là danh mục cha---</option>
                        <option style="background: #EEEEEE" value="18" selected="selected">Laptop
                        </option>
                        <option value="20" selected="selected">--Asus
                        </option>
                        <option value="22" selected="selected">--Acer
                        </option>
                        <option value="26">--MSI
                        </option>
                        <option value="27" selected="selected">--HP
                        </option>
                        <option value="38">--Lenovo
                        </option>
                        <option value="40">--Dell
                        </option>
                        <option style="background: #EEEEEE" value="19">Điện thoại
                        </option>
                        <option value="23">--Iphone
                        </option>
                        <option value="24">--SamSung
                        </option>
                        <option value="25">--OPPO
                        </option>
                        <option value="36">--Xiaomi
                        </option>
                        <option style="background: #EEEEEE" value="28">Máy tính bản
                        </option>
                        <option value="33">--Apple
                        </option>
                        <option value="34">--SamSung
                        </option>
                        <option style="background: #EEEEEE" value="29">Phụ kiện
                        </option>
                        <option value="35">--Đế tản nhiệt laptop
                        </option>
                        <option value="37">--Bàn phím
                        </option>
                        <option style="background: #EEEEEE" value="31">Tai nghe + Loa
                        </option>
                        <option style="background: #EEEEEE" value="39">Máy tinh bàn (PC)
                        </option>
                        <option style="background: #EEEEEE" value="46">Máy tính bàn
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="title" for="">Trạng thái (*)</label>
                    <div class="d-flex">
                        <div class="col-sm-4 form-check">
                            <input class="form-check-input" id="status-pending" name="status" type="radio"
                                value="pending">
                            <label for="status-pending" class="form-check-label">Chờ duyệt</label>
                        </div>
                        <div class="col-sm-4 form-check">
                            <input class="form-check-input" id="status-public" name="status" type="radio"
                                value="public">
                            <label for="status-public" class="form-check-label">Công khai</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="user_create" class="title">Người tạo</label>
                        <input id="user_create" class="form-control" placeholder="Người tạo" disabled="disabled"
                            name="user" type="text" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="create_at" class="title">Ngày tạo</label>
                        <input id="create_at" class="form-control" placeholder="Ngày tạo" disabled="disabled"
                            name="create_at" type="text" value="">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="update_at" class="title">Cập nhật gần nhất</label>
                        <input id="update_at" class="form-control" placeholder="Người tạo" disabled="disabled"
                            name="update_at" type="text" value="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-success">Cập nhật</button>
            </div>
        </div>
    </div>
</div>
@endsection