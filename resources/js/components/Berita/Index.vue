<template>
  <section class="section">
    <div class="container-fluid banner" height="50px"></div>
    <section class="site-section mb-4">
      <div class="container">
        <div class="row">
          <div class="col-md-8 blog-content">
            <div>
              <div v-html="getNews.berita.konten" class="ql-editor"></div>
            </div>
            <hr />
            <div class="meta">
              <i class="icofont-ui-calendar"></i> {{ getNews.created_at | formatDate }} |
              <i class="icofont-ui-clock"></i> {{ getNews.created_at | formatTime }}
            </div>
            <span> <i class="icofont-ui-edit"></i> {{ getNews.berita.user.name }}</span>
            <span> <i class="icofont-eye-alt"></i> {{ getNews.views }}</span>
            <!-- <div class="pt-5">
              <p>
                Kategori : <a href="#">Design</a>, <a href="#">Events</a> Tags:
                <a href="#">#html</a>, <a href="#">#trends</a>
              </p>
            </div> -->

            <!-- DIsini tempat komponen komentar -->
            <komentar-berita
              :post="getNews.berita"
              :komenDariParent="loadKomentarChild"
            />
            <div class="comment-form-wrap pt-5">
              <h3 class="mb-5">Ikut berkomentar</h3>
              <form action="#" class="">
                <!-- <div class="form-group">
          <label for="name">Name *</label>
          <input type="text" class="form-control" id="name" />
        </div> -->
                <!-- <div class="form-group">
          <label for="email">Email *</label>
          <input type="email" class="form-control" id="email" />
        </div> -->
                <!-- <div class="form-group">
          <label for="website">Website</label>
          <input type="url" class="form-control" id="website" />
        </div> -->

                <div class="form-group">
                  <label for="message">Pesan</label>
                  <textarea
                    name=""
                    id="message"
                    v-model="komentar"
                    cols="30"
                    rows="10"
                    class="form-control"
                  ></textarea>
                </div>
                <div class="form-group">
                  <input
                    @click="saveKomen()"
                    type="button"
                    value="Kirim Komentar"
                    class="btn btn-primary"
                  />
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-4 sidebar">
            <!-- <div class="sidebar-box">
              <form action="#" class="search-form">
                <div class="form-group">
                  <span class="icon fa fa-search"></span>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Ketik kata kunci"
                  />
                </div>
              </form>
            </div> -->

            <kategori-berita />

            <!-- <div class="sidebar-box">
              <img
                src="img/person_1.jpg"
                alt="Image placeholder"
                class="img-fluid mb-4"
              />
              <h3>Student of the month</h3>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus itaque,
                autem necessitatibus voluptate quod mollitia delectus aut, sunt placeat
                nam vero culpa sapiente consectetur similique, inventore eos fugit
                cupiditate numquam!
              </p>
              <p><a href="#" class="btn btn-primary btn-sm">Lebih Banyak</a></p>
            </div>

            <div class="sidebar-box">
              <h3>Paragraph</h3>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus itaque,
                autem necessitatibus voluptate quod mollitia delectus aut, sunt placeat
                nam vero culpa sapiente consectetur similique, inventore eos fugit
                cupiditate numquam!
              </p>
            </div> -->
          </div>
        </div>
      </div>
    </section>
    <div class="container mb-5" style="margin-bottom:50px;">
      <div class="row trending-frame" v-for="(kategori, index) in kategoris" :key="index">
        <div class="caption text-center">{{ kategori.nama }} TERBARU :</div>
        <div class="col-md-12">
          <div class="row">
            <div
              class="trending-item"
              v-for="(berita, index) in kategori.berita"
              :key="index"
            >
              <Trending :berita="berita" />
            </div>
          </div>
        </div>
        <!-- <Trending />
          <Trending />
          <Trending /> -->
      </div>
    </div>
    <!-- <div class="container">
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
            <p style="text-decoration: none">
              Cocok untuk kantor/ instansi/ sekolah, perusahan swasta, BUMN, dan lain-lain
            </p>
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
        </div>
      </div>
    </div> -->
  </section>
</template>

<script>
import Axios from "axios";
import KategoriBerita from "./components/KategoriBerita.vue";
// import KomentarBerita from "./components/KomentarBerita";
import { mapGetters } from "vuex";
import KomentarBerita from "./components/KomentarBerita.vue";
import Trending from "../../components/Trending/Trending.vue";

export default {
  components: { KategoriBerita, KomentarBerita, Trending },
  computed: {
    ...mapGetters({
      getNews: "news/post",
      getUsers: "auth/user",
    }),
  },
  data() {
    return {
      berita: {},
      komentar: "",
      loadKomentarChild: "",
      kategoris: {},
    };
  },
  mounted() {
    // this.init();
    // this.loadKategori();
    this.loadKategoris();
  },
  watch: {
    getNews: function () {
      if (this.loadKomentarChild) {
        this.loadKomentarChild = "";
      } else {
        this.loadKomentarChild = "Load Komenl";
      }
    },
  },
  methods: {
    saveKomen() {
      var userId = null;
      if (this.getUsers) {
        userId = this.getUsers.id;
      }
      const data = {
        user_id: userId,
        berita_id: this.getNews.berita.id,
        komentar_id: null,
        komen: this.komentar,
        kategoris: {},
      };
      Axios.post("komentar/store", data)
        .then((response) => {
          // console.log(response.data);
          // this.loadKomentar();
          // this.KomentarBerita.$emit('loadKomentar');
          if (this.loadKomentarChild) {
            this.loadKomentarChild = "";
          } else {
            this.loadKomentarChild = "Load Komenl";
          }
          this.komentar = "";
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Komentar sudah terkirim (" + response.data.message + ")",
            type: "success", //nilai lain, error dan success
          });
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
    // init() {
    //   Axios.get("auth/berita/show/4")
    //     .then((response) => {
    //       this.berita = response.data.data;
    //       // this.$notify({
    //       //   group: "success",
    //       //   title: "Sukses",
    //       //   text: "SUKSES : " + response.data.message,
    //       //   type: "success", //nilai lain, error dan success
    //       // });
    //     })
    //     .catch((error) => {
    //       this.$notify({
    //         group: "error",
    //         title: "Gagal",
    //         text: "ERROR : " + error.message,
    //         type: "error", //nilai lain, error dan success
    //       });
    //     });
    // },
    // loadKategori() {
    //   Axios.get("kategoris")
    //     .then((response) => {
    //       this.kategoris = response.data.data;
    //       // console.log(this.kategoris);
    //     })
    //     .catch((error) => {
    //       console.log(error.message);
    //     });
    // },
  },
};
</script>
