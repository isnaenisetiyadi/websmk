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
          <v-btn class="mt-3 mb-5" color="info" outlined rounded v-bind="attrs" v-on="on">
            <v-icon>mdi-text-box-plus-outline</v-icon>
            <span>Tambah Berita</span>
          </v-btn>
        </template>
        <v-card>
          <v-toolbar dark color="info">
            <v-btn icon dark @click="dialog = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Berita Baru</v-toolbar-title>
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
                <v-card>
                  <h3 class="subtitle-1">Gambar/ Tumbnail</h3>
                  <UploadAvatar
                    :max="1"
                    fileError="Jenis file tidak didukung"
                    uploadMsg="Tab atau Klik untuk memilih file"
                    @change="rubahAvatar"
                  />
                </v-card>
                <!-- <v-file-input
                :rules="role.avatar"
                accept="image/png, image/jpeg, image/bmp"
                prepend-icon="mdi-camera"
                label="Tumbnail"
                @change="imageSelected"
                color="info"
              ></v-file-input> -->

                <!-- <v-card v-if="imagePreview">
                <v-img :src="imagePreview"></v-img>
              </v-card> -->
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
                  hide-selected
                  deletable-chips
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
              <!-- <v-img
              width="100"
              :src="createImage(image)"></v-img> -->
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
      image: null,
      imagePreview: null,
    };
  },
  mounted() {
    this.isiKategori();
    this.isiJurusan();
    this.isiOrganisasi();
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
      Axios.post("auth/berita/store", dataQ)
        .then((response) => {
          this.$notify({
            group: "success",
            title: "Sukses",
            text: response.data.message,
            type: "success", //nilai lain, error dan success
          });
          this.dialog = false;
          // this.setSpinner(false);
          this.$parent.isiBerita();
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
      this.judul = "";
      this.deskripsi = "";
      this.kategori = "";
      this.konten = "";

      this.avatar = null;

      // data untuk multiselect jurusan dan organisasi
      this.jurusan = [];
      this.organisasi = [];
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
