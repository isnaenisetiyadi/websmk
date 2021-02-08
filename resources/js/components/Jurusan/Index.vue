<template>
  <section class="jurusan-section" id="hero">
    <div class="wave">
      <svg width="100%" height="355px" viewBox="0 0 1920 355" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
            <path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z" id="Path"></path>
          </g>
        </g>
      </svg>
    </div>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 hero-text-image">
          <img class="logo-jurusan" src="images/logo/logo_atph.png" alt="" />
          <div class="row">
            <div class="col-lg-4 text-center text-lg-left">
              <h1 data-aos="fade-right">ATPH</h1>
              <p class="mb-5" data-aos="fade-right" data-aos-delay="100">Agribisnis Tanaman Pangan dan Hortikultura</p>
              <p data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500">
                <a href="#" class="btn btn-outline-white">Tour Jurusan</a>
              </p>
            </div>
            <div class="col-lg-8 text-center">
              <div class="personal personal-posisi-1" data-aos="fade-left" data-aos-delay="300">
                <div class="personal-item personal-item-blue">
                  <h5>Desi Ambarsari, S.Pt.</h5>
                  <span>Ketua Program Studi</span>
                </div>
                <div class="personal-logo">
                  <img src="img/person_1.jpg" alt="" />
                </div>
              </div>
              <div class="personal personal-posisi-2" data-aos="fade-left" data-aos-delay="400">
                <div class="personal-item personal-item-yellow">
                  <h5>Yuliani, S.Pt.</h5>
                  <span>Guru Produktif</span>
                </div>
                <div class="personal-logo">
                  <img src="img/person_3.jpg" alt="" />
                </div>
              </div>
              <div class="personal personal-posisi-3" data-aos="fade-left" data-aos-delay="500">
                <div class="personal-item personal-item-green">
                  <h5>Endang Rahayu, S.Pt.</h5>
                  <span>Guru Produktif</span>
                </div>
                <div class="personal-logo">
                  <img src="img/person_2.jpg" alt="" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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

<script>
export default {
  // components: {
  //   Trending: () => import("../components/Trending/Trending.vue"),
  //   // KoplakItem: () => import("components/KoplakItem.vue"),
  // },
};
</script>
