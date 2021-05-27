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
          <v-btn class="mt-3 mb-5" color="warning" plain v-bind="attrs" v-on="on">
            <v-icon>mdi-pencil-outline</v-icon>
            <span>Edit</span>
          </v-btn>
        </template>
        <v-card>
          <v-toolbar dark color="warning">
            <v-btn icon dark @click="dialog = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Edit Berita</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn plain @click="onSave()" :disabled="!judul">
                <v-icon small>mdi-content-save</v-icon>
                <span>Simpan</span>
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-form ref="form">
            <v-layout row class="ma-3" justify-center>
              <v-flex xs12 sm6 md4 class="pa-2">
                <v-text-field label="Judul" color="info" v-model="judul"> </v-text-field>
                <v-textarea
                  label="Deskripsi"
                  v-model="deskripsi"
                  color="info"
                ></v-textarea>
                <h3 class="subtitle-1">Gambar/ Tumbnail</h3>
                <!-- <v-file-input
                :rules="role.avatar"
                accept="image/png, image/jpeg, image/bmp"
                prepend-icon="mdi-camera"
                label="Tumbnail"
                v-model="avatar"
              ></v-file-input> -->
                <!-- <v-list-item>
                  <div class="caption">{{jurusan}}</div>
              </v-list-item> -->

                <v-card>
                  <v-img
                    :src="'images/berita/' + berita.avatar"
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
              <v-flex xs12 sm6 md4 class="pa-2">
                <v-select
                  :items="kategoris"
                  v-model="kategori"
                  item-value="id"
                  item-text="nama"
                  label="Pilih Kategori"
                  color="info"
                ></v-select>
                <v-select
                  :items="jurusans"
                  v-model="jurusan"
                  item-value="id"
                  item-text="nama"
                  label="Tampil di jurusan"
                  multiple
                  chips
                  deletable-chips
                  hide-selected
                  color="info"
                ></v-select>
                <v-select
                  :items="organisasis"
                  v-model="organisasi"
                  item-value="id"
                  item-text="nama"
                  label="Tampil di organisasi"
                  multiple
                  chips
                  deletable-chips
                  hide-selected
                  color="info"
                ></v-select>
              </v-flex>
              <v-divider class="d-flex d-sm-none"></v-divider>
              <v-flex xs12>
                <label class="caption">Isi Berita</label>
                <quill-editor v-model="konten" :options="editorOption" class="editor" />
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
import UploadAvatar from "vue-upload-drop-images";
export default {
  props: ["berita"],
  components: { UploadAvatar },
  data() {
    return {
      dialog: false,
      kategoris: {},
      kategori: [],
      jurusans: {},
      jurusan: [],
      organisasis: {},
      organisasi: [],
      judul: "",
      deskripsi: "",
      avatar: undefined,
      avatar_switch_image: "",
      editorOption: {
        debug: "info",
        placeholder: "Type your post...",
        theme: "snow",
        height: "100px",
      },
      konten: "",
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
    this.isiKategori();
    this.isiJurusan();
    this.isiOrganisasi();
    this.isiData();

    if (this.berita.avatar) {
      this.avatar_switch_image = this.berita.avatar;
    }
  },
  methods: {
    rubahAvatar(files) {
      //   console.log(files[0]);
      if (files) {
        this.avatar = files[0];
      } else {
        this.avatar = null;
      }
      // console.log(this.avatar);
    },
    isiKategori() {
      //   this.setSpinner(true);
      Axios.get("kategoris")
        .then((response) => {
          this.kategoris = response.data.data;
          //   this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.data,
            type: "error", //nilai lain, error dan success
          });
          //   this.setSpinner(false);
        });
    },
    isiJurusan() {
      //   this.setSpinner(true);
      Axios.get("jurusan/getAll")
        .then((response) => {
          this.jurusans = response.data;
          //   this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.data,
            type: "error", //nilai lain, error dan success
          });
          //   this.setSpinner(false);
        });
    },
    isiOrganisasi() {
      //   this.setSpinner(true);
      Axios.get("organisasi/getAll")
        .then((response) => {
          this.organisasis = response.data;
          //   this.setSpinner(false);
          //   console.log(this.organisasis);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.data,
            type: "error", //nilai lain, error dan success
          });
          //   this.setSpinner(false);
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

      let encodedJurusanDipilih = JSON.stringify(this.jurusan);
      let encodedOrganisasiDipilih = JSON.stringify(this.organisasi);
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("judul", this.judul);
      dataQ.set("user_id", this.$store.state.auth.user.id);
      dataQ.set("kategori_id", this.kategori);
      dataQ.set("deskripsi", this.deskripsi);
      dataQ.set("konten", this.konten);
      dataQ.set("jurusans", encodedJurusanDipilih);
      dataQ.set("organisasis", encodedOrganisasiDipilih);
      dataQ.set("avatar", this.avatar);

      // this.setSpinner(true);
      Axios.post("auth/berita/update/" + this.berita.id, dataQ)
        .then((response) => {
          this.$notify({
            group: "success",
            title: "Sukses",
            text: response.data.message,
            type: "success", //nilai lain, error dan success
          });
          this.$emit("isiBerita");
          this.dialog = false;
          // this.setSpinner(false);
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
    hapusAvatar() {
      this.avatar_switch_image = "";
    },
   
    isiData() {
      this.judul = this.berita.judul;
      this.deskripsi = this.berita.deskripsi;
      this.kategori = this.berita.kategori_id;
      this.konten = this.berita.konten;

      // this.avatar = this.berita.avatar;

      // data untuk multiselect jurusan dan organisasi
      let jd = this.berita.jurusan;
      // console.log(this.berita.jurusan);
      let og = this.berita.organisasi;

      this.jurusan = [];
      jd.forEach((jur) => {
        this.jurusan.push(jur.id);
      });
      this.organisasi = [];
      og.forEach((org) => {
        this.organisasi.push(org.id);
      });
    },
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
