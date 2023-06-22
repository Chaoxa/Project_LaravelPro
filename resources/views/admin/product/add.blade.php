@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
    <div class="{{session('color')?session('color'):'alert-success'}} alert">
        <b>{{session('status')}}</b>
    </div>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'product.handle','method' => 'POST','id' =>'main-form']) !!}
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        {!! Form::label('name', 'Tên sản phẩm(*)',['class' => 'font-weight-bold']) !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control' , 'id' => 'name']) !!}
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('old_price', 'Giá(*)',['class' => 'font-weight-bold']) !!}
                                {!! Form::text('old_price', old('old_price'), ['class' => 'form-control' , 'id' =>
                                'old_price','placeholder' => 'VNĐ','onkeyup' =>
                                'count()'])
                                !!}
                                @error('old_price')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('discount', 'Giảm giá',['class' => 'font-weight-bold text-danger']) !!}
                                {!! Form::text('discount', old('discount'), ['class' => 'form-control' , 'id' =>
                                'discount','placeholder' => '%','onkeyup' =>
                                'count()']) !!}
                                @error('discount')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('amount', 'Số lượng(*)',['class' => 'font-weight-bold']) !!}
                                {!! Form::number('amount', '' , ['class' => 'form-control' , 'id' => 'amount','min'
                                => 0]) !!}
                                @error('amount')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('new_price', 'Thành tiền(*)',['class' => 'font-weight-bold
                                text-success']) !!}
                                {!! Form::text('new_price', old('new_price'), ['class' => 'form-control' , 'id' =>
                                'new_price']) !!}
                                @error('new_price')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        {!! Form::label('colors', 'Chọn màu',['class' => 'font-weight-bold']) !!}
                    </div>
                    <div class="row">
                        @foreach ($colors as $color)
                        <div class="form-group mr-4">
                            <input type="checkbox" name="color[]" id="{{$color->id}}">
                            <label for="{{$color->id}}" class="box-color my-0"
                                style="background:{{$color->code}}"></label>
                        </div>
                        @endforeach
                    </div>
                    <div class="row mt-4">
                        {!! Form::label('configs', 'Chọn cấu hình',['class' => 'font-weight-bold']) !!}
                    </div>
                    <div class="row">
                        @foreach ($configs as $config)
                        <div class="form-group mr-4">
                            <input type="checkbox" name="config[]" id="{{'config'.$config->id}}">
                            <label for="{{'config'.$config->id}}" class="box-config my-0">{{$config->memory}}GB</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <b>Ảnh đại diện SP (1 ảnh)</b>
                    <div class="form-group">
                        <div id="myDropzone1" class="dropzone">
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-4">
                    <b>Ảnh chi tiết SP (1-6 ảnh)</b>
                    <div class="form-group">
                        <div id="myDropzone2" class="dropzone">
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('des_quick', 'Mô tả nhanh',['class' => 'font-weight-bold']) !!}
                        {!! Form::textarea('des_quick', old('des_quick'), ['class' => 'form-control' , 'id' =>
                        'amount','rows' => '5']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('des_detail', 'Mô tả chi tiết sản phẩm',['class' => 'font-weight-bold']) !!}
                {!! Form::textarea('des_detail', old('des_detail'), ['class' => 'form-control' , 'id' =>
                'amount','rows' => '10']) !!}
            </div>
            <div class="form-group">
                {!! Form::select('cat', [1=>'Danh mục 1',2=>'Danh mục 2'], '', ['class' => 'form-control' , 'id' =>
                'cat']) !!}
                @error('cat')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                {{ Form::label('status', 'Trạng thái',['class' => 'font-weight-bold']) }}
                <div class="form-check">
                    {{ Form::radio('status', 'option1', true, ['class' => 'form-check-input', 'id' => 'exampleRadios1'])
                    }}
                    {{ Form::label('exampleRadios1', 'Chờ duyệt', ['class' => 'form-check-label']) }}
                </div>
                <div class="form-check">
                    {{ Form::radio('status', 'option2', false, ['class' => 'form-check-input', 'id' =>
                    'exampleRadios2']) }}
                    {{ Form::label('exampleRadios2', 'Công khai', ['class' => 'form-check-label']) }}
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Thêm mới</button>
            {!! Form::close() !!}
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;
var myDropzone = new Dropzone("#myDropzone1", {
    url: "{{route('dropzonejs.add')}}", // Đường dẫn đến server để xử lý tải lên ảnh
    acceptedFiles: "image/*", // Chỉ chấp nhận tệp tin ảnh
    maxFilesize: 2, // Giới hạn dung lượng tệp tin (đơn vị: MB)
    addRemoveLinks: true, // Hiển thị nút xóa để loại bỏ ảnh đã tải lên
    dictRemoveFile: "Xóa", // Chuỗi hiển thị trên nút xóa
    success: function(file, response) {
        // Xử lý khi tải lên thành công
        // response chứa thông tin về tệp đã tải lên từ phía server (nếu cần)
        console.log(response);
    }

        // Gọi Ajax để xử lý tệp đã tải lên
        
});


    </script>


    <script>
        function count() {
                                        var price = document.getElementById('old_price').value;
                                        var discount = document.getElementById('discount').value;
                                        var new_price1 = price * discount / 100;
                                        var new_price = price - new_price1;
                                        if (discount > 100) {
                                            alert('Không thể giảm giá vượt quá 100% giá trị sản phẩm')
                                        } else {
                                            document.getElementById('new_price').value = new_price
                                        }
                                    }
    </script>
    @endsection