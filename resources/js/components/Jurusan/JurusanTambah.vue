<template>
  <div>
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">{{jurusan.id? "Edit Jurusan" : "Jurusan Baru"}}</h5>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <Label>Jurusan</Label>
                  <input
                    class="form-control"
                    placeholder="Jurusan..."
                    type="text"
                    v-model="nama"
                  />
                  <small class="text-danger"> </small>
                </div>
                <div class="form-group">
                  <Label>Deskripsi</Label>
                  <input
                    class="form-control"
                    placeholder="Deskripsi..."
                    type="text"
                    v-model="deskripsi"
                  />
                  <small class="text-danger"> </small>
                </div>
                <div class="form-group">
                  <Label>Logo Jurusan</Label>
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
                    <img :src="getImage(image)" class="image-avatar" alt="" />
                    <div class="absolute-bottom-guru text-subtitle1 text-center">
                      <button @click="removeImage" class="button-image">
                        <i class="icofont-ui-delete"></i>
                      </button>
                    </div>
                  </div>
                  <small class="text-danger"> </small>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="onClose()">
                  Tutup
                </button>
                <button v-on:click="onSave()" type="button" class="btn btn-success">
                  Simpan
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import Axios from "axios";
import { mapGetters } from "vuex";
export default {
  props: ["jurusan"],
  data() {
    return {
      nama: "",
      deskripsi: "",
      //data gambar
      image: "",
      avatar: null,
    };
  },
  computed: {
    ...mapGetters({
      getUser: "auth/user",
      urlImage: "constant/urlImage",
    }),
  },
  mounted() {
    this.isUpdate();
  },
  methods: {
    // METHOD UNTUK GAMBAR
    getImage(image) {
      if (this.avatar) {
        if (this.avatar != "" && this.avatar.length > 0 && this.avatar != null) {
          return this.urlImage + "/jurusan/" + image;
        } else {
          return image;
        }
      }
    },
    isUpdate() {
      if (this.jurusan) {
        this.nama = this.jurusan.nama;
        this.deskripsi = this.jurusan.deskripsi;
        this.avatar = this.jurusan.logo;
        this.image = this.jurusan.logo;
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
      this.$parent.addJurusan = false;
      this.$parent.jurusanEdit = {};
    },
    onSave() {
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("user_id", this.getUser.id);
      dataQ.set("nama", this.nama);
      dataQ.set("deskripsi", this.deskripsi);
      dataQ.set("logo", this.avatar);

      if (this.jurusan.id) {
        //KODE UPDATE

        Axios.post("jurusan/update/" + this.jurusan.id, dataQ)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: "Satu Jurusan  sudah diupdate",
              type: "success", //nilai lain, error dan success
            });
            this.onClose();
            this.$parent.loadJurusans();
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Gagal",
              text: "SINI Beo " + error.message,
              type: "error", //nilai lain, error dan success
            });
          });
        this.onClose();
      } else {
        //KODE TAMBAH(INSERT)
        Axios.post("jurusan/store", dataQ)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: "Satu Jurusan  sudah ditambah",
              type: "success", //nilai lain, error dan success
            });
            this.onClose();
            this.$parent.loadJurusans();
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Gagal",
              text: "SINI Beo " + error.message,
              type: "error", //nilai lain, error dan success
            });
          });
        this.onClose();
      }
    },
  },
};
</script>
