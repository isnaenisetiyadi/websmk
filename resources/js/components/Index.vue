<template>
  <div>
    <v-container class="pa-5">
      <v-layout row>
        <v-flex xs12 sm6 md4 class="mb-2 px-1">
          <v-card color="#385F73" height="150" dark>
            <div class="d-flex flex-no-wrap justify-space-between">
              <div>
                <v-card-title class="headline">
                  <strong class="subtitle-1 font-weight-bold">
                    {{ sekolah.moto1 }}
                  </strong>
                </v-card-title>
                <v-card-subtitle class="subtitle">{{ sekolah.moto2 }}</v-card-subtitle>

                <v-card-actions>
                  <v-btn
                    class="ml-2 mt-5"
                    outlined
                    rounded
                    small
                    router
                    :to="'/berita/' + PostUtama.slug"
                  >
                    info
                  </v-btn>
                </v-card-actions>
              </div>
              <v-avatar
                class="ma-3"
                size="100"
                tile
                outlined
                elevation="2"
                v-if="sekolah.logo"
              >
                <v-img :src="'images/sekolah/' + sekolah.logo"></v-img>
              </v-avatar>
            </div>
            <!-- </v-img> -->
          </v-card>
        </v-flex>
        <v-flex xs12 sm6 md4 class="mb-2 px-1">
          <v-card color="#1F7087" height="150" v-if="sekolah.avatar">
            <v-img
              dark
              class="white--text align-end"
              height="150"
              :src="'images/sekolah/' + sekolah.avatar"
            >
             
              <div class="transparent-background">
                <v-card-text>
                  {{ sekolah.visi }}
                </v-card-text>
              </div>
            </v-img>
          </v-card>
        </v-flex>
        <v-flex xs12 sm6 md4 class="mb-2 px-1">
          <v-card color="#1F7087" dark height="150">
            <v-card-title class="py-1">
              <v-icon large left color="info"> mdi-circle-multiple </v-icon>
              <span class="title font-weight-light overline">Misi Sekolah</span>
            </v-card-title>
            <v-card-text>
              <v-carousel
                cycle
                height="100"
                hide-delimiter-background
                show-arrows-on-hover
              >
                <v-carousel-item v-for="(misi, index) in sekolah.misi" :key="index">
                  <v-row class="fill-height px-4" align="center" justify="center">
                    <div class="caption">{{ misi.text }}</div>
                  </v-row>
                </v-carousel-item>
              </v-carousel>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
      <v-layout row>
        <v-flex xs12 sm4 class="mb-2 px-1">
          <BeritaRandom />
        </v-flex>
        <v-flex xs12 sm8 class="mb-2 px-1">
          <BeritaUtama />
        </v-flex>
      </v-layout>
      <v-divider></v-divider>
      <h1 class="subtitle overline mt-5 mb-3">Arsip Berita</h1>
      <!-- <v-subheader>Arsip Berita</v-subheader> -->
      <!-- <v-layout row> -->
      <BeritaArsip />
      <!-- </v-layout> -->
    </v-container>
  </div>
</template>

<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";

export default {
  components: {
    Trending: () => import("../components/Trending/Trending.vue"),
    // KoplakItem: () => import("components/KoplakItem.vue"),
    BeritaRandom: () => import("./Berita/BeritaListView.vue"),
    BeritaUtama: () => import("./Berita/BeritaUtamaView.vue"),
    BeritaArsip: () => import("./Berita/BeritaArsip.vue"),
  },
  data() {
    return {
      PostUtama: {},
      kategoris: {},
      sekolah: {},
      jurusans: {},
      colors: [
        "indigo",
        "warning",
        "pink darken-2",
        "red lighten-1",
        "deep-purple accent-4",
      ],
      slides: ["First", "Second", "Third", "Fourth", "Fifth"],
    };
  },
  mounted() {
    this.loadKategoris();
    this.loadSekolah();
    this.loadJurusans();
    this.showPostUtama();
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
    showPostUtama() {
      Axios.get("post/showPostUtama")
        .then((response) => {
          this.PostUtama = response.data.data;
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
<style>
.transparent-background {
  background-color: rgba(0, 0, 0, 0.445);
}
</style>
