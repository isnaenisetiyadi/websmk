<template>
  <section class="hero-section" id="hero">
    <div class="wave">
      <svg
        width="100%"
        height="355px"
        viewBox="0 0 1920 355"
        version="1.1"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
      >
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
            <path
              d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z"
              id="Path"
            ></path>
          </g>
        </g>
      </svg>
    </div>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 hero-text-image">
          <div class="row">
            <div class="col-lg-4 text-center text-lg-left">
              <h1 data-aos="fade-right">Vocational High School</h1>
              <p class="mb-5" data-aos="fade-right" data-aos-delay="100">
                Sekolah Menengah Kejuruan
              </p>
              <p data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500">
                <!-- <a href="#" class="btn btn-outline-white">Mulai</a> -->
                <!-- <a href="#" class="btn btn-outline-white">Mulai</a> -->
                <router-link to="/berita" class="btn btn-outline-white">Mulai</router-link>
              </p>
            </div>
            <div class="col-lg-4 text-center">
              <img
                src="images/logo/logo_smk.png"
                alt="Image"
                class="logo-smk"
                data-aos="fade-down"
                data-aos-delay="100"
              />
              <img
                src="images/logo/logo_atph.png"
                alt="Image"
                class="logo-atph"
                data-aos="fade-up"
                data-aos-delay="700"
              />
              <img
                src="images/logo/logo_apat.png"
                alt="Image"
                class="logo-apat"
                data-aos="fade-right"
                data-aos-delay="900"
              />
              <img
                src="images/logo/logo_akl.png"
                alt="Image"
                class="logo-akl"
                data-aos="fade-left"
                data-aos-delay="500"
              />
              <img
                src="images/logo/logo_tkj.png"
                alt="Image"
                class="logo-tkj"
                data-aos="fade-down"
                data-aos-delay="1100"
              />
            </div>
            <div class="col-lg-4 text-center text-lg-right">
              <h3 class="mb-2 judul" style="color: white" data-aos="fade-up">Visi :</h3>
              <p class="visi" data-aos="fade-right" data-aos-delay="100">
                Terampil, Cerdas, Terdidik berdasarkan iman dan taqwa
              </p>

              <h3 class="mb-2 judul" style="color: white" data-aos="fade-up">Misi :</h3>
              <p class="misi" data-aos="fade-right" data-aos-delay="100">
                Mengembangkan iklim belajar berdasarkan norma budaya Indonesia
              </p>
              <p class="misi" data-aos="fade-right" data-aos-delay="100">
                Mengembangkan sistem pendidikan yang fleksible
              </p>
              <p class="misi" data-aos="fade-right" data-aos-delay="100">
                Menyiapkan tamatan yang memiliki keterampilan sesuai profesionalismenya
              </p>
              <p class="misi" data-aos="fade-right" data-aos-delay="100">
                Mencetak tamatan yang memiliki karir di bidangnya serta memberi landasan
                untuk melanjutkan pendidikan ke jenjang yang lebih tinggi
              </p>
             
            </div>
          </div>
        </div>

        <!-- <div class="row trending-frame">
          <div class="caption text-center">PENGUMUMAN TERBARU :</div>
          <Trending />
          <Trending />
          <Trending />
        </div> -->
      </div>
      <!-- <div class="row trending-frame align-item-center">
        <div class="caption text-center">IMAGE TODAY</div>
        <div
          class="container"
          style="
             {
              margin-left: 0;
            }
          "
        >
          <div class="row justify-content-center text-center">
            <div class="col-md-12">
              <div class="owl-carousel testimonial-carousel">
                <div class="review text-center">
                  <p class="stars">
                    <span class="icofont-star"></span>
                    <span class="icofont-star"></span>
                    <span class="icofont-star"></span>
                    <span class="icofont-star"></span>
                    <span class="icofont-star muted"></span>
                  </p>
                  <h3>Excellent App!</h3>
                  <blockquote>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea
                      delectus pariatur, numquam aperiam dolore nam optio dolorem facilis
                      itaque voluptatum recusandae deleniti minus animi, provident
                      voluptates consectetur maiores quos.
                    </p>
                  </blockquote>

                  <p class="review-user">
                    <img
                      src="img/person_1.jpg"
                      alt="Image"
                      class="img-fluid rounded-circle mb-3"
                    />
                    <span class="d-block">
                      <span class="text-black">Jean Doe</span>, &mdash; App User
                    </span>
                  </p>
                </div>

                <div class="review text-center">
                  <p class="stars">
                    <span class="icofont-star"></span>
                    <span class="icofont-star"></span>
                    <span class="icofont-star"></span>
                    <span class="icofont-star"></span>
                    <span class="icofont-star muted"></span>
                  </p>
                  <h3>This App is easy to use!</h3>
                  <blockquote>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea
                      delectus pariatur, numquam aperiam dolore nam optio dolorem facilis
                      itaque voluptatum recusandae deleniti minus animi, provident
                      voluptates consectetur maiores quos.
                    </p>
                  </blockquote>

                  <p class="review-user">
                    <img
                      src="img/person_2.jpg"
                      alt="Image"
                      class="img-fluid rounded-circle mb-3"
                    />
                    <span class="d-block">
                      <span class="text-black">Johan Smith</span>, &mdash; App User
                    </span>
                  </p>
                </div>

                <div class="review text-center">
                  <p class="stars">
                    <span class="icofont-star"></span>
                    <span class="icofont-star"></span>
                    <span class="icofont-star"></span>
                    <span class="icofont-star"></span>
                    <span class="icofont-star muted"></span>
                  </p>
                  <h3>Awesome functionality!</h3>
                  <blockquote>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea
                      delectus pariatur, numquam aperiam dolore nam optio dolorem facilis
                      itaque voluptatum recusandae deleniti minus animi, provident
                      voluptates consectetur maiores quos.
                    </p>
                  </blockquote>

                  <p class="review-user">
                    <img
                      src="img/person_3.jpg"
                      alt="Image"
                      class="img-fluid rounded-circle mb-3"
                    />
                    <span class="d-block">
                      <span class="text-black">Jean Thunberg</span>, &mdash; App User
                    </span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
    </div>
    <div class="container mb-5">
      <div class="row trending-frame" v-for="(kategori, index) in kategoris" :key="index">
        <div class="caption text-center">{{ kategori.nama }} TERBARU :</div>
        <div class="col-md-12" >
          <div class="row" v-if="kategori.berita[0]">
            <div class="trending-item" v-for="(berita, index) in kategori.berita" :key="index">
              <Trending :berita="berita" />
            </div>
          </div>
          <div class="row" v-else style="width:100%;">
            <div class="col-md-12 align-middle text-center">
              <h1><i class="icofont-worried"></i></h1>
              <span>Belum ada {{kategori.nama}}</span>
            </div>
          </div>
        </div>
        <!-- <Trending />
          <Trending />
          <Trending /> -->
      </div>
    </div>
  </section>
</template>

<script>
import Axios from "axios";
export default {
  components: {
    Trending: () => import("../components/Trending/Trending.vue"),
    // KoplakItem: () => import("components/KoplakItem.vue"),
  },
  data() {
    return {
      kategoris: {},
    };
  },
  mounted() {
    this.loadKategoris();
  },
  methods: {
    loadKategoris() {
      Axios.get("kategori/showBerita")
        .then((response) => {
          this.kategoris = response.data.data;
          // console.log(this.kategoris);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "ERROR : " + error.message,
            type: "error", //nilai lain, error dan success
          });
        });
    },
  },
};
</script>
