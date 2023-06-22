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
                    Thêm cấu hình
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'product.config.add', 'method' => 'post']) }}
                    <div class="form-group">
                        {!! Form::label('name', 'Tên cấu hình') !!}
                        {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{ Form::label('storage', 'Khả năng lưu trữ') }}
                        {!! Form::text('storage', old('storage'), ['class' => 'form-control', 'id' => 'storage']) !!}
                        @error('storage')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{ Form::label('price', 'Giá tiền') }}
                        {!! Form::text('price', old('price'), ['class' => 'form-control', 'id' => 'price']) !!}
                        @error('price')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="title" for="">Trạng thái (*)</label>
                        <div class="form-check">
                            {!! Form::radio('status', '0', true, ['class' => 'form-check-input', 'id' =>
                            'exampleRadios1']) !!}
                            {!! Form::label('exampleRadios1', 'Chờ duyệt', ['class' => 'form-check-label']) !!}
                        </div>
                        <div class="form-check">
                            {!! Form::radio('status', '1', false, ['class' => 'form-check-input', 'id' =>
                            'exampleRadios2']) !!}
                            {!! Form::label('exampleRadios2', 'Công khai', ['class' => 'form-check-label']) !!}
                        </div>
                    </div>

                    {{ Form::submit('Thêm mới', ['class' => 'btn btn-danger']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách cấu hình
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Dung lượng</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Cập nhật gần nhất</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 0;
                            @endphp
                            @foreach ($configs as $config)
                            <tr>
                                <th scope="row">{{++$i}}</th>
                                <td>{{Str::limit($config -> name,20)}}</td>
                                <td>{{$config -> memory ."GB"}}</td>
                                @if ($config -> status == 0)
                                <td><span class="text-badge badge badge-warning">Chờ duyệt</span></td>
                                @else
                                <td><span class="text-badge badge badge-success">Công khai</span></td>
                                @endif
                                <td>{{$config -> created_at}}</td>
                                <td>
                                    <a href="{{url('admin/product/config/edit/'.$config -> id)}}"
                                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="{{url('admin/product/config/delete/'.$config -> id)}}"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa admin này?')"
                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                            class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection