@extends('layouts.client')
@section('content')
<section id="myContent">
  <div class="container">
    <div class="row">
      <div class="col-12 d-md-none my-3">
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Nhập từ khóa bạn muốn tìm?" aria-label="Search">
          <button class="btn btn-success" type="submit">Search</button>
        </form>
      </div>
    </div>
    <div class="row my-3 ">
      <div class="col-md-3 sidebar d-none d-md-block">
        @include('inc.sbHome')
      </div>
      <div class="col-md-9">
        <div class="row">
          <div class="col-md-9">
            <div id="slider">
              <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                  @foreach ($sliders as $key => $slider)
                  <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{$key}}"
                    class="{{ $key===0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{$key}}"></button>
                  @endforeach
                </div>
                <div class="carousel-inner">
                  @foreach ($sliders as $key => $slider)
                  <div class="carousel-item {{ $key===0 ? 'active' : '' }}" data-bs-interval="3500">
                    <a href="{{$slider->link}}"> <img src="{{asset($slider->thumb_slider)}}" height="400"
                        class="d-block w-100" alt=""></a>
                    <div class="carousel-caption d-none d-md-block">
                      <h5>First slide label</h5>
                      <p>Some representative placeholder content for the first slide.</p>
                    </div>
                  </div>
                  @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                  data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                  data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
            </div>
          </div>
          <div class="col-md-3 d-none d-md-block">
            <div id="banner-slider">
              <div class="row">
                <img src="https://bizweb.dktcdn.net/100/460/476/themes/869615/assets/bb1.jpg?1681293051273" alt=""
                  class="banner-image">
              </div>
              <div class="row">
                <img src="https://bizweb.dktcdn.net/100/460/476/themes/869615/assets/bb2.jpg?1681293051273" alt=""
                  class="banner-image">
              </div>
              <div class="row">
                <img src="https://bizweb.dktcdn.net/100/460/476/themes/869615/assets/bb3.jpg?1681293051273" alt=""
                  class="banner-image">
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <div id="service" class="">
              <ul class="list-flag d-md-flex justify-content-around">
                <li class="flag-item text-center">
                  <div class="icon"><img src="{{asset('client/images/icon-1.png')}}" alt=""></div>
                  <div class="text-desc">
                    <b>Miễn phí vận chuyển</b>
                    <p>Giao hàng toàn quốc</p>
                  </div>
                </li>
                <li class="flag-item text-center">
                  <div class="icon"><img src="{{asset('client/images/icon-2.png')}}" alt=""></div>
                  <div class="text-desc">
                    <b>Tư vấn 24/7</b>
                    <p>Gọi điện mọi lúc, mọi nơi</p>
                  </div>
                </li>
                <li class="flag-item text-center">
                  <div class="icon"><img src="{{asset('client/images/icon-3.png')}}" alt=""></div>
                  <div class="text-desc">
                    <b>Tiết kiệm hơn</b>
                    <p>Với nhiều ưu đãi lớn</p>
                  </div>
                </li>
                <li class="flag-item text-center">
                  <div class="icon"><img src="{{asset('client/images/icon-4.png')}}" alt=""></div>
                  <div class="text-desc">
                    <b>Thanh toán nhanh</b>
                    <p>Hỗ trợ thanh toán online</p>
                  </div>
                </li>
                <li class="flag-item text-center">
                  <div class="icon"><img src="{{asset('client/images/icon-5.png')}}" alt=""></div>
                  <div class="text-desc">
                    <b>Đặt hàng online</b>
                    <p>Thao tác đơn giản</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row mt-3" id="row-2">
          <div class="col-md-8">
            <section id="featured-products">
              <div class="title">
                <img src="{{asset('client/images/FeaturedProducts.webp')}}" alt="">
                <b>SẢN PHẨM NỔI BẬT</b>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselDiscount"
                  data-bs-slide="prev">
                  <span class="carousel-control-prev-icon d-none" aria-hidden="true"></span>
                  <i class="fas fa-chevron-left"></i>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselDiscount"
                  data-bs-slide="next">
                  <span class="carousel-control-next-icon d-none" aria-hidden="true"></span>
                  <i class="fas fa-chevron-right"></i>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
              <div class="show-discount mt-1">
                <div id="carouselDiscount" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-inner">
                    @foreach ($featured_products as $key => $featured_product)
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}" data-bs-interval="10000">
                      <div class="row">
                        <div class="col-md-6">
                          <a href="?page=detailProduct"> <img src="{{asset($featured_product->thumb_main)}}" alt=""
                              class="rounded w-100"></a>
                          <div class="name-product">
                            <p>{{Str::limit($featured_product->name, $limit = 50, $end =
                              '...')}}</p>
                          </div>
                          <div class="price">
                            <div class="new-price text-danger d-inline-block">
                              {{number_format($featured_product->new_price, 0, '.','.').'đ'}}
                            </div>
                            <small class="old-price d-inline-block"><del>{{number_format($featured_product->old_price,
                                0,
                                '.','.').'đ'}}</del></small>
                          </div>
                          <div class="sold">
                            <p class="d-inline-block text-white">{{$featured_product->purchases}} sản phẩm đã
                              được
                              bán</p>
                          </div>
                        </div>
                        <div class="col-md-6 discount-right">
                          <p class="title-discount">Khuyến mại</p>
                          <b class="percent">
                            <div class="number">{{$featured_product['discount'] . '%'}}</div>
                          </b>
                          <div class="benefit">
                            <div class="benefit-item my-3">
                              <div class="icon d-inline-block"><i class="fas fa-check-circle"></i></div>
                              <b>Miễn phí vận chuyển</b>
                            </div>
                            <div class="benefit-item my-3">
                              <span class="icon d-inline-block"><i class="fas fa-check-circle"></i></span>
                              <b class="d-inline-block">Lắp đặt tận nhà</b>
                            </div>
                            <div class="benefit-item my-3">
                              <span class="icon d-inline-block"><i class="fas fa-check-circle"></i></span>
                              <b class="d-inline-block">Bảo hành lợi mãi</b>
                            </div>
                          </div>
                          <hr>
                          <div class="Countdown d-flex">
                            <div class="hour">
                              <div class="d-flex">
                                <div class="box hour-box">
                                  00
                                </div>
                                <b class="seperate">:</b>
                              </div>
                              <p class="time-unit">Giờ</p>
                            </div>
                            <div class="minute">
                              <div class="d-flex">
                                <div class="box minute-box">
                                  00
                                </div>
                                <b class="seperate">:</b>
                              </div>
                              <p class="time-unit">Phút</p>
                            </div>
                            <div class="sec">
                              <div>
                                <div class="box second-box">
                                  00
                                </div>
                              </div>
                              <p class="time-unit">Giây</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </section>
          </div>
          <div class="col-md-4">
            <div id="bestseller">
              <div class="title">
                <b>
                  <div class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7601/7601323.png" alt=""
                      width="40">
                  </div>
                  <p class="bestseller-title">TOP 3 BÁN CHẠY</p>
                </b>
                <script>
                  var object = document.querySelector('.bestseller-title')
        setInterval(function() {
            object.classList.toggle('warning')
        }, 300)
                </script>
              </div>
              <div class="item mt-1">
                <ul>
                  <li class="d-flex">
                    <div class="row">
                      <div class="col-md-4">
                        <img src="public/images/pc2_thumb_main.png" alt="error">
                      </div>
                      <div class="col-md-8">
                        <div class="name-product">
                          <p>Bàn ăn cao
                            cấp làm từ gỗ tái chế ...</p>
                          <div class="price">
                            <div class="new-price">
                              8.000.000₫
                            </div>
                            <p class="old-price">
                              <del> 8.000.000₫</del>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="d-flex">
                    <div class="row">
                      <div class="col-md-4">
                        <img src="public/images/pc2_thumb_main.png" alt="error">
                      </div>
                      <div class="col-md-8">
                        <div class="name-product">
                          <p>Bàn ăn cao
                            cấp làm từ gỗ tái chế ...</p>
                          <div class="price">
                            <div class="new-price">
                              8.000.000₫
                            </div>
                            <p class="old-price">
                              <del> 8.000.000₫</del>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="d-flex">
                    <div class="row">
                      <div class="col-md-4">
                        <img src="public/images/pc2_thumb_main.png" alt="error">
                      </div>
                      <div class="col-md-8">
                        <div class="name-product">
                          <p>Bàn ăn cao
                            cấp làm từ gỗ tái chế ...</p>
                          <div class="price">
                            <div class="new-price">
                              8.000.000₫
                            </div>
                            <p class="old-price">
                              <del> 8.000.000₫</del>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        @empty(!$groupedProducts)
        @foreach($groupedProducts as $k=>$v)
        <div class="row mt-3">
          <section id="list-product">
            <div class="category mt-3">
              <div class="title">
                <p>{{$k}}</p>
              </div>
              <ul>
                @foreach ($v as $item)
                <li class="item">
                  <div class="thumb-product">
                    <a href="{{route('client.product.detail',$item->slug)}}"><img src="{{asset($item->thumb_main)}}"
                        alt=""></a>
                  </div>
                  <div class="view&code d-flex justify-content-between mb-2">
                    <div class="code">
                      Mã SP <span>{{$item->code}}</span>
                    </div>
                    <div class="view d-flex">
                      <div class="icon"><i class="fas fa-eye"></i></div>
                      {{$item->views}}
                    </div>
                  </div>
                  <div class="name-product">
                    <a href="{{route('client.product.detail',$item->slug)}}">{{Str::limit($item->name,
                      $limit = 35, $end =
                      '...')}}</a>
                  </div>
                  <div class="price">
                    <div class="new-price d-inline-block">{{number_format($item->new_price, 0, '.','.').'đ'}}</div>
                    <small class="old-price d-inline-block">{{number_format($item->old_price, 0,
                      '.','.').'đ'}}</small>
                  </div>
                  <div class="action mt-2 d-flex justify-content-between">
                    <a href="{{route('client.cart.add',$item->slug)}}" title=""
                      class="btn btn-style add-cart fl-left"><span>Thêm
                        giỏ
                        hàng</span></a>
                    <a href="" title="" class="btn btn-style buy-now fl-right"><span>Mua
                        ngay</span></a>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          </section>
        </div>
        @endforeach
        @endempty
      </div>
    </div>
    <section id="new-post" class="d-none d-md-block">
      <div class="row">
        <div class="col-md-12">
          <div class="title">
            <img src="{{asset('client/images/FeaturedProducts.webp')}}" alt="">
            <b>BÀI VIẾT MỚI NHẤT</b>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-7 my-3">
          <div class="cat1">
            <div class="row">
              @foreach ($listPostEnvironment as $post)
              <div class="col-6">
                <div class="thumb-post">
                  <a href=""><img src="{{asset($post->thumb_main)}}" alt="err"></a>
                </div>
                <p class="content-demo">{{Str::limit($post->name,
                  $limit = 60, $end =
                  '...')}}</p>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="col-md-5 my-3">
          <div class="cat2">
            @foreach ($listPost as $post)
            <div class="row">
              <div class="col-5">
                <div class="thumb-post">
                  <a href=""><img src="{{asset($post->thumb_main)}}" alt=""></a>
                </div>
              </div>
              <div class="col-7">
                <p class="namePost">{{Str::limit($post->name,
                  $limit = 60, $end =
                  '...')}}</p>
                <div class="cat-name">
                  <p>{{$post->Cat_blog->name}}</p>
                </div>
                <p class="content-demo">{{Str::limit($post->content_demo,
                  $limit = 160, $end =
                  '...')}}</p>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>
    <div id="wp-subscriber">
      <div class="col-md-7">
        <div class="subscriber">
          <div class="row">
            <div class="col-md-2">
              <div class="icon d-none d-md-block"><i class="fas fa-envelope-open-text"></i></div>
            </div>
            <div class="col-md-9">
              <div class="wp-content">
                <div class="title">
                  <b class="fs-4">Đăng kí nhận tin tức</b>
                </div>
                <p class="desc">Thông báo khuyến mãi để không bỏ lỡ.</p>
                <form action="" class="d-flex">
                  <input type="text" class="form-control py-2 d-block" placeholder="Nhập email của bạn">
                  <input type="submit" value="Đăng kí" class="btn-reg ms-2 btn">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection