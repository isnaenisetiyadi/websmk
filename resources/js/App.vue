<template>
  <v-app color="grey lighten-4">
    <!-- <Spinner v-if="showSpinner" /> -->
    <notifications group="auth" position="top center" />
    <notifications group="success" position="top center" />
    <notifications group="error" position="top center" />
    <notifications group="alert" position="top center" />
    <vue-confirm-dialog></vue-confirm-dialog>
    <Navbar />
    <v-main class="grey lighten-4 my-2">
      <router-view></router-view>
    </v-main>
    <Footer :app="this"></Footer>
    <v-btn
      v-scroll="onScroll"
      v-show="fab"
      fab
      dark
      fixed
      bottom
      right
      color="primary"
      @click="toTop"
    >
      <v-icon>mdi-chevron-up</v-icon>
    </v-btn>
  </v-app>
</template>

<script>
import Navbar from "./components/Layouts/Navbar";
import Footer from "./components/Layouts/Footer";
import TambahPendidikan from "./components/Pendidikan/Tambah";
import Spinner from "./components/Spinner.vue";
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  name: "App",
  data() {
    return {
      fab: false,
    };
  },
  components: {
    Navbar,
    Footer,
    TambahPendidikan,
    Spinner,
  },
  computed: {
    ...mapGetters({
      getNews: "news/post",
      showDialogTambah: "pendidikanDialog/showDialog",
      showSpinner: "spinner/loading",
    }),
  },
  mounted() {
    this.init();
    // this.setUrlImage("");
    // this.setUrlImage("http://200.77.10.3:8000/images"); //jaringan rumah
    this.setUrlImage("");
    this.setUrlImage("http://127.0.0.1:8000/images"); //lokal
    // this.setUrlImage("");
    // this.setUrlImage("http://www.smkn1mepanga.sch.id/images"); //hosting
    this.setPendidikanDialog(false);
    this.$refs.isAdd = true;
  },
  methods: {
    init() {
      Axios.get("post/hits")
        .then((response) => {
          // if (response.data.data.length>0) {
          this.setNews({});
          if (response.data.data) {
            this.setNews(response.data.data);
          }

          // }
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
    ...mapActions({
      setNews: "news/set",
      setUrlImage: "constant/set",
      setPendidikanDialog: "pendidikanDialog/set",
    }),
    onScroll(e) {
      if (typeof window === "undefined") return;
      const top = window.pageYOffset || e.target.scrollTop || 0;
      this.fab = top > 20;
    },
    toTop() {
      this.$vuetify.goTo(0);
    },
  },
};
</script>
