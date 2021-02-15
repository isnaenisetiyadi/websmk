<template>
  <div class="list-group-item">
    <div class="input-group" style="margin-top: 0; margin-bottom: 0">
      <span class="input-group-text">
        <!-- <img :src="urlImage + '/guru/' + guru.avatar" alt="" /> -->
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
        <img :src="getImage(image)" style="width: 30px" v-else />
      </span>

      <textarea class="form-control" aria-label="With textarea" v-model="text"></textarea>
      <span class="input-group-text">
        <button @click="onCancel()" class="btn btn-outline-primary" type="button">
          <i class="icofont-reply"></i>
        </button>
        <button @click="onSave()" class="btn btn-outline-primary" type="button">
          <i class="icofont-save"></i>
        </button>
      </span>
      <!-- <input
        type="text"
        class="form-control"
        placeholder="Misi"
        aria-label="Recipient's username with two button addons"
        v-model="text"
      /> -->
    </div>
  </div>
</template>
<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      text: "",
      image: "",
      avatar: "",
    };
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
    onCancel() {
      this.$parent.kategoriAdd = false;
    },
    onSave() {
      // const data = {
      //   user_id: this.getUser.id,
      //   sekolah_id: this.$parent.sekolah.id,
      //   text: this.text,
      // };
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("user_id", this.getUser.id);
      dataQ.set("sekolah_id", this.$parent.sekolah.id);
      dataQ.set("avatar", this.avatar);
      dataQ.set("text", this.text);

      this.setSpinner(true);
      Axios.post("misi/store", dataQ)
        .then((response) => {
          this.$parent.kategoriAdd = false;
          this.$parent.loadSekolah();
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Satu misi  sudah ditambahkan",
            type: "success", //nilai lain, error dan success
          });
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "BACKEND " + error.message,
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
