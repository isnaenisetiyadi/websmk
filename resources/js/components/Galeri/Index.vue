<template>
  <section class="section">
    <div class="container-fluid banner" height="50px"></div>
    <section class="site-section mb-4">
      <div class="container">
        <div class="row"  data-aos="fade-down" data-aos-delay="100">
          <div class="col-md-8 blog-content">
            <h3>Galeri Foto</h3>

            <div class="row mb-5" data-aos="fade-left" data-aos-delay="100">
              <div class="col-md-4">
                <figure>
                  <img src="img/img_1.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid" />
                  <figcaption>This is an image caption</figcaption>
                </figure>
              </div>
              <div class="col-md-4" data-aos="fade-right" data-aos-delay="100">
                <figure>
                  <img src="img/img_2.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid" />
                  <figcaption>This is an image caption</figcaption>
                </figure>
              </div>
              <div class="col-md-4">
                <figure>
                  <img src="img/img_3.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid" />
                  <figcaption>This is an image caption</figcaption>
                </figure>
              </div>
              <div class="col-md-4">
                <figure>
                  <img src="img/img_1.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid" />
                  <figcaption>This is an image caption</figcaption>
                </figure>
              </div>
              <div class="col-md-4" data-aos="fade-right" data-aos-delay="100">
                <figure>
                  <img src="img/img_2.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid" />
                  <figcaption>This is an image caption</figcaption>
                </figure>
              </div>
              <div class="col-md-4">
                <figure>
                  <img src="img/img_3.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid" />
                  <figcaption>This is an image caption</figcaption>
                </figure>
              </div>
              <div class="col-md-4">
                <figure>
                  <img src="img/img_1.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid" />
                  <figcaption>This is an image caption</figcaption>
                </figure>
              </div>
              <div class="col-md-4" data-aos="fade-right" data-aos-delay="100">
                <figure>
                  <img src="img/img_2.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid" />
                  <figcaption>This is an image caption</figcaption>
                </figure>
              </div>
              <div class="col-md-4">
                <figure>
                  <img src="img/img_3.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid" />
                  <figcaption>This is an image caption</figcaption>
                </figure>
              </div>
            </div>

           
          </div>
          <div class="col-md-4 sidebar">
            <div class="sidebar-box">
              <form action="#" class="search-form">
                <div class="form-group">
                  <span class="icon fa fa-search"></span>
                  <input type="text" class="form-control" placeholder="Ketik kata kunci" />
                </div>
              </form>
            </div>
            <div class="sidebar-box" data-aos="fade-up" data-aos-delay="300">
              <div class="categories">
                <h3>Kategori</h3>
                <li>
                  <a href="#">Pengumuman <span>(12)</span></a>
                </li>
                <li>
                  <a href="#">Berita <span>(22)</span></a>
                </li>
                <li>
                  <a href="#">Prestasi <span>(37)</span></a>
                </li>
                <li>
                  <a href="#">Serba-serbi<span>(42)</span></a>
                </li>
              </div>
            </div>
            <div class="sidebar-box">
              <img src="img/happy.png" alt="Image placeholder" class="img-fluid mb-4" />
              <h3>Es Teh Plastikan</h3>
              <p>Gambar penuh makna, gambar penuh cerita. Adakah luka dibalik tawa? </p>
              <p>Akankah desahan malam pertama, menghapus cerita yang telah ada. Tanpa menyisakan setitikpun noda?</p>
              <p><a href="#" class="btn btn-primary btn-sm">Tampilkan Lebih Banyak ...</a></p>
            </div>

           
          </div>
        </div>
      </div>
    </section>

    <div class="container">
      <div class="row justify-content-center text-center mb-5">
        <div class="col-md-5" data-aos="fade-up">
          <h2 class="section-heading">Layanan Kami</h2>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay>
          <div class="feature-1 text-center">
            <router-link to="/layananitem">
              <div class="wrap-icon icon-1">
                <span class="icon la la-globe"></span>
              </div>
            </router-link>
            <h3 class="mb-3">Web Profil</h3>
            <p style="text-decoration: none">Cocok untuk kantor/ instansi/ sekolah, perusahan swasta, BUMN, dan lain-lain</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-1 text-center">
            <router-link to="/layananitem">
              <div class="wrap-icon icon-1">
                <span class="icon la la-laptop"></span>
              </div>
            </router-link>
            <h3 class="mb-3">Web Apps</h3>
            <p>Aplikasi web untuk administrasi toko, sekolah, dan lain-lain</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="feature-1 text-center">
            <router-link to="/layananitem">
              <div class="wrap-icon icon-1">
                <span class="icon la la-file-video-o"></span>
              </div>
            </router-link>
            <h3 class="mb-3">Digital Promotion</h3>
            <p>Layanan pembuatan video promosi, animasi, sampai publikasi ke media sosial</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-1 text-center">
            <router-link to="/layananitem">
              <div class="wrap-icon icon-1">
                <span class="icon la la-print"></span>
              </div>
            </router-link>
            <h3 class="mb-3">Digital Printing</h3>
            <p>Desain, cetak dan publikasi pada space iklan kami</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="feature-1 text-center">
            <router-link to="/layananitem">
              <div class="wrap-icon icon-1">
                <span class="icon la la-paste"></span>
              </div>
            </router-link>
            <h3 class="mb-3">Copier</h3>
            <p>Gandakan dokumen dengan hasil maksimal</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-1 text-center">
            <router-link to="/layananitem">
              <div class="wrap-icon icon-1">
                <span class="icon la la-list-ul"></span>
              </div>
            </router-link>
            <h3 class="mb-3">Retail</h3>
            <p>Kebutuhan harian ecer, online maupun offline</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
