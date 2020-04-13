<header>
    <!-- Header Start -->
   <div class="header-area">
        <div class="main-header ">
            <div class="header-top top-bg d-none d-lg-block">
               <div class="container-fluid">
                   <div class="col-xl-12">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="header-info-left">
                                <ul>     
                                    <li><i class="fas fa-map-marker-alt"></i>Jl.Veteran no 31,Semarang</li>
                                    <li><i class="fas fa-envelope"></i>info@sigapbanjir.com</li>
                                </ul>
                            </div>
                            <div class="header-info-right">
                                <ul class="header-social">    
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                   <li> <a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                </ul>
                            </div>
                        </div>
                   </div>
               </div>
            </div>
           <div class="header-bottom  header-sticky">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <!-- Logo -->
                        <div class="col-xl-2 col-lg-1 col-md-1">
                            <div class="logo">
                              <a href="{{ route('home')}}"><img src="{{ asset('images/front/logo1.png')}}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8">
                            <!-- Main-menu -->
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav> 
                                    <ul id="navigation">                                                                                                                                     
                                        <li><a href="{{ route('home')}}" class="nav-link {{ !empty($navbar) ? ($navbar == "home" ? 'active' : '') : '' }}">Home</a></li>
                                        <li><a href="{{ route('maps')}}" class="nav-link {{ !empty($navbar) ? ($navbar == "maps" ? 'active' : '') : '' }}">Map</a></li>
                                        <li><a href="{{ route('data')}}" class="nav-link {{ !empty($navbar) ? ($navbar == "data" ? 'active' : '') : '' }}">Data</a></li>
                                        <li><a href="{{ route('about')}}" class="nav-link {{ !empty($navbar) ? ($navbar == "about" ? 'active' : '') : '' }}">About Us</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
           </div>
        </div>
   </div>
    <!-- Header End -->
</header>