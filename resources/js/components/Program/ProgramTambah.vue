<template>
  <div>
    <!-- <transition name="modal"> -->
    <div class="col-md-12 mb-8">
      <!-- <div class="modal-wrapper"> -->
      <!-- <div class="row" role="document"> -->
      <div class="modal-content mb55">
        <div class="modal-header">
          <!-- <h5 class="modal-title">{{jurusan.id? "Edit Jurusan" : "Jurusan Baru"}}</h5> -->
          <h5 class="modal-title">Tambah Program Organisasi</h5>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <Label>Nama</Label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Nama..."
                  aria-label="Cari nama"
                  aria-describedby="basic-addon1"
                  v-model="nama"
                />
                <small class="text-danger"> </small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <Label>Organisasi</Label>
                <select
                  class="form-control"
                  v-model="organisasi_id"
                  aria-placeholder="Pilih..."
                >
                  <option selected value="">Pilih Organisasi...</option>
                  <option
                    v-for="(organisasi, index) in organisasis"
                    :key="index"
                    v-bind:value="organisasi.id"
                  >
                    {{ organisasi.nama }}
                  </option>
                  <!-- <option>Berita</option>
                  <option>Kegiatan</option>
                  <option>Event</option> -->
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <Label>Deskripsi</Label>
                <textarea class="form-control" v-model="deskripsi" rows="4" cols="50" />
                <small class="text-danger"> </small>
              </div>
            </div>
            <div class="col-md-6 align-middle">
              <div class="form-group">
                <Label>Gambar Tumbnail</Label>
                <input
                  v-if="!image"
                  class="form-controll"
                  type="file"
                  bg-color="white"
                  @change="onImageChange"
                  filled
                  label="Foto Profil"
                  multiple
                  accept=".jpg, image/*"
                  name="avatar"
                  @rejected="onRejected"
                  bottom-slots
                />
                <div v-else class="m-lg">
                  <img :src="getImage(image)" style="width: 25%" alt="" />
                  <div class="absolute-bottom-guru text-subtitle1 text-center">
                    <button @click="removeImage" class="button-image">
                      <i class="icofont-ui-delete"></i>
                    </button>
                  </div>
                </div>
                <small class="text-danger"> </small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <Label>Tentang Program</Label>
            <quill-editor v-model="konten" :options="editorOption" class="editor" />
            <small class="text-danger"> </small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" @click="onClose()">
            <!-- Tutup -->
            <i class="icofont-reply"></i>
          </button>
          <button v-on:click="onSave()" type="button" class="btn btn-success">
            <!-- <i class="icofont-check"></i> -->Simpan
          </button>
        </div>
      </div>
      <!-- </div> -->
      <!-- </div> -->
    </div>
    <!-- </transition> -->
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Axios from "axios";
export default {
  name: "program-tambah",
  props: ["organisasis", "organisasi_id", "program"],
  data() {
    return {
      //   organisasi_id: "",
      nama: "",
      deskripsi: "",
    //   organisasi_id: "",
      image: "",
      avatar: null,
      konten: "",

      //mode pada quil-editor
      editorOption: {
        debug: "info",
        placeholder: "Type your post...",
        theme: "snow",
        height: "100px",
      },
    };
  },
  mounted() {
    this.onEdit();
  },
  computed: {
    ...mapGetters({
      getUser: "auth/user",
      urlImage: "constant/urlImage",
    }),
  },
  methods: {
    onEdit() {
        // console.log(this.program.nama);
      if (this.program) {
        this.nama = this.program.nama;
        this.deskripsi = this.program['deskripsi'];
        this.image = this.program.avatar;
        this.avatar = this.program.avatar;
        this.konten = this.program.konten;
      }
    },
    // METHOD UNTUK GAMBAR
    getImage(image) {
      if (this.avatar) {
        if (this.avatar != "" && this.avatar.length > 0 && this.avatar != null) {
          return this.urlImage + "/program/" + image;
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
    onClose() {
      this.$parent.addProgram = false;
      if (this.$parent.program) {
        this.$parent.program = {};
      }
    },
    onSave() {
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("user_id", this.getUser.id);
      dataQ.set("organisasi_id", this.organisasi_id);
      dataQ.set("nama", this.nama);
      dataQ.set("deskripsi", this.deskripsi);
      dataQ.set("avatar", this.avatar);
      dataQ.set("konten", this.konten);

      if (this.program.id) {
        //   KODE here for update
        Axios.post("program/update/" + this.program.id, dataQ)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: "Satu Organisasi  sudah diupdate",
              type: "success", //nilai lain, error dan success
            });
            this.$parent.loadPrograms();
            this.onClose();
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Gagal",
              text: "SINI BRO " + error.message,
              type: "error", //nilai lain, error dan success
            });
          });
      } else {
        Axios.post("program/store", dataQ)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: "Satu Organisasi  sudah ditambah",
              type: "success", //nilai lain, error dan success
            });
            this.$parent.loadPrograms();
            this.onClose();
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Gagal",
              text: "SINI BRO " + error.message,
              type: "error", //nilai lain, error dan success
            });
          });
      }
    },
  },
};
</script>
