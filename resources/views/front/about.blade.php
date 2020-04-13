@extends('layouts.front.app',[
    'navbar'        => 'about',
    'second_title'  => 'About'
])

@section('content_body')
<div class="site-section" id="about-section">
    <div class="container">
      <div class="row mb-5">
        
        <div class="col-md-5 ml-auto mb-5 order-md-2" data-aos="fade">
          <img src="{{ asset("images/about_1.jpg") }}" alt="Image" class="img-fluid rounded">
        </div>
        <div class="col-md-6 order-md-1" data-aos="fade">

          <div class="row">

            <div class="col-12">
              <div class="text-left pb-1">
                <h2 class="text-black h1 site-section-heading">About Us</h2>
              </div>
            </div>
            <div class="col-12 mb-4">
              <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet incidunt magnam corrupti, odit eos harum quaerat nostrum voluptatibus aspernatur eligendi accusantium cum, impedit blanditiis voluptate commodi doloribus, nemo dignissimos recusandae.</p>
            </div>
            <div class="col-md-12 mb-md-5 mb-0 col-lg-6">
              <div class="unit-4">
                <div class="unit-4-icon mr-4 mb-3"><span class="text-secondary icon-phonelink"></span></div>
                <div>
                  <h3>Web &amp; Mobile Specialties</h3>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis quis consect.</p>
                  <p class="mb-0"><a href="#">Learn More</a></p>
                </div>
              </div>
            </div>
            <div class="col-md-12 mb-md-5 mb-0 col-lg-6">
              <div class="unit-4">
                <div class="unit-4-icon mr-4 mb-3"><span class="text-secondary icon-extension"></span></div>
                <div>
                  <h3>Intuitive Thinkers</h3>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis quis.</p>
                  <p class="mb-0"><a href="#">Learn More</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
</div>
<div class="site-section border-bottom" id="team-section">
    <div class="container">
      <div class="row justify-content-center mb-5">
        <div class="col-md-7 text-center">
          <h2 class="text-black h1 site-section-heading">Our Team</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
          <div class="person text-center">
            <img src="{{ asset("images/person_2.jpg") }}" alt="Image" class="img-fluid rounded-circle w-50 mb-5">
            <h3>John Rooster</h3>
            <p class="position text-muted">Co-Founder, President</p>
            <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi at consequatur unde molestiae quidem provident voluptatum deleniti quo iste error eos est praesentium distinctio cupiditate tempore suscipit inventore deserunt tenetur.</p>
            <ul class="ul-social-circle">
              <li><a href="#"><span class="icon-facebook"></span></a></li>
              <li><a href="#"><span class="icon-twitter"></span></a></li>
              <li><a href="#"><span class="icon-linkedin"></span></a></li>
              <li><a href="#"><span class="icon-instagram"></span></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
          <div class="person text-center">
            <img src="{{ asset("images/person_3.jpg") }}" alt="Image" class="img-fluid rounded-circle w-50 mb-5">
            <h3>Tom Sharp</h3>
            <p class="position text-muted">Co-Founder, COO</p>
            <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi at consequatur unde molestiae quidem provident voluptatum deleniti quo iste error eos est praesentium distinctio cupiditate tempore suscipit inventore deserunt tenetur.</p>
            <ul class="ul-social-circle">
              <li><a href="#"><span class="icon-facebook"></span></a></li>
              <li><a href="#"><span class="icon-twitter"></span></a></li>
              <li><a href="#"><span class="icon-linkedin"></span></a></li>
              <li><a href="#"><span class="icon-instagram"></span></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="300">
          <div class="person text-center">
            <img src="{{ asset("images/person_4.jpg") }}" alt="Image" class="img-fluid rounded-circle w-50 mb-5">
            <h3>Winston Hodson</h3>
            <p class="position text-muted">Marketing</p>
            <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi at consequatur unde molestiae quidem provident voluptatum deleniti quo iste error eos est praesentium distinctio cupiditate tempore suscipit inventore deserunt tenetur.</p>
            <ul class="ul-social-circle">
              <li><a href="#"><span class="icon-facebook"></span></a></li>
              <li><a href="#"><span class="icon-twitter"></span></a></li>
              <li><a href="#"><span class="icon-linkedin"></span></a></li>
              <li><a href="#"><span class="icon-instagram"></span></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection