<template>
  <div class="list-group-item">
    <div v-if="!editKategori" class="input-group align-middle">
      <span class="input-group-text">
        <img :src="urlImage + '/anything.jpg'" v-if="!image" style="width: 30px" />
        <img :src="getImage(image)" style="width: 30px" v-else />
      </span>

      <textarea
        disabled
        class="form-control"
        aria-label="With textarea"
        :value="misi.text"
      ></textarea>
      <span class="input-group-text">
        <button @click="onEdit()" class="btn btn-outline-primary" type="button">
          <i class="icofont-edit"></i>
        </button>
        <button @click="onDelete()" class="btn btn-outline-danger" type="button">
          <i class="icofont-trash"></i>
        </button>
      </span>
    </div>
    <div v-if="editKategori" class="input-group align-middle">
      <span class="input-group-text">
        <!-- <img :src="urlImage + '/guru/' + guru.avatar" alt="" /> -->
        <!-- <img :src="urlImage + '/anything.jpg'" style="width: 30px" /> -->
        <input
          v-if="!image"
          class="form-controll"
          type="file"
          bg-color="white"
          @change="onImageChange"
          filled
          multiple
          accept=".jpg, image/*"
          name="avatar"
          @rejected="onRejected"
          bottom-slots
        />
        <img
          @click="removeImage"
          :src="getImage(image)"
          style="width: 30px; cursor: pointer"
          v-else
        />
        <div class="absolute-bottom-misi text-subtitle1 text-center">
          <!-- <button @click="removeImage" class="button-image">
            <i class="icofont-ui-delete"></i>
          </button> -->
        </div>
      </span>

      <textarea
        class="form-control"
        aria-label="With textarea"
        :value="misi.text"
      ></textarea>
      <span class="input-group-text">
        <button @click="onEdit()" class="btn btn-outline-primary" type="button">
          <i class="icofont-reply"></i>
        </button>
        <button @click="onSave()" class="btn btn-outline-primary" type="button">
          <i class="icofont-save"></i>
        </button>
      </span>
    </div>
  </div>
</template>
<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      editKategori: false,
      text: "",
      image: "",
      avatar: "",
    };
  },
  props: ["misi"],
  mounted() {
    this.init();
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
    kosongkandata() {
      this.text = "";
      this.image = "";
      this.avatar = "";
    },
    init() {
      this.text = this.misi.text;
      this.image = this.misi.avatar;
      this.avatar = this.misi.avatar;
    },
    onEdit() {
      this.editKategori ? (this.editKategori = false) : (this.editKategori = true);
      // this.editKategori = false;
      this.kosongkandata();
      this.init();
    },
    onDelete() {
      this.$confirm({
        message: "Yakin akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            this.setSpinner(true);
            Axios.post("misi/destroy/" + this.misi.id)
              .then((response) => {
                this.$parent.loadSekolah();
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: "Satu misi sudah dihapus",
                  type: "warn", //nilai lain, error dan success
                });
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
          }
        },
      });
    },
    onSave() {
      // const data = {
      //   id: this.misi.id,
      //   user_id: this.getUser.id,
      //   sekolah_id: this.misi.sekolah_id,
      //   text: this.text,
      // };
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("user_id", this.getUser.id);
      dataQ.set("sekolah_id", this.$parent.sekolah.id);
      dataQ.set("avatar", this.avatar);
      dataQ.set("text", this.text);
      this.setSpinner(true);
      Axios.post("misi/update/" + this.misi.id, dataQ)
        .then((response) => {
          this.$parent.loadSekolah();
          this.editKategori = false;
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Satu misi  sudah diedit",
            type: "success", //nilai lain, error dan success
          });
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "Backend " + error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
    // METHOD UNTUK GAMBAR
    getImage(image) {
      if (this.avatar != "" && this.avatar.length > 0 && this.avatar != null) {
        return this.urlImage + "/sekolah/" + image;
      } else {
        return image;
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
  },
};
</script>
