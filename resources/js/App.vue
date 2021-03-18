<template>
  <div>
    <Spinner v-if="showSpinner"/>
    <notifications group="auth" position="top left" />
    <notifications group="success" position="top left" />
    <notifications group="error" position="top left" />
    <notifications group="alert" position="top left" />
    <vue-confirm-dialog></vue-confirm-dialog>
    <Navbar :app="this"></Navbar>
    <TambahPendidikan v-if="showDialogTambah" ref="isAdd" />

    <router-view />
    <!-- <button @click="init()" class="btn btn-danger">Uji Init</button> -->
  <!-- <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a> -->
    <Footer :app="this"></Footer>
  </div>
</template>

<script>
import Navbar from "./components/Layouts/Navbar";
import Footer from "./components/Layouts/Footer";
import TambahPendidikan from "./components/Pendidikan/Tambah";
import Spinner from "./components/Spinner.vue";
import Axios from "axios";
// import { mapActions } from 'vuex';
import { mapActions, mapGetters } from "vuex";
// mapActions
export default {
  name: "app",
  data() {
    return {};
  },
  components: {
    Navbar,
    Footer,
    TambahPendidikan,
    Spinner
  },
  computed: {
    ...mapGetters({
      getNews: "news/post",
      showDialogTambah: "pendidikanDialog/showDialog",
      showSpinner: "spinner/loading"
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
  },
};
</script>
