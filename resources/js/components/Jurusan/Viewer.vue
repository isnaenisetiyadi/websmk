<template>
  <section class="jurusan-section mb-5" id="hero">
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

    <div class="fly-mn" v-if="jurusans">
      <!-- <div v-bind:class="[isActive ? activeClass : '', errorClass]"></div> -->
      <!-- <div v-bind:class="{ active: isActive }"></div> -->
      <div class="fly-mn-left p-2" :class="[sideMenu ? 'fly-mn-80' : 'fly-mn-0']">
        <button
          v-for="(jurusan, index) in jurusans"
          :key="index"
          type="button"
          class="btn btn-gradient mb-2 btn-100"
          :class="{ 'btn-hide': !sideMenu }"
          v-on:click="viewJurusan(jurusan)"
        >
          {{ jurusan.nama }}
        </button>
      </div>
      <div clickable class="fly-mn-right" v-on:click="hideMenu()">
        <i class="icofont-curved-double-left icon-lg" v-if="sideMenu"></i>
        <i class="icofont-curved-double-right icon-lg" v-else></i>
      </div>
    </div>

    <div class="container" v-if="jurusanItem">
      <div class="row align-items-center">
        <div class="col-12 hero-text-image">
          <img
            class="logo-jurusan"
            :src="urlImage + '/jurusan/' + jurusanItem.logo"
            alt=""
            v-if="jurusanItem.logo"
          />
          <img class="logo-jurusan" :src="urlImage + '/anything.jpg'" alt="" v-else />
          <div class="row">
            <div class="col-lg-4 text-center text-lg-left">
              <h1 data-aos="fade-right">{{ jurusanItem.nama }}</h1>
              <p class="mb-5" data-aos="fade-right" data-aos-delay="100">
                {{ jurusanItem.deskripsi }}
              </p>
              <!-- <p data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500">
                <a href="#" class="btn btn-outline-white">Tour Jurusan</a>
              </p> -->
            </div>
            <div class="col-lg-8 text-center personal-section">
              <div>
                <JGuruItem
                  v-for="(guru, index) in jurusanItem.guru"
                  :key="index"
                  :guru="guru"
                  v-bind:class="['personal-posisi-' + index]"
                  :warna="index"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container mb-5" style="margin-top: 50px" v-if="jurusanItem">
      <div class="row trending-frame">
        <div class="caption text-center">INFORMASI :</div>

        <div class="col-md-12">
          <!-- <div class="row">
            <div v-for="(berita, index) in jurusanItem.berita" :key="index" class="trending-item">
            <Trending :berita="berita" />
            </div>
          </div> -->
          <div class="row" v-if="jurusanItem.berita">
            <div
              class="trending-item"
              v-for="(berita, index) in jurusanItem.berita"
              :key="index"
            >
              <Trending :berita="berita" />
            </div>
          </div>
          <div class="row" v-else style="width: 100%">
            <div class="col-md-12 align-middle text-center">
              <h1><i class="icofont-worried"></i></h1>
              <span>Belum ada INFORMASI apapun</span>
            </div>
          </div>
        </div>

        <!-- <Trending />
        <Trending />
        <Trending /> -->
      </div>
      <!-- <div class="row justify-content-center text-center mb-5">
        <div class="col-md-5" data-aos="fade-up">
          <h2 class="section-heading">Layanan Kami</h2>
        </div>
      </div>

      <div class="row">
        <div
          class="col-md-4"
          data-aos="fade-up"
          data-aos-delay
          v-for="(post, index) in posts"
          :key="index"
        >
          <div class="feature-1 text-center">
            <router-link to="/layananitem">
              <div class="wrap-icon icon-1"> -->
      <!-- <span class="icon la la-globe"></span> -->
      <!-- <img
                  :src="urlImage + '/berita/' + post.berita.avatar"
                  v-if="post.berita.avatar"
                />
                <img :src="urlImage + '/anonymous.png'" v-else />
              </div>
            </router-link>
            <h3 class="mb-3">{{ post.berita.judul }}</h3>
            <p style="text-decoration: none">
              Cocok untuk kantor/ instansi/ sekolah, perusahan swasta, BUMN, dan lain-lain
            </p>
          </div>
        </div> -->
      <!-- <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
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
            <p>
              Layanan pembuatan video promosi, animasi, sampai publikasi ke media sosial
            </p>
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
        </div> -->
      <!-- </div> -->
    </div>
  </section>
</template>
<script>
import JGuruItem from "../../components/Guru/JurusanGuruItem.vue";
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
import Trending from "../../components/Trending/Trending.vue";
// import { component } from "vue/types/umd";

export default {
  components: { JGuruItem, Trending },
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
    }),
  },
  data() {
    return {
      gurus: {},
      jurusanItem: {},
      jurusans: {},
      sideMenu: true,
    };
  },
  mounted() {
    this.loadGurus();
    this.loadJurusans();
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    loadGurus() {
      this.setSpinner(true);
      Axios.get("gurus")
        .then((response) => {
          this.gurus = response.data;
          // console.log(gurus);
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
          this.jurusanItem = this.jurusans[0];
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

    viewJurusan(jurusan) {
      this.jurusanItem = jurusan;
      // this.hideMenu();
      this.$notify({
        group: "success",
        text: jurusan.nama,
        type: "success", //nilai lain, error dan success
      });
    },
    hideMenu() {
      if (this.sideMenu) {
        this.sideMenu = false;
      } else {
        this.sideMenu = true;
      }
    },
  },
};
</script>
