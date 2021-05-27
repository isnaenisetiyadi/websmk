<template>
  <v-container fluid>
    <v-toolbar dark color="warning">
      <!-- <v-btn icon dark @click="dialog = false"> -->
      <!-- <v-icon class="mr-3">mdi-chair-school</v-icon> -->
      <v-icon class="mr-3">mdi-pencil-outline</v-icon>
      <!-- </v-btn> -->
      <v-toolbar-title class="subtitle-1">Data Sekolah</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-items>
        <v-btn plain @click="onSave()" :disabled="!nama">
          <v-icon small>mdi-content-save</v-icon>
          <span>Simpan</span>
        </v-btn>
      </v-toolbar-items>
    </v-toolbar>
    <!-- <h1 class="subtitle overline mt-1 mb-2">Data Sekolah</h1> -->
    <v-container>
      <v-layout row>
        <v-flex xs12 sm6 md4 class="pa-3">
          <v-text-field label="Nama Sekolah" color="info" v-model="nama"> </v-text-field>
          <v-text-field label="Email" color="info" v-model="email"> </v-text-field>
          <v-textarea label="Alamat" v-model="alamat" color="info"></v-textarea>
          <v-select
            :items="gurus"
            v-model="guru_id"
            item-value="id"
            item-text="nama"
            label="Pilih Kepala Sekolah"
            color="info"
            v-if="gurus"
          ></v-select>
        </v-flex>
        <v-flex xs12 sm6 md4 class="pa-3">
          <v-textarea label="Moto 1" v-model="moto1" color="info"></v-textarea>
          <v-textarea label="Moto 2" v-model="moto2" color="info"></v-textarea>
        </v-flex>
        <v-flex xs12 sm6 md4 class="pa-3">
          <v-textarea label="Visi" v-model="visi" color="info"></v-textarea>
        </v-flex>
        <v-flex xs12 sm6 md4 class="pa-3">
          <v-card>

          <v-card-actions class="py-0 my-0 info">
            <v-btn color="white darken-1" text @click="show = !show"> Misi Sekolah </v-btn>
            <v-spacer></v-spacer>
            <!-- <v-btn icon v-show="show">
              <v-icon>mdi-plus</v-icon>
            </v-btn> -->
            <MisiAdd @loadSekolah="loadSekolah" v-show="show"/>
            <v-btn icon @click="show = !show">
              <v-icon>{{ show ? "mdi-chevron-up" : "mdi-chevron-down" }}</v-icon>
            </v-btn>
          </v-card-actions>

          <v-expand-transition>
            <div v-show="show">
              <v-list>
                <div v-for="misi in sekolah.misi" :key="misi.index">
                  <v-divider v-show="misi.index" inset></v-divider>
                  <MisiItem :misiParent="misi" @loadSekolah="loadSekolah" />
                </div>
              </v-list>
            </div>
          </v-expand-transition>
          </v-card>
          
        </v-flex>
      </v-layout>
      <v-layout row>
        <v-flex xs12 sm4 class="pa-3">
          <h1 class="subtitle overline mt-1 mb-2">Logo Sekolah</h1>
          <v-card>
            <v-img
              :src="'images/sekolah/' + sekolah.logo"
              v-if="logorender"
              class="text-center pa-2"
            >
              <v-btn fab class="error" @click="hapusLogo()">
                <v-icon>mdi-delete-outline</v-icon>
              </v-btn>
            </v-img>
            <UploadLogo
              :max="1"
              fileError="Jenis file tidak didukung"
              uploadMsg="Tab atau Klik untuk memilih file"
              @change="rubahLogo"
              v-else
            />
          </v-card>
        </v-flex>
        <v-flex xs12 sm8 class="pa-3">
          <h1 class="subtitle overline mt-1 mb-2">Latar Sekolah</h1>
          <v-card>
            <v-img
              :src="'images/sekolah/' + sekolah.avatar"
              v-if="avatarrender"
              class="text-center pa-2"
            >
              <v-btn fab class="error" @click="hapusAvatar()">
                <v-icon>mdi-delete-outline</v-icon>
              </v-btn>
            </v-img>
            <UploadAvatar
              :max="1"
              fileError="Jenis file tidak didukung"
              uploadMsg="Tab atau Klik untuk memilih file"
              @change="rubahAvatar"
              v-else
            />
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
    <v-layout class="d-flex d-sm-none">
      <v-toolbar dark color="warning">
        <!-- <v-btn icon dark @click="dialog = false"> -->
        <!-- <v-icon class="mr-3">mdi-chair-school</v-icon> -->
        <v-icon class="mr-3">mdi-pencil-outline</v-icon>
        <!-- </v-btn> -->
        <v-toolbar-title class="subtitle-1">Data Sekolah</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn plain @click="onSave()" :disabled="!nama">
            <v-icon small>mdi-content-save</v-icon>
            <span>Simpan</span>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
    </v-layout>
  </v-container>
  <!-- <section class="section" style="margin-bottom: 50px">
    <div class="container-fluid banner" height="50px"></div>
    <div class="container mb-5">
      <h5>Data Sekolah</h5>
      <hr />
      <div class="row mb-5">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" v-model="nama" />
              </div>
              <div class="form-group">
                <label for="nama">Kepala Sekolah</label>
                <select class="form-control" v-model="guru_id">
                  <option selected value="">Pilih...</option>
                  <option
                    v-for="(guru, index) in gurus"
                    :key="index"
                    v-bind:value="guru.id"
                  >
                    {{ guru.nama }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label for="nama">Alamat</label>
                <input type="text" class="form-control" v-model="alamat" />
              </div>
              <div class="form-group">
                <label for="nama">Email</label>
                <input type="email" class="form-control" v-model="email" />
              </div>
              <div class="form-group">
                <label for="nama">Visi</label>
                <textarea type="email" v-model="visi" class="form-control"></textarea>
              </div>
            </div>
            <div class="col-md-6 mb-5">
              <div class="form-group">
                <label for="nama">Moto 1</label>
                <textarea type="email" v-model="moto1" class="form-control"></textarea>
              </div>
              <div class="form-group">
                <label for="nama">Moto 2</label>
                <textarea type="email" v-model="moto2" class="form-control"></textarea>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama">Logo Sekolah</label>
                    <div v-if="!logo">
                      <input
                        @change="onImageLogoChange"
                        type="file"
                        name="logo"
                        multiple
                        accept=".jpg, image/*"
                        @rejected="onRejected"
                      />
                    </div>
                    <div v-else class="m-lg">
                      <img :src="getImageLogo(logo)" style="width: 100%" alt="" />
                      <div class="absolute-bottom-guru text-subtitle1 text-center">
                        <button @click="removeLogo" class="button-image">
                          <i class="icofont-ui-delete"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama">Avatar</label>
                    <div v-if="!avatar">
                      <input
                        @change="onImageAvatarChange"
                        type="file"
                        name="avatar"
                        multiple
                        accept=".jpg, image/*"
                        @rejected="onRejected"
                      />
                    </div>
                    <div v-else class="m-lg">
                      <img :src="getImageAvatar(avatar)" style="width: 100%" alt="" />
                      <div class="absolute-bottom-guru text-subtitle1 text-center">
                        <button @click="removeAvatar" class="button-image">
                          <i class="icofont-ui-delete"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <hr />
          <button @click="onSave()" class="btn btn-success">Simpan</button>
          <hr />
        </div>
      </div>
      <div class="row mb-5">
        <div class="col-md-12">
          <h5>Misi Sekolah</h5>
          <hr />
          <div style="width: 100%">
            <div class="list-group">
              <MisiItem v-for="(misi, index) in sekolah.misi" :key="index" :misi="misi" />
              <MisiAdd v-if="kategoriAdd" />
              <button
                @click="onAdd()"
                class="btn btn-outline-primary"
                type="button"
                v-else
              >
                <i class="icofont-plus"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
</template>
<script>
import MisiItem from "../../components/Sekolah/MisiItem.vue";
import MisiAdd from "../../components/Sekolah/MisiAdd.vue";
import UploadLogo from "vue-upload-drop-images";
import UploadAvatar from "vue-upload-drop-images";
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  components: { MisiItem, MisiAdd, UploadLogo, UploadAvatar },
  data() {
    return {
      kategoriAdd: false,
      kategoris: {},
      gurus: {},

      // sekolah_id: "",
      sekolah: {},
      guru_id: [],
      nama: "",
      alamat: "",
      email: "",
      visi: "",
      moto1: "",
      moto2: "",

      logo: undefined,
      logorender: "",
      avatar: undefined,
      avatarrender: "",

      show: false,

      // ROLE
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
  mounted() {
    this.loadKategoris();
    this.loadSekolah();
    this.loadGurus();
  },
  computed: {
    ...mapGetters({
      getUser: "auth/user",
      urlImage: "constant/urlImage",
    }),
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    hapusAvatar() {
      this.avatarrender = "";
    },
    rubahAvatar(files) {
      //   console.log(files[0]);
      if (files) {
        this.avatar = files[0];
      } else {
        this.avatar = null;
      }
      // console.log(this.avatar);
    },
    hapusLogo() {
      this.logorender = "";
    },
    rubahLogo(files) {
      //   console.log(files[0]);
      if (files) {
        this.logo = files[0];
      } else {
        this.logo = null;
      }
      // console.log(this.avatar);
    },
    onAdd() {
      this.kategoriAdd ? (this.kategoriAdd = false) : (this.kategoriAdd = true);
    },
    loadGurus() {
      // this.setSpinner(true);
      Axios.get("guru/showAllResource")
        .then((response) => {
          this.gurus = response.data.data;
          // this.setSpinner(false);
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
    loadSekolah() {
      // this.setSpinner(true);
      Axios.get("sekolah/showAll")
        .then((response) => {
          this.sekolah = response.data.data;
          // this.sekolah_id = reponse.data.id;
          this.guru_id = response.data.data.guru_id;
          this.nama = response.data.data.nama;
          this.alamat = response.data.data.alamat;
          this.email = response.data.data.email;
          this.visi = response.data.data.visi;
          this.moto1 = response.data.data.moto1;
          this.moto2 = response.data.data.moto2;
          this.logo = response.data.data.logo;
          this.logorender = response.data.data.logo;
          this.avatar = response.data.data.avatar;
          this.avatarrender = response.data.data.avatar;
          // this.setSpinner(false);
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
    onSave() {
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("guru_id", this.guru_id);
      dataQ.set("user_id", this.getUser.id);
      dataQ.set("nama", this.nama);
      dataQ.set("alamat", this.alamat);
      dataQ.set("email", this.email);
      dataQ.set("visi", this.visi);
      dataQ.set("moto1", this.moto1);
      dataQ.set("moto2", this.moto2);
      dataQ.set("logo", this.logo);
      dataQ.set("avatar", this.avatar);

      this.setSpinner(true);
      Axios.post("sekolah/update/" + 1, dataQ)
        .then((response) => {
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Data sekolah sudah di-update",
            type: "success", //nilai lain, error dan success
          });
          this.loadSekolah();
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "SINI Beo " + error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
    loadKategoris() {
      this.setSpinner(true);
      Axios.get("kategori/showBerita")
        .then((response) => {
          this.kategoris = response.data.data;
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
    getImageAvatar(avatar) {
      if (
        this.avatarrender != "" &&
        this.avatarrender.length > 0 &&
        this.avatarrender != null
      ) {
        return this.urlImage + "/sekolah/" + avatar;
      } else {
        return avatar;
      }
    },
    onImageAvatarChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      this.avatarrender = files[0];
      if (files.length) {
        return this.createImageAvatar(files[0]);
      }
    },
    createImageAvatar(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;
      reader.onload = (e) => {
        vm.avatar = e.target.result;
        // this.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    removeAvatar() {
      this.avatar = "";
    },
    // BATAS LOGO DAN AVATAR========================
    getImageLogo(logo) {
      if (
        this.logorender != "" &&
        this.logorender.length > 0 &&
        this.logorender != null
      ) {
        return this.urlImage + "/sekolah/" + logo;
      } else {
        return logo;
      }
    },

    onImageLogoChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      this.logorender = files[0];
      if (files.length) {
        return this.createImageLogo(files[0]);
      }
    },
    createImageLogo(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;
      reader.onload = (e) => {
        vm.logo = e.target.result;
        // this.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    removeLogo() {
      this.logo = "";
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
