<template>
  <div>
    <!-- ======= Mobile Menu ======= -->
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
          <div class="col-6 col-md-3">
            <h1 class="mb-0 site-logo">
              <a href="/" class="mb-0">SMK Negeri 1 Mepanga</a>
            </h1>
          </div>

          <div class="col-12 col-md-9 d-none d-lg-block">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                <li class="active">
                  <router-link to="/">BERANDA</router-link>
                </li>
                <li>
                  <router-link to="/jurusan/viewer">JURUSAN</router-link>
                  <!-- <ul class="navbar-nav dropdown">
                    <li class="nav-item" v-for="(jurusan, index) in jurusans" :key="index">
                      <router-link to="/jurusan/viewer">{{jurusan.nama}}</router-link>
                    </li>
                    
                  </ul> -->
                </li>
                <!-- <li class="has-children"> -->
                <li>
                  <router-link to="/organisasi/viewer">ORGANISASI</router-link>
                  <!-- <a class="nav-link">ORGANISASI</a> -->

                  <!-- <ul class="dropdown">
                    <li class="nav-item">
                      <router-link to="/organisasi/osis">OSIS</router-link>
                    </li>
                    <li>
                      <router-link to="/organisasi/pramuka">Pramuka</router-link>
                    </li>
                    <li>
                      <router-link to="/organisasi/jujitsu">Jujitsu</router-link>
                    </li>
                    <li>
                      <router-link to="/organisasi/psht">PSHT</router-link>
                    </li>
                    <li>
                      <router-link to="/organisasi/multimedia">Multimedia</router-link>
                    </li>
                  </ul> -->
                </li>
                <li >
                  <!-- <a class="nav-link">INFO</a> -->
                  <router-link :to="'/berita/' + getNews.slug">INFORMASI</router-link>

                  <!-- <ul class="dropdown">
                    <li>
                      <router-link to="/berita">Artikel</router-link>
                    </li>

                    <li>
                      <router-link to="/galeri">Galeri Foto</router-link>
                    </li>

                    <hr />
                    <li>
                      <router-link to="/awards/siswa">Student of the month</router-link>
                    </li>
                    <li>
                      <router-link to="/awards/guru">Teacher of the year</router-link>
                    </li>
                  </ul> -->
                </li>

                <li class="has-children">
                  <a
                    class="nav-link"
                    id="akunDropdown"
                    aria-haspopup="true"
                    aria-expanded="true"
                    v-bind:class="{
                      'a-kecil': getUsers,
                    }"
                  >
                    <div v-if="getUsers">
                      <img
                        class="login-avatar"
                        :src="
                          getUsers.avatar
                            ? getUrl + '/users/' + getUsers.avatar
                            : getUrl + '/anonymous.png'
                        "
                        alt=""
                      />
                    </div>
                    <div v-else>ACCOUNT</div>
                  </a>

                  <ul class="dropdown" aria-labelledby="akunDropdown" v-if="!getUsers">
                    <li>
                      <router-link to="/entry/login">Login</router-link>
                    </li>
                  </ul>
                  <ul class="dropdown" v-else>
                    <li>
                      <a @click="logout()" class="dropdown-item"> Logout </a>
                    </li>
                    <hr />
                    <li>
                      <router-link to="/entry/berita">Berita</router-link>
                    </li>
                    <li>
                      <router-link to="/kategori">Kategori</router-link>
                    </li>
                    <hr>
                    <li>
                      <router-link to="/users">User</router-link>
                    </li>
                    <li>
                      <router-link to="/gurus">Guru</router-link>
                    </li>
                    <hr />
                    <li>
                      <router-link to="/jurusans">Jurusan</router-link>
                    </li>
                    <li>
                      <router-link to="/organisasi/entry">Organisasi Siswa</router-link>
                    </li>
                    <li>
                      <router-link to="/program/entry">Program Organisasi</router-link>
                    </li>
                    <li>
                      <router-link to="/sekolah">Identitas Sekolah</router-link>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>

          <div
            class="col-6 d-inline-block d-lg-none ml-md-0 py-3"
            style="position: relative; top: 3px"
          >
            <a
              href="#"
              class="burger site-menu-toggle js-menu-toggle"
              data-toggle="collapse"
              data-target="#main-navbar"
            >
              <span></span>
            </a>
          </div>
        </div>
      </div>
    </header>
  </div>
</template>

<script>
import Axios from "axios";
import { mapGetters } from "vuex";

export default {
  name: "navbar",
  props: ["app"],
  data() {
    return {
      jurusans: {},
    };
  },
  computed: {
    ...mapGetters({
      getUsers: "auth/user",
      getUrl: "constant/urlImage",
       getNews: "news/post",
    }),
  },
  mounted() {
    this.loadJurusan();
  },
  methods: {
    logout() {
      Axios.post("auth/logout")
        .then((response) => {
          this.$store.dispatch("auth/set", null);
          this.$router.push("/entry/login");
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, error dan success
          });
        });
    },
    loadJurusan() {
      Axios.get("jurusan/showAll")
        .then((response) => {
          this.jurusans = response.data;
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, error dan success
          });
        });
    },
  },
};
</script>
