<template>
  <section class="organisasi-section" id="hero">
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
      <div class="row align-items-center header">
        <div class="col-12">
          <h1 data-aos="fade-up">PERSAUDARAAN SETIA HATI TERATE</h1>
          <h2 data-aos="fade-up">P S H T</h2>
          <p>Persaudaraan Setia Hati Terate</p>

          <div class="row"></div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="program" data-aos="fade-left" data-aos-delay="200">
          <div class="program-avatar">
            <img src="img/img_1.jpg" alt="" />
          </div>
          <div class="program-text">
            <div class="program-caption">Masa Jabatan</div>
            <div class="program-description">Pemilihan pengurus baru. Diawali dengan penentuan kandidat, pemilihan dan pelantikan pengurus baru.</div>
          </div>
        </div>
        <div class="program" data-aos="fade-left" data-aos-delay="100">
          <div class="program-avatar">
            <img src="img/img_2.jpg" alt="" />
          </div>
          <div class="program-text">
            <div class="program-caption">Program Kerja</div>
            <div class="program-description">Rencana kegiatan selama masa jabatan 1 (satu) tahun dari kepengurusan yang baru</div>
          </div>
        </div>
        <div class="program" data-aos="fade-left" data-aos-delay="300">
          <div class="program-avatar">
            <img src="img/img_3.jpg" alt="" />
          </div>
          <div class="program-text">
            <div class="program-caption">Kegiatan Rutin</div>
            <div class="program-description">Agenda kegiatan rutin yang menjadi program turun temurun dan sudah dilaksanakan bertahun-tahun</div>
          </div>
        </div>
        <div class="program" data-aos="fade-left" data-aos-delay="600">
          <div class="program-avatar">
            <img src="img/img_4.jpg" alt="" />
          </div>
          <div class="program-text">
            <div class="program-caption">Pembinaan</div>
            <div class="program-description">Pembimbingan guru(Pembina Osis dan Wakases kesiswaan) dan organisasi luar</div>
          </div>
        </div>
        <div class="program" data-aos="fade-left" data-aos-delay="400">
          <div class="program-avatar">
            <img src="img/img_4.jpg" alt="" />
          </div>
          <div class="program-text">
            <div class="program-caption">Template Program</div>
            <div class="program-description">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Reprehenderit aspernatur dolores in omnis, magni fugiat natus! </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row trending-frame">
        <div class="caption text-center">KEGIATAN TERBARU :</div>
        <Trending />
        <Trending />
        <Trending />
        <Trending />
      </div>
    </div>
    
  </section>
</template>

<script>
export default {
  components: {
    Trending: () => import("../Trending/Trending.vue"),
    // KoplakItem: () => import("components/KoplakItem.vue"),
  },
};
</script>
