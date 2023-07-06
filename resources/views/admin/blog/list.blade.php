@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách sản phẩm</h5>
            <div class="form-search form-inline">
                <form action="#" class="d-flex">
                    <input type="" class="form-control form-search" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="" class="text-primary">Trạng thái 1<span class="text-muted">(10)</span></a>
                <a href="" class="text-primary">Trạng thái 2<span class="text-muted">(5)</span></a>
                <a href="" class="text-primary">Trạng thái 3<span class="text-muted">(20)</span></a>
            </div>
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" id="">
                    <option>Chọn</option>
                    <option>Tác vụ 1</option>
                    <option>Tác vụ 2</option>
                </select>
                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">
                            <input name="checkall" type="checkbox">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($products as $product)
                    <tr class="">
                        <td>
                            <input type="checkbox">
                        </td>
                        <td>{{++$i}}</td>
                        <td><img src="{{asset($product->thumb_main)}}" alt="" width="80" height="80"></td>
                        <td><a target="_blank"
                                href="{{url('san-pham'.'/'.$product->slug.'.'.'html')}}">{{Str::limit($product->name,
                                $limit = 30, $end =
                                '...')}}</a></td>
                        <td>{{number_format($product->new_price, 0, '.','.').'đ'}}</td>
                        <td>{{$product->cat_product->name}}</td>
                        <td>{{$product->created_at}}</td>
                        <td>{!!$product->status = 0?'<span class="badge badge-warning">Chờ duyệt</span>':'<span
                                class="badge badge-success">Công khai</span>'!!}</td>
                        <td>
                            <a href="{{route('product.edit',$product->id)}}"
                                class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                    class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection