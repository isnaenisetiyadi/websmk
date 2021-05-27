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
          <v-btn color="info"  small icon plain v-bind="attrs" v-on="on">
            <v-icon class="ma-0">mdi-plus</v-icon>
            <!-- <span>Tambah Berita</span> -->
          </v-btn>
        </template>

        <v-card>
          <v-toolbar dark color="info">
            <v-btn icon dark @click="dialog = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Program Kerja Baru</v-toolbar-title>
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
                <UploadAvatar
                  :max="1"
                  fileError="Jenis file tidak didukung"
                  uploadMsg="Tab atau Klik untuk memilih file"
                  @change="rubahAvatar"
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
  <!-- <div class="text-center">
    <v-btn plain @click="sheet = !sheet">
      <v-icon>mdi-plus</v-icon>
      
    </v-btn>
    <v-bottom-sheet v-model="sheet" class="primary" hide-overlay>
      <v-sheet>
        <v-toolbar dark color="info">
          <v-btn icon dark @click="sheet = !sheet">
            <v-icon x-large>mdi-menu-down</v-icon>
          </v-btn>
          <h1 class="overline">Tambah Program</h1>
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
              <UploadAvatar
                :max="1"
                fileError="Jenis file tidak didukung"
                uploadMsg="Tab atau Klik untuk memilih file"
                @change="rubahAvatar"
              />
            </v-card>
          </v-flex>
          <v-flex xs12 class="pa-2"> </v-flex>
          <label class="caption">Deskripsi Program</label>
          <v-card>
            <quill-editor v-model="konten" :options="editorOption" class="editor" />
          </v-card>
        </v-layout>
      </v-sheet>
    </v-bottom-sheet>
  </div> -->
</template>
<script>
import Axios from "axios";
import UploadAvatar from "vue-upload-drop-images";
export default {
  props: ["organisasi"],
  data() {
    return {
      // sheet: false,
      dialog: false,
      nama: "",
      deskripsi: "",
      avatar: undefined,
      konten: "",
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
      dataQ.set("organisasi_id", this.organisasi.id);
      dataQ.set("nama", this.nama);
      dataQ.set("deskripsi", this.deskripsi);
      dataQ.set("konten", this.konten);
      dataQ.set("avatar", this.avatar);

      // this.setSpinner(true);
      Axios.post("program/store", dataQ)
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
