<template>
  <div class="text-center">
    <v-btn plain dark @click="sheet = !sheet">
      <v-icon>mdi-plus</v-icon>
      <!-- <span class="caption">Berkomentar</span> -->
    </v-btn>
    <v-bottom-sheet v-model="sheet" class="primary" hide-overlay>
      <v-sheet>
        <v-toolbar dark color="info">
          <v-btn icon dark @click="sheet = !sheet">
            <v-icon x-large>mdi-menu-down</v-icon>
          </v-btn>
          <h1 class="overline">Tambah Pendidikan</h1>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn plain @click="onSave()" :disabled="!jenjang">
              <v-icon small>mdi-content-save</v-icon>
              <span>Simpan</span>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-container>
          <v-layout row class="ma-3" justify-center>
            <v-flex xs12 sm6 class="pa-2">
              <v-text-field label="Jenjang" color="info" v-model="jenjang">
              </v-text-field>
              <v-text-field label="Nama Sekolah" color="info" v-model="sekolah">
              </v-text-field>
            </v-flex>
            <v-flex xs12 sm6 class="pa-2">
              <v-text-field label="Tahun Masuk" color="info" v-model="tahun_masuk">
              </v-text-field>
              <v-text-field label="Tahun Lulus" color="info" v-model="tahun_lulus">
              </v-text-field>
            </v-flex>
          </v-layout>
        </v-container>
      </v-sheet>
    </v-bottom-sheet>
  </div>
</template>
<script>
import Axios from "axios";
import UploadAvatar from "vue-upload-drop-images";
export default {
  props: ["guru"],
  data() {
    return {
      sheet: false,

      jenjang: "",
      sekolah: "",
      tahun_masuk: "",
      tahun_lulus: "",

      role: {
        required: [(value) => !!value || "Harus diisi."],
        email: [
          (value) => {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return pattern.test(value) || "e-mail tidak valid";
          },
        ],
        avatar: [
          (value) =>
            !value || value.size < 500000 || "Ukuran file tidak boleh lebih dari 2 MB!",
        ],
      },
    };
  },
  components: { UploadAvatar },
  mounted() {},
  methods: {
    rubahAvatar(files) {
      //   console.log(files[0]);
      if (files) {
        this.avatar = files[0];
      } else {
        this.avatar = null;
      }
      //   console.log(this.avatar);
    },
    onSave() {
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("user_id", this.$store.state.auth.user.id);
      dataQ.set("guru_id", this.guru.id);
      dataQ.set("jenjang", this.jenjang);
      dataQ.set("sekolah", this.sekolah);
      dataQ.set("tahun_masuk", this.tahun_masuk);
      dataQ.set("tahun_lulus", this.tahun_lulus);

      // this.setSpinner(true);
      Axios.post("pendidikan/store", dataQ)
        .then((response) => {
          this.$notify({
            group: "success",
            title: "Sukses",
            text: response.data.message,
            type: "success", //nilai lain, error dan success
          });
          this.sheet = false;
          // this.setSpinner(false);
          this.$emit("isiGuruLagi");
          this.kosongkanData();
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, error dan success
          });
          // this.setSpinner(false);
        });
    },
   
    kosongkanData() {
      this.jenjang = "";
      this.sekolah = "";
      this.tahun_masuk = "";
      this.tahun_lulus = "";
    },
  },
};
</script>
