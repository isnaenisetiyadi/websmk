<template>
  <v-container>
    <h1 class="subtitle overline mt-1 mb-2">Berita</h1>
    <BeritaAdd />
    <v-layout row class="px-1">
      <v-flex xs12 sm6 md4 class="pa-2" v-for="(berita, index) in beritas.data" :key="index">
        <BeritaList :beritaParent="berita" @isiBerita="isiBerita" />
      </v-flex>
     
    </v-layout>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Axios from "axios";
import MultiSelect from "@vueform/multiselect/dist/multiselect.vue2.js";
import BeritaList from "./BeritaList";
import BeritaAdd from "./BeritaAdd";
export default {
  components: {
    // VueEditor,
    BeritaList: () => import("./BeritaList"),
    MultiSelect,
    BeritaList,
    BeritaAdd
  },
  data() {
    return {
      id: null,
      judul: "",
      deskripsi: "",
      kategori_id: "",
      konten: "",
      add: false,
      kategoris: {},
      beritas: {},
      editorOption: {
        debug: "info",
        placeholder: "Type your post...",
        theme: "snow",
        height: "100px",
      },

      // data untuk multiselect jurusan
      jurusanDipilih: [],
      jurusans: {},

      // data untuk multiselect jurusan
      organisasiDipilih: [],
      organisasis: {},

      // data image/avatar
      image: "",
      avatar: null,

      // data untuk searching judul
      judulKeyword: "",

      // untuk options user tanpa guest
      users: {},
      user_id: "",
      judulKeyword: "",
      page:"",
    };
  },
  mounted() {
    this.init();
  },
  computed: {
    ...mapGetters({
      // getUser: "auth/user",
      urlImage: "constant/urlImage",
      getUsers: "auth/user",
    }),
  },
  watch: {
    judulKeyword: function () {
      if (!this.judulKeyword) {
        this.isiBerita();
      }
    },
    user_id: function () {
      this.isiBerita();
    },
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    onAdd() {
      this.add = true;
    },
    onCancel() {
      this.add = false;
      this.kosongkanData();
    },
    loadUserNoGuest() {
      this.setSpinner(true);
      Axios.get("auth/noGuest")
        .then((response) => {
          this.users = response.data.data;
          // console.log(this.users);
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
    onSave() {
      // const data = {
      //   judul: this.judul,
      //   user_id: this.$store.state.auth.user.id, // percobaan kode
      //   kategori_id: this.kategori_id,
      //   deskripsi: this.deskripsi,
      //   konten: this.konten,
      // };

      let encodedJurusanDipilih = JSON.stringify(this.jurusanDipilih);
      let encodedOrganisasiDipilih = JSON.stringify(this.organisasiDipilih);
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("judul", this.judul);
      dataQ.set("user_id", this.$store.state.auth.user.id);
      dataQ.set("kategori_id", this.kategori_id);
      dataQ.set("deskripsi", this.deskripsi);
      dataQ.set("konten", this.konten);
      dataQ.set("jurusans", encodedJurusanDipilih);
      dataQ.set("organisasis", encodedOrganisasiDipilih);
      dataQ.set("avatar", this.avatar);

      if (this.id === null) {
        this.setSpinner(true);
        Axios.post("auth/berita/store", dataQ)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: response.data.message,
              type: "success", //nilai lain, error dan success
            });
            this.add = false;
            this.setSpinner(false);
            this.isiBerita();
            this.kosongkanData();
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Gagal",
              text: error.message,
              type: "error", //nilai lain, error dan success
            });
            this.setSpinner(false);
          });
      } else {
        this.setSpinner(true);
        Axios.post("auth/berita/update/" + this.id, dataQ)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: response.data.message,
              type: "success", //nilai lain, error dan success
            });
            this.add = false;
            this.setSpinner(false);
            this.kosongkanData();
            this.isiBerita();
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Gagal",
              text: error.message,
              type: "error", //nilai lain, error dan success
            });
            this.setSpinner(false);
          });
      }
    },
    init() {
      if (this.getUsers.role === "ADMIN") {
        this.user_id = this.getUsers.id;
      }
      this.isiKategori();
      this.loadUserNoGuest();
      this.isiBerita();
      this.isiJurusan();
      this.isiOrganisasi();
    },
    validasiKeyboard: function (e) {
      if (e.keyCode === 13) {
        this.isiBerita();
      }
    },
    isiKategori() {
      this.setSpinner(true);
      Axios.get("kategoris")
        .then((response) => {
          this.kategoris = response.data.data;
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.data,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
    kosongkanData() {
      this.id = null;
      this.judul = "";
      this.deskripsi = "";
      this.kategori_id = "";
      this.konten = "";
      this.image = "";
      this.avatar = null;

      // data untuk multiselect jurusan dan organisasi
      this.jurusanDipilih = [];
      this.organisasiDipilih = [];
    },
    isiBerita(page) {
      // const data = {
      //   user_id: this.user_id,
      //   judul: this.judulKeyword
      // };

      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("user_id", this.user_id);
      dataQ.set("judul", this.judulKeyword);

      this.setSpinner(true);
      Axios.post("auth/berita/showBySearch?page=" + page, dataQ)
        .then((response) => {
          this.beritas = response.data;
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, warn, error dan success
          });
          this.setSpinner(false);
        });
    },
    isiJurusan() {
      // this.setSpinner(true);
      Axios.get("jurusan/getAll")
        .then((response) => {
          this.jurusans = response.data;
          // console.log(this.jurusans);
          // this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.data,
            type: "error", //nilai lain, error dan success
          });
          // this.setSpinner(false);
        });
    },
    isiOrganisasi() {
      // this.setSpinner(true);
      Axios.get("organisasi/getAll")
        .then((response) => {
          this.organisasis = response.data;
          // this.setSpinner(false);
          // console.log(this.jurusans);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.data,
            type: "error", //nilai lain, error dan success
          });
          // this.setSpinner(false);
        });
    },

    onDeleteJurusan(value) {
      // console.log(value);
      // console.log(value);
      if (this.id) {
        const data = {
          berita_id: this.id,
          jurusan_id: value,
        };
        this.setSpinner(true);
        Axios.post("auth/berita/excludeJurusan", data)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: response.data.message,
              type: "warn", //nilai lain, error dan success
            });
            this.setSpinner(false);
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Gagal",
              text: error.message,
              type: "error", //nilai lain, error dan success
            });
            this.setSpinner(false);
          });
      }
    },
    onDeleteOrganisasi(value) {
      // console.log(value);
      // console.log(value);
      if (this.id) {
        const data = {
          berita_id: this.id,
          organisasi_id: value,
        };
        this.setSpinner(true);
        Axios.post("auth/berita/excludeOrganisasi", data)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: response.data.message,
              type: "warn", //nilai lain, error dan success
            });
            this.setSpinner(false);
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Gagal",
              text: error.message,
              type: "error", //nilai lain, error dan success
            });
            this.setSpinner(false);
          });
      }
    },
    onView(id) {
      this.id = id;
      this.setSpinner(true);
      Axios.get("auth/berita/show/" + id)
        .then((response) => {
          this.judul = response.data.data.judul;
          this.kategori_id = response.data.data.kategori_id;
          this.deskripsi = response.data.data.deskripsi;
          this.konten = response.data.data.konten;
          this.image = response.data.data.avatar;
          this.avatar = response.data.data.avatar;

          let jd = response.data.data.jurusan;
          let og = response.data.data.organisasi;

          // console.log(jd)
          this.jurusanDipilih = [];
          jd.forEach((jur) => {
            // console.log(jur.id)
            this.jurusanDipilih.push(jur.id);
          });
          this.organisasiDipilih = [];
          og.forEach((element) => {
            this.organisasiDipilih.push(element.id);
          });
          this.add = true;
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
          this.kosongkanData();
        });
    },
    onDelete(id) {
      this.$confirm({
        message: "Yakin akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            this.setSpinner(true);
            Axios.post("auth/berita/destroy/" + id)
              .then((response) => {
                this.isiBerita();
                // console.log(response.data);
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: "Satu berita: " + response.data.data.judul + " sudah dihapus",
                  type: "warn", //nilai lain, error dan success
                });
                this.setSpinner(false);
              })
              .catch((error) => {
                this.$notify({
                  group: "error",
                  title: "Gagal",
                  text: error.message,
                  type: "error", //nilai lain, error dan success
                });
                this.setSpinner(false);
              });
          }
        },
      });
    },
    onPost(id) {
      const data = {
        user_id: this.$store.state.auth.user.id,
        berita_id: id,
        berita_judul: this.judul
      };
      this.setSpinner(true);
      Axios.post("auth/post/store", data)
        .then((response) => {
          if (this.add) {
            this.add = false;
          }
          this.$notify({
            group: "success",
            title: "Sukses",
            text: response.data.message,
            type: "success", //nilai lain, error dan success
          });
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
    // METHOD UNTUK GAMBAR
    getImage(image) {
      if (this.avatar) {
        if (this.avatar != "" && this.avatar.length > 0 && this.avatar != null) {
          return this.urlImage + "/berita/" + image;
        } else {
          return image;
        }
      }
    },

    onImageChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      this.avatar = files[0];
      if (files.length) {
        return this.createImage(files[0]);
      }
    },
    createImage(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;
      reader.onload = (e) => {
        vm.image = e.target.result;
        // this.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    removeImage() {
      // console.log(this.image);
      this.image = "";
      this.avatar = null;
    },
    onRejected(rejectedEntries) {
      this.$notify({
        group: "error",
        title: "Gagal",
        text: `${rejectedEntries.length} file(s) did not pass validation constraints`,
        type: "error", //nilai lain, error dan success
      });
    },
    // AKHIR METHOD GAMBAR
  },
};
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
<style lang="scss"></style>
