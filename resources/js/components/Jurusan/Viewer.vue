<template>
  <div>
    <v-container class="pa-5">
      <v-layout class="d-flex d-sm-none text-center" justify-center>
        <v-img
          class="logo-latar"
          :src="'images/jurusan/' + jurusanItem.logo"
          v-if="jurusanItem.logo"
        ></v-img>
      </v-layout>
      <v-layout row>
        <v-flex xs12 sm8 md9>
          <v-card elevation="0" tile class="pa-3" color="#F5F5F5">
            <h3>{{ jurusanItem.nama }}</h3>

            <p class="caption">
              {{ jurusanItem.deskripsi }}
            </p>
            <h3 class="subtitle overline mt-5 mb-3" v-if="jurusanItem.guru">
              Guru Kejuruan:
            </h3>
            <GuruJurusan :gurus="jurusanItem.guru" />
          </v-card>
        </v-flex>
        <v-flex sm4 md3 class="d-none d-sm-flex justify-center pb-3">
          <v-img
            width="40"
            :src="'images/jurusan/' + jurusanItem.logo"
            v-if="jurusanItem.logo"
          ></v-img>
          <v-img
            width="40"
            src="/images/noimage-close.png"
            v-else
          ></v-img>
        </v-flex>
      </v-layout>
      <v-layout row class="d-none d-sm-flex">
        <v-flex xs12 sm4 md3 px-2 mb-3 v-for="(jurusan, index) in jurusans" :key="index">
          <v-card
            class="mx-auto"
            color="grey lighten-2"
            router
            :to="'/jurusan/viewer/' + jurusan.slug"
          >
            <v-list-item two-line>
              <v-list-item-content>
                <v-list-item-title class="overline font-weight-bold">{{
                  jurusan.nama
                }}</v-list-item-title>
                <v-list-item-subtitle class="caption font-weight-thin">{{
                  jurusan.kepanjangan
                }}</v-list-item-subtitle>
              </v-list-item-content>

              <v-list-item-avatar rounded color="purple lighten-5" elevation="3">
                <v-icon>mdi-eye-outline</v-icon>
              </v-list-item-avatar>
            </v-list-item>
          </v-card>
        </v-flex>
      </v-layout>
      <v-layout row mb-3 class="d-flex d-sm-none">
        <JurusanRandom :jurusans="jurusans" />
      </v-layout>
      <h1 class="subtitle overline mt-5 mb-3">Arsip Berita</h1>
      
      <BeritaArsip />
     
    </v-container>
  </div>
  
</template>
<script>
import JGuruItem from "../../components/Guru/JurusanGuruItem.vue";
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
import Trending from "../../components/Trending/Trending.vue";
// import { component } from "vue/types/umd";
import JurusanRandom from "./JurusanListView";
import BeritaArsip from "../Berita/BeritaArsip";
import GuruJurusan from "./GuruJurusan";
export default {
  components: { JGuruItem, Trending, JurusanRandom, BeritaArsip, GuruJurusan },
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
      propJurusan: "jurusan/jurusan",
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
    // this.init();
    // this.loadGurus();
    this.viewJurusan();
    this.loadJurusans();
  },
  watch: {
    $route(to, from) {
      this.viewJurusan();
    },
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    init() {
      if (this.propJurusan) {
        this.jurusanItem = this.propJurusan;
      }
    },
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
      // this.setSpinner(true);
      Axios.get("jurusan/getAll")
        .then((response) => {
          this.jurusans = response.data;
          // if (!this.jurusanItem.nama) {
          //   this.jurusanItem = this.jurusans[0];
          // }
          // this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "ERROR : " + error.message,
            type: "error", //nilai lain, error dan success
          });
          // this.setSpinner(false);
        });
    },
    
    viewJurusan() {
      let { slug } = this.$route.params;
      let url = "/jurusan/slug/" + slug;
      url = encodeURI(url);
      Axios.get(url)
        .then((response) => {
          this.jurusanItem = response.data.data;
          this.$vuetify.goTo(0)
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
<style>
.sticky {
  /* position: absolute; */
  top: 0;
}
.transparent {
  opacity: 0.15;
}
.logo-latar {
  opacity: 0.15;
  z-index: 1;
  position: absolute;
  width: 30%;
}
</style>
