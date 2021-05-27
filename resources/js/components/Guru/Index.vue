<template>
  <div>
    <v-container class="pa-5">
     
      <h1 class="subtitle overline mb-3">Guru dan Tenaga Kependidikan</h1>
      <Guru :gurus="gurus" />
      
    </v-container>
  </div>
</template>
<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
import Trending from "../Trending/Trending.vue";
import BeritaArsip from "../Berita/BeritaArsip";
import Guru from "../Jurusan/GuruJurusan";
export default {
  components: { Trending, BeritaArsip, Guru },
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
      propJurusan: "jurusan/jurusan",
    }),
  },
  data() {
    return {
      gurus: {},
      guruItem: {},
    };
  },
  mounted() {
    // this.viewGuru();
    this.loadGurus();
  },
  // watch: {
  //   $route(to, from) {
  //     this.viewGuru();
  //   },
  // },
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
      Axios.get("guru/showAll")
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
    // loadGurus() {
    //   // this.setSpinner(true);
    //   Axios.get("jurusan/getAll")
    //     .then((response) => {
    //       this.jurusans = response.data;
    //       // if (!this.jurusanItem.nama) {
    //       //   this.jurusanItem = this.jurusans[0];
    //       // }
    //       // this.setSpinner(false);
    //     })
    //     .catch((error) => {
    //       this.$notify({
    //         group: "error",
    //         title: "Gagal",
    //         text: "ERROR : " + error.message,
    //         type: "error", //nilai lain, error dan success
    //       });
    //       // this.setSpinner(false);
    //     });
    // },

    viewGuru() {
      let { slug } = this.$route.params;
      let url = "/guru/slug/" + slug;
      url = encodeURI(url);
      Axios.get(url)
        .then((response) => {
          this.guruItem = response.data.data;
          this.$vuetify.goTo(0);
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
