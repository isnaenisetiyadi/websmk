<template>
  <v-container>
    <v-row justify="center">
      <v-dialog
        v-model="dialog"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn class="mt-3 mb-5" color="info" plain v-bind="attrs" v-on="on">
            <v-icon>mdi-pencil-outline</v-icon>
            <span>Edit</span>
          </v-btn>
        </template>
        <v-card>
          <v-toolbar dark color="warning">
            <v-btn icon dark @click="dialog = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Edit Organisasi</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn plain @click="onSave()" :disabled="!nama">
                <v-icon small>mdi-content-save</v-icon>
                <span>Simpan</span>
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-form ref="form">
            <v-layout row class="ma-3" justify-center>
              <v-flex xs12 sm6 md4 class="pa-2">
                <v-text-field label="Nama" color="info" v-model="nama"> </v-text-field>
                <v-textarea
                  label="Deskripsi"
                  v-model="deskripsi"
                  color="info"
                ></v-textarea>
              </v-flex>
              <v-flex xs12 sm6 md4 class="pa-2">
                <v-card>
                  <h3 class="subtitle-1">Gambar/ Tumbnail</h3>
                  <v-img
                    :src="'images/organisasi/' + organisasi.avatar"
                    v-if="avatar_switch_image"
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
          </v-form>
        </v-card>
      </v-dialog>
    </v-row>
  </v-container>
</template>

<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
import UploadAvatar from "vue-upload-drop-images";
export default {
  name: "organisasi-tambah",
  components: { UploadAvatar },
  props: ["organisasi"],
  data() {
    return {
      nama: "",
      deskripsi: "",
      //data gambar
      // image: "",
      avatar: undefined,
      avatar_switch_image: "",

      dialog: false,
    };
  },
  computed: {
    ...mapGetters({
      getUser: "auth/user",
      urlImage: "constant/urlImage",
    }),
  },
  mounted() {
    this.isiData();
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    
    rubahAvatar(files) {
      //   console.log(files[0]);
      if (files) {
        this.avatar = files[0];
      } else {
        this.avatar = null;
      }
      //   console.log(this.avatar);
    },
    hapusAvatar() {
      this.avatar_switch_image = "";
    },
    // METHOD UNTUK GAMBAR
    getImage(image) {
      if (this.avatar) {
        if (this.avatar != "" && this.avatar.length > 0 && this.avatar != null) {
          return this.urlImage + "/organisasi/" + image;
        } else {
          return image;
        }
      }
    },
    isiData() {
      if (this.organisasi) {
        this.nama = this.organisasi.nama;
        this.deskripsi = this.organisasi.deskripsi;
        // this.avatar = this.organisasi.avatar;
        // this.image = this.organisasi.avatar;
        if (this.organisasi.avatar) {
          this.avatar_switch_image = this.organisasi.avatar;
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
      this.avatar = "";
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
    onClose() {
      this.$parent.addOrganisasi = false;
      this.$parent.organisasiEdit = {};
    },
    onSave() {
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("user_id", this.getUser.id);
      dataQ.set("nama", this.nama);
      dataQ.set("deskripsi", this.deskripsi);
      dataQ.set("avatar", this.avatar);

      //KODE TAMBAH(INSERT)
      // this.setSpinner(true);
      Axios.post("organisasi/update/" + this.organisasi.id, dataQ)
        .then((response) => {
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Satu Organisasi  sudah ditambah",
            type: "success", //nilai lain, error dan success
          });
          // this.onClose();
          // this.setSpinner(false);
          this.dialog = false;
          this.$emit("isiOrganisasiLagi");
          // this.kosongkanData();
          // this.$parent.loadOrganisasi();
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "SINI BRO " + error.message,
            type: "error", //nilai lain, error dan success
          });
          // this.setSpinner(false);
        });
      // this.onClose();
    },
    kosongkanData() {
      (this.nama = ""), (this.deskripsi = ""), (this.avatar = null);
    },
  },
};
</script>
