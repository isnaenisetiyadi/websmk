<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SMK N 1 Mepanga</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('img/favicon.png')}}" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <!-- <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet"> -->

    <link href="{{ asset ('css/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset ('css/line-awesome.min.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <!-- <link href="assets/css/style.css" rel="stylesheet"> -->
    <!-- <link href="{{ asset ('css/style.css')}}" rel="stylesheet"> -->
    <link href="{{ asset ('css/all.css')}}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: SoftLand - v2.1.0
  * Template URL: https://bootstrapmade.com/softland-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Mobile Menu ======= -->
    <div id="app">


        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icofont-close js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>

        <!-- ======= Header ======= -->
        <header class="site-navbar js-sticky-header site-navbar-target" role="banner">

            <div class="container">
                <div class="row align-items-center">

                    <div class="col-6 col-lg-4">
                        <h1 class="mb-0 site-logo"><a href="/" class="mb-0">SMK Negeri 1 Mepanga</a></h1>
                    </div>

                    <div class="col-12 col-md-8 d-none d-lg-block">
                        <nav class="site-navigation position-relative text-right" role="navigation">

                            <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                                <li class="active">
                                    <!-- <a href="index.html" class="nav-link">Home</a> -->
                                    <router-link to="/">Beranda</router-link>
                                </li>


                                <li class="has-children">
                                    <a class="nav-link">INFO</a>
                                    <!-- <router-link>INFO</router-link> -->

                                    <ul class="dropdown">
                                        <li>
                                            <!-- <a href="blog.html" class="nav-link">Web</a> -->
                                            <router-link to="/berita">Berita</router-link>
                                        </li>
                                        <li>
                                            <!-- <a href="blog.html" class="nav-link">Web</a> -->
                                            <router-link to="/pengumuman">Pengumuman</router-link>
                                        </li>
                                        <li>
                                            <!-- <a href="blog.html" class="nav-link">Web</a> -->
                                            <router-link to="/galeri">Galeri Foto</router-link>
                                        </li>

                                        <hr>
                                        <li>
                                            <router-link to="/awards/siswa">Student of the month</router-link>
                                            <!-- <a href="/awards/siswa" class="nav-link"></a> -->
                                        </li>
                                        <li>
                                            <router-link to="/awards/guru">Teacher of the year</router-link>
                                            <!-- <a href="blog-single.html" class="nav-link">Teacher of the year</a> -->
                                        </li>

                                    </ul>
                                </li>
                                <li class="has-children">
                                    <!-- <a class="nav-link">JURUSAN</a> -->
                                    <router-link to="">JURUSAN</router-link>
                                    <!-- JURUSAN -->

                                    <ul class="dropdown">
                                        <li>
                                            <!-- <a href="blog.html" class="nav-link">Web</a> -->
                                            <router-link to="/jurusan/atph">ATPH</router-link>
                                        </li>
                                        <li>
                                            <!-- <a href="blog.html" class="nav-link">Web</a> -->
                                            <router-link to="/jurusan/apat">APAT</router-link>
                                        </li>
                                        <li>
                                            <!-- <a href="blog.html" class="nav-link">Web</a> -->
                                            <router-link to="/jurusan/akl">AKL</router-link>
                                        </li>
                                        <li>
                                            <!-- <a href="blog.html" class="nav-link">Web</a> -->
                                            <router-link to="/jurusan/tkj">TKJ</router-link>
                                        </li>
                                        <!-- <li><a href="blog-single.html" class="nav-link">APAT</a></li>
                                        <li><a href="blog-single.html" class="nav-link">TKJ</a></li>
                                        <li><a href="blog-single.html" class="nav-link">AKL</a></li> -->
                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a class="nav-link">ORGANISASI</a>
                                    <!-- <router-link to="/">ORGANISASI</router-link> -->

                                    <ul class="dropdown">
                                        <li>
                                            <!-- <a href="blog.html" class="nav-link">Web</a> -->
                                            <router-link to="/organisasi/osis">OSIS</router-link>
                                        </li>
                                        <li>
                                            <!-- <a href="blog.html" class="nav-link">Web</a> -->
                                            <router-link to="/organisasi/pramuka">Pramuka</router-link>
                                        </li>
                                        <li>
                                            <!-- <a href="blog.html" class="nav-link">Web</a> -->
                                            <router-link to="/organisasi/jujitsu">Jujitsu</router-link>
                                        </li>
                                        <li>
                                            <!-- <a href="blog.html" class="nav-link">Web</a> -->
                                            <router-link to="/organisasi/psht">PSHT</router-link>
                                        </li>
                                        <li>
                                            <!-- <a href="blog.html" class="nav-link">Web</a> -->
                                            <router-link to="/organisasi/multimedia">Multimedia</router-link>
                                        </li>
                                        

                                    </ul>
                                </li>
                                <li class="has-children">
                                    <a class="nav-link">CONTENT</a>
                                    <!-- <router-link to="/">CONTENT</router-link> -->

                                    <ul class="dropdown">
                                        <li><a href="blog-single.html" class="nav-link">Login</a></li>
                                        <hr>
                                        <li>
                                            <!-- <a href="blog.html" class="nav-link">Web</a> -->
                                            <router-link to="/entry/berita">Berita</router-link>
                                        </li>
                                        <li><a href="blog-single.html" class="nav-link">Profil</a></li>

                                    </ul>
                                </li>



                            </ul>
                        </nav>
                    </div>

                    <div class="col-6 d-inline-block d-lg-none ml-md-0 py-3" style="position: relative; top: 3px;">

                        <a href="#" class="burger site-menu-toggle js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
                            <span></span>
                        </a>
                    </div>

                </div>
            </div>

        </header>



        <main id="main">
            <!-- @yield('main') -->
            <router-view></router-view>
        </main>

        <!-- ======= Footer ======= -->
        <footer class="footer" role="contentinfo">
            <div class="container">
               

                <div class="row justify-content-center text-center">
                    <div class="col-md-7">
                        <p class="copyright">&copy; Copyright SMKN 1 Mepanga. All Rights Reserved</p>
                        <div class="credits">
                          
                            Developed by <a href="http://www.bitapp.id/">bitApp</a> as Fullstack
                        </div>
                    </div>
                </div>

            </div>
        </footer>
    </div>

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset ('js/jquery.min.js') }}"></script>
    <script src="{{ asset ('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset ('js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset ('js/validate.js') }}"></script>
    <script src="{{ asset ('js/aos.js') }}"></script>
    <script src="{{ asset ('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset ('js/jquery.sticky.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset ('js/app.js') }}"></script>
    <script src="{{ asset ('js/main.js') }}"></script>

</body>

</html>