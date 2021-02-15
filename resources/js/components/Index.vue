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
              <h1 data-aos="fade-right">{{ sekolah.moto1 }}</h1>
              <p class="mb-5" data-aos="fade-right" data-aos-delay="100">
                {{ sekolah.moto2 }}
              </p>
              <p data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500">
                <!-- <a href="#" class="btn btn-outline-white">Mulai</a> -->
                <!-- <a href="#" class="btn btn-outline-white">Mulai</a> -->
                <router-link to="/berita" class="btn btn-outline-white"
                  >Informasi</router-link
                >
              </p>
            </div>
            <div class="col-lg-4 text-center">
              <img
                :src="urlImage + '/sekolah/' + sekolah.logo"
                alt="Image"
                class="logo-smk"
                data-aos="fade-down"
                data-aos-delay="100"
                v-if="sekolah.logo"
              />
              <img
                @click="onViewJurusan(jurusan)"
                :src="urlImage + '/jurusan/' + jurusan.logo"
                alt="Image"
                :class="'logo-' + index"
                data-aos="fade-down"
                data-aos-delay="100"
                v-for="(jurusan, index) in jurusans"
                :key="index"
              />
            </div>
            <div class="col-lg-4 text-center text-lg-right">
              <h3 class="mb-2 judul" style="color: white" data-aos="fade-up">Visi :</h3>
              <p class="visi" data-aos="fade-right" data-aos-delay="100">
                {{ sekolah.visi }}
              </p>

              <h3 class="mb-2 judul" style="color: white" data-aos="fade-up">Misi :</h3>
              <p
                class="misi"
                data-aos="fade-right"
                data-aos-delay="100"
                v-for="(misi, index) in sekolah.misi"
                :key="index"
              >
                {{ misi.text }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container mb-5">
      <div class="row trending-frame" v-for="(kategori, index) in kategoris" :key="index">
        <div class="caption text-center">{{ kategori.nama }} TERBARU :</div>
        <div class="col-md-12">
          <div class="row" v-if="kategori.berita[0]">
            <div
              class="trending-item"
              v-for="(berita, index) in kategori.berita"
              :key="index"
            >
              <Trending :berita="berita" />
            </div>
          </div>
          <div class="row text-center" v-else style="width: 100%">
            <div class="align-middle text-center" style="width: 100%">
              <h1><i class="icofont-worried"></i></h1>
              <span>Belum ada {{ kategori.nama }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  components: {
    Trending: () => import("../components/Trending/Trending.vue"),
    // KoplakItem: () => import("components/KoplakItem.vue"),
  },
  data() {
    return {
      kategoris: {},
      sekolah: {},
      jurusans: {},
    };
  },
  mounted() {
    this.loadKategoris();
    this.loadSekolah();
    this.loadJurusans();
  },
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
    }),
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
      setPropJurusan: "jurusan/set",
    }),
    loadKategoris() {
      this.setSpinner(true);
      Axios.get("kategori/showBerita")
        .then((response) => {
          this.kategoris = response.data.data;
          // console.log(this.kategoris);
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "ERROR : " + error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
    loadSekolah() {
      this.setSpinner(true);
      Axios.get("sekolah/showAll")
        .then((response) => {
          this.sekolah = response.data.data;
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "ERROR : " + error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
    loadJurusans() {
      this.setSpinner(true);
      Axios.get("jurusan/showAll")
        .then((response) => {
          this.jurusans = response.data.data;
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "ERROR : " + error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
    onViewJurusan(jurusan) {
      this.setPropJurusan(jurusan);
      this.$router.push("/jurusan/viewer");
    },
  },
};
</script>
