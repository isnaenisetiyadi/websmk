<template>
  <v-container class="pb-5">
    <v-row justify="center">
      <v-dialog
        v-model="dialog"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn class="warning" dark icon plain v-bind="attrs" v-on="on">
            <v-icon> mdi-pencil</v-icon>
            <!-- <span>Tambah Berita</span> -->
          </v-btn>
        </template>

        <v-card>
          <v-toolbar dark color="warning">
            <v-btn icon dark @click="dialog = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Edit Program Kerja</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn plain @click="onSave()" :disabled="!nama">
                <v-icon small>mdi-content-save</v-icon>
                <span>Simpan</span>
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-layout row class="ma-3">
            <v-flex xs12 sm6 class="pa-2">
              <v-text-field label="Nama Program" color="info" v-model="nama">
              </v-text-field>
              <v-textarea label="Deskripsi" v-model="deskripsi" color="info"></v-textarea>
            </v-flex>
            <v-flex xs12 sm6 class="pa-2">
              <v-card>
                <h3 class="subtitle-1">Avatar</h3>
                <v-img
                  :src="'images/program/' + program.avatar"
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
            <v-flex xs12 class="pa-2"> </v-flex>
            <label class="caption">Deskripsi Program</label>
            <v-card>
              <quill-editor v-model="konten" :options="editorOption" class="editor" />
            </v-card>
          </v-layout>
        </v-card>
      </v-dialog>
    </v-row>
  </v-container>
 
</template>
<script>
import Axios from "axios";
import UploadAvatar from "vue-upload-drop-images";
export default {
  props: ["program"],
  data() {
    return {
      // sheet: false,
      dialog: false,
      nama: "",
      deskripsi: "",
      avatar: undefined,
      konten: "",
      avatar_switch_image: "",
      editorOption: {
        debug: "info",
        placeholder: "Type your post...",
        theme: "snow",
        height: "100px",
      },
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
  mounted() {
    this.isiData();
  },
  methods: {
    isiData(){
      this.nama = this.program.nama;
      this.deskripsi = this.program.deskripsi;
      this.konten = this.program.konten;
      if (this.program.avatar) {
        this.avatar_switch_image = this.program.avatar;
      }
    },
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
    onSave() {
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("user_id", this.$store.state.auth.user.id);
      dataQ.set("organisasi_id", this.program.organisasi_id);
      dataQ.set("nama", this.nama);
      dataQ.set("deskripsi", this.deskripsi);
      dataQ.set("konten", this.konten);
      dataQ.set("avatar", this.avatar);

      // this.setSpinner(true);
      Axios.post("program/update/" + this.program.id, dataQ)
        .then((response) => {
          this.$notify({
            group: "success",
            title: "Sukses",
            text: response.data.message,
            type: "success", //nilai lain, error dan success
          });
          this.dialog = false;
          // this.setSpinner(false);
          this.$emit("isiOrganisasiLagi");
          // this.kosongkanData();
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
      this.deskripsi = "";
      this.avatar = null;
    },
  },
};
</script>

<style>
/* .ql-editor {
    color: #306674;
} */

.ql-editor {
  max-height: 400px;
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
