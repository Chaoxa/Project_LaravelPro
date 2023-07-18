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
            Cập nhật sản phẩm
        </div>
        <div class="card-body">
            {!! Form::open(['route' => ['product.update', $product->id],'method' => 'POST','id' =>'main-form' ,'files'
            => true]) !!}
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        {!! Form::label('name', 'Tên sản phẩm(*)',['class' => 'font-weight-bold']) !!}
                        {!! Form::text('name', $product->name, ['class' => 'form-control' , 'id' => 'name']) !!}
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug"> Slug(*) <small class="text-success"><b class="autofill-trigger">[Tự động
                                    điền]</b></small></label>
                        {!! Form::text('slug', $product->slug, ['class' => 'form-control' , 'id' => 'slug']) !!}
                        @error('slug')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('old_price', 'Giá(*)',['class' => 'font-weight-bold']) !!}
                                {!! Form::text('old_price', $product->old_price, ['class' => 'form-control' , 'id' =>
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
                                {!! Form::text('discount', $product->discount, ['class' => 'form-control' , 'id' =>
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
                                {!! Form::number('amount', $product->amount , ['class' => 'form-control' , 'id' =>
                                'amount','min'
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
                                {!! Form::text('new_price', $product->new_price, ['class' => 'form-control' , 'id' =>
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
                            {!! Form::checkbox('color[]', $color->id, in_array($color->id,
                            $product->colors->pluck('id')->toArray()), ['id' => $color->id]) !!}
                            <label for="{{$color->id}}" class="box-color my-0"
                                style="background:{{$color->code}}">{{$color->name}}</label>
                        </div>
                        @endforeach

                    </div>
                    <div class="row mt-4">
                        {!! Form::label('configs', 'Chọn cấu hình',['class' => 'font-weight-bold']) !!}
                    </div>
                    <div class="row">
                        @foreach ($configs as $config)
                        <div class="form-group mr-4 d-flex">
                            {!! Form::checkbox('config[]', $config->id,in_array($config->id,
                            $product->configs->pluck('id')->toArray()), ['id' => 'config'.$config->id,
                            'class' =>
                            'priceCheckbox']) !!}
                            {!! Form::label('config'.$config->id,$config->memory.'GB', ['class' => 'box-config my-0
                            d-flex align-items-center', 'style' => 'height: 38px']) !!}
                            {!! Form::text('priceInput[]', $product->configs->where('id',
                            $config->id)->pluck('pivot.price')->first(), ['id' =>
                            'priceInput'.$config->id, 'class' => 'form-control', 'placeholder' => 'Giá sản phẩm']) !!}
                        </div>
                        @endforeach

                    </div>
                    <div class="row mt-5">
                        <input type="checkbox" id="featured_products" {{$product->status=1?'checked':''}}
                        name="featured_products">
                        <label for="featured_products" class="m-0"><b>Hiện ở danh mục sản phẩm nổi
                                bật</b></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="formFile" class="form-label"><b>Ảnh đại diện SP (1 ảnh)</b></label>
                    <input type="file" name="file" id="file_upload" onchange="chooseFile(this)">
                    <img src="{{asset($product->thumb_main)}}" alt="" id="image" class="img-rounded my-2" width="160"
                        height="160">
                    @error('file')
                    <small class="text-danger d-block">{{$message}}</small>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="formFile" class="form-label"><b>Ảnh chi tiết SP (1-6 ảnh)</b></label>
                    <input type="file" name="files[]" id="file-uploads" class="" multiple>
                    <br>
                    <div class="col-md-11 p-0 my-1">
                        <div id="images">
                            @empty(!$thumb_detail)
                            @foreach ($thumb_detail as $thumb)
                            <span><img src="{{asset($thumb)}}" class="img m-1 img-rounded" width="80"
                                    height="80"></span>
                            @endforeach
                            @endempty

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        {!! Form::label('des_quick', 'Mô tả nhanh',['class' => 'font-weight-bold']) !!}
                        {!! Form::textarea('des_quick', $product->desc_quick, ['class' => 'form-control edit' , 'id' =>
                        'textarea','rows' => '8']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        {!! Form::label('des_detail', 'Mô tả chi tiết sản phẩm',['class' => 'font-weight-bold']) !!}
                        {!! Form::textarea('des_detail', $product->desc_detail, ['class' => 'form-control edit' , 'id'
                        =>
                        'textarea','rows' => '15']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::select('cat_id', collect($categoryOptions)->mapWithKeys(function ($value) {
                return [$value['id'] => str_repeat('➻❥ ',$value['lever']).$value['name']];
                }), $product->cat_id, ['class' => 'form-control' , 'id'
                =>
                'cat','placeholder' => 'Chọn danh mục']) !!}
                @error('cat_id')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                {{ Form::label('status', 'Trạng thái', ['class' => 'font-weight-bold']) }}
                <div class="form-check">
                    {{ Form::radio('status', 0, $status0, ['class' => 'form-check-input', 'id' =>
                    'exampleRadios1']) }}
                    {{ Form::label('exampleRadios1', 'Chờ duyệt', ['class' => 'form-check-label']) }}
                </div>
                <div class="form-check">
                    {{ Form::radio('status', 1, $status1, ['class' => 'form-check-input', 'id' =>
                    'exampleRadios2']) }}
                    {{ Form::label('exampleRadios2', 'Công khai', ['class' => 'form-check-label']) }}
                </div>
            </div>

            <button type="submit" class="btn btn-success mb-2">Cập nhật</button>
            {!! Form::close() !!}
        </div>
    </div>
    @endsection