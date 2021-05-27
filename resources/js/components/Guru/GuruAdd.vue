<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn class="mt-3 mb-5" color="info" outlined rounded v-bind="attrs" v-on="on">
          <v-icon>mdi-account-plus-outline</v-icon>
          <span>Tambah Guru</span>
        </v-btn>
      </template>
      <v-card>
        <v-toolbar dark color="info">
          <v-btn icon dark @click="dialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Guru Baru</v-toolbar-title>
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
              <v-text-field label="Nip" color="info" v-model="nip"> </v-text-field>
              <v-text-field label="Nuptk" color="info" v-model="nuptk"> </v-text-field>
              <v-text-field label="Email" color="info" v-model="email"> </v-text-field>
              <v-text-field label="Nomor HP" color="info" v-model="kontak">
              </v-text-field>
              <v-text-field label="Jabatan" color="info" v-model="jabatan">
              </v-text-field>
            </v-flex>
            <v-flex xs12 sm6 md4 class="pa-2">
              <v-textarea label="Alamat" v-model="alamat" color="info"></v-textarea>
              <v-card>
                <h3 class="subtitle-1">Avatar</h3>
                <UploadAvatar
                  :max="1"
                  fileError="Jenis file tidak didukung"
                  uploadMsg="Tab atau Klik untuk memilih file"
                  @change="rubahAvatar"
                />
              </v-card>
             
            </v-flex>
            
          </v-layout>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import Axios from "axios";
import UploadAvatar from "vue-upload-drop-images";
export default {
  components: { UploadAvatar },
  data() {
    return {
      dialog: false,
     
      nama: "",
      nip: "",
      nuptk: "",
      email: "",
      kontak: "",
      jabatan: "",
      alamat: "",
      avatar: undefined,
      
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
      image: null,
      imagePreview: null,
    };
  },
  mounted() {
   
  },
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
      dataQ.set("nama", this.nama);
      dataQ.set("nip", this.nip);
      dataQ.set("nuptk", this.nuptk);
      dataQ.set("alamat", this.alamat);
      dataQ.set("email", this.email);
      dataQ.set("kontak", this.kontak);
      dataQ.set("avatar", this.avatar);

      // this.setSpinner(true);
      Axios.post("guru/store", dataQ)
        .then((response) => {
          this.$notify({
            group: "success",
            title: "Sukses",
            text: response.data.message,
            type: "success", //nilai lain, error dan success
          });
          this.dialog = false;
          // this.setSpinner(false);
          this.$emit("loadGurus");
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
      this.nama = "";
      this.nip = "";
      this.nuptk = "";
      this.email = "";
      this.kontak = "";
      this.jabatan = "";
      this.alamat = "";

      this.avatar = null;
    },
    // urusan image
    imageSelected(e) {
      this.image = e.target.files[0];
      let reader = new FileReader();
      reader.readAsDataURL(this.image);
      reader.onload = (e) => {
        this.imagePreview = e.target.result;
      };
    },
    // end of image
  },
};
</script>

<style>
/* .ql-editor {
    color: #306674;
} */

.ql-editor {
  max-height: 600px;
  overflow-y: scroll;
  /* background-color: #c5f3fc; */
}

.ql-editor h1,
.ql-editor h2,
.ql-editor h3,
.ql-editor h4 {
  color: #4d9baff3;
}

.ql-editor img {
  width: 50%;
  border-radius: 10px;
  margin-top: 10px;
  margin-bottom: 10px;
}

@media screen and (max-width: 768px) {
  .ql-editor img {
    width: 75%;
  }
}

@media screen and (max-width: 378px) {
  .ql-editor img {
    width: 100%;
  }
}
</style>
