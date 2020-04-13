@extends('layouts.front.app',[
    'navbar'        => 'home',
    'second_title'  => 'Home'
])


@section('content_body')
<div class="slider-area ">
  <!-- Mobile Menu -->
  <div class="slider-active">
      <div class="single-slider slider-height d-flex align-items-center" data-background="{{ asset('images/front/h1_hero.png')}}">
          <div class="container">
              <div class="row">
                  <div class="col-xl-6 col-lg-6 col-md-8">
                      <div class="hero__caption">
                          <p data-animation="fadeInLeft" data-delay=".4s">Selamat Datang</p>
                          <h1 data-animation="fadeInLeft" data-delay=".6s" >Kami memantau setiap hari</h1>
                          <!-- Hero-btn -->
                          <div class="hero__btn" data-animation="fadeInLeft" data-delay=".8s">
                              <a href="{{ route('maps')}}" class="btn hero-btn">Learn More</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="single-slider slider-height d-flex align-items-center" data-background="{{ asset('images/front/h1_hero.png')}}">
          <div class="container">
              <div class="row">
                  <div class="col-xl-6 col-lg-6 col-md-8">
                      <div class="hero__caption">
                          <p data-animation="fadeInLeft" data-delay=".4s">Selamat Datang</p>
                          <h1 data-animation="fadeInLeft" data-delay=".6s" >97.6% Data Akurat</h1>
                          <!-- Hero-btn -->
                          <div class="hero__btn" data-animation="fadeInLeft" data-delay=".8s">
                              <a href="{{ route('data') }}" class="btn hero-btn">Lihat Data</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection