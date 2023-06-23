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

                    {{ Form::submit('Thêm mới', ['class' => 'btn btn-success']) }}
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
                                <th scope="col">Giá</th>
                                <th scope="col">Trạng thái</th>
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
                                <td>{{number_format($config -> price,0,'.','.').'đ'}}</td>
                                @if ($config -> status == 0)
                                <td><span class="text-badge badge badge-warning">Chờ duyệt</span></td>
                                @else
                                <td><span class="text-badge badge badge-success">Công khai</span></td>
                                @endif
                                <td>
                                    <a data-toggle="modal" data-id="{{ $config->id }}" data-target="#exampleModalCenter"
                                        class="btn btn-success btn-edit btn-sm rounded-0 text-white" type="button"
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
<form method="post" id="id_update">
    @csrf
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Thông tin cấu hình</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Tên danh mục (*)', ['class' => 'title']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control','id' => 'name_update', 'placeholder' =>
                        'Tên cấu hình']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('storage', 'Khả năng lưu trữ (GB)', ['class' => 'title']) !!}
                        {!! Form::text('storage', null, ['class' => 'form-control','id' => 'storage_update',
                        'placeholder'
                        =>
                        'Giá']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('price', 'Giá tiền (*)', ['class' => 'title']) !!}
                        {!! Form::text('price', null, ['class' => 'form-control','id' => 'price_update', 'placeholder'
                        =>
                        'Giá']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('', 'Trạng thái (*)', ['class' => 'title']) !!}
                        <div class="d-flex">
                            <div class="col-sm-4 form-check">
                                {!! Form::radio('status', 0, '', ['id' => 'status-pending', 'class' =>
                                'form-check-input']) !!}
                                {!! Form::label('status-pending', 'Chờ duyệt', ['class' => 'form-check-label']) !!}
                            </div>
                            <div class="col-sm-4 form-check">
                                {!! Form::radio('status', 1, '', ['id' => 'status-public', 'class' =>
                                'form-check-input']) !!}
                                {!! Form::label('status-public', 'Công khai', ['class' => 'form-check-label']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            {!! Form::label('creator', 'Người tạo', ['class' => 'title']) !!}
                            {!! Form::text('creator', null, ['class' => 'form-control','id' => 'creator' ,'placeholder'
                            => 'Người tạo',
                            'disabled' => 'disabled']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            {!! Form::label('created_at', 'Ngày tạo', ['class' => 'title']) !!}
                            {!! Form::text('created_at', null, ['class' => 'form-control','id' => 'created_at',
                            'placeholder' => 'Ngày tạo',
                            'disabled' => 'disabled']) !!}
                        </div>
                        <div class="col-sm-6 form-group">
                            {!! Form::label('updated_at', 'Cập nhật gần nhất', ['class' => 'title']) !!}
                            {!! Form::text('updated_at', null, ['class' => 'form-control','id' => 'updated_at',
                            'placeholder' => 'Cập nhật gần
                            nhất', 'disabled' => 'disabled']) !!}
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                    <input type="submit" class="btn btn-success" value="Cập nhật">
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    function config_update(id) {
    var data = {
        id: id,
        _token: '{{ csrf_token() }}'
    };
    
    $.ajax({
        url: "config/edit/" + id,
        method: "POST",
        data: data,
        dataType: "json",
        success: function(data) {
            // alert('oke');
            console.log(data);
            $("#id_update").attr("action", "config/update/" + data.id);
            $("#name_update").val(data.name);
            $("#storage_update").val(data.storage);
            $("#price_update").val(data.price);
            
            if (data.status == 0) {
                $('#status-pending').prop('checked', true);
            } else if (data.status == 1) {
                $('#status-public').prop('checked', true);
            }
            
            $("#creator").val(data.creator);
            
            var createdAt = new Date(data.created_at);
            var formattedCreatedAt = createdAt.toLocaleString("en-US", { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' });
            
            var updatedAt = new Date(data.updated_at);
            var formattedUpdatedAt = updatedAt.toLocaleString("en-US", { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' });
            
            $("#created_at").val(formattedCreatedAt);
            $("#updated_at").val(formattedUpdatedAt);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        },
    });
}

$(document).ready(function() {
    $(".btn-edit").click(function() {
        var id = $(this).attr("data-id");
        config_update(id);
    });
});

</script>
@endsection