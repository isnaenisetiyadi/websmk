<template>
  <div>
    <div class="container-fluid banner" height="50px"></div>
    <div class="container">
      <div class="row mb-5 align-items-end">
        <div class="col-md-12" data-aos="fade-up">
          <h2>Registrasi User</h2>
        </div>
      </div>

      <div class="col-md-12 mb-5" data-aos="fade-down">
        <!-- <div class="card-body"> -->
        <div class="row border">
          <div class="col-md-6 py-md-3">
            <div class="alert alert-danger" v-if="errors.length">
              <ul class="mb-0">
                <li v-for="(error, index) in errors" :key="index">
                  {{ error }}
                </li>
              </ul>
            </div>

            <div class="form-group" data-aos="fade-left">
              <Label>Nama</Label>
              <input
                class="form-control"
                placeholder="Nama..."
                type="text"
                v-model="name"
              />
            </div>
            <div class="form-group" data-aos="fade-right">
              <Label>Username</Label>
              <input
                class="form-control"
                placeholder="Username..."
                type="text"
                v-model="username"
              />
            </div>
            <div class="form-group" data-aos="fade-right">
              <Label>Foto Profil</Label>
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
              <div v-else class="text-center m-lg">
                <img :src="image" class="image-avatar" alt="" />
                <div class="absolute-bottom text-subtitle1 text-center">
                  <button @click="removeImage" class="button-image">
                    <i class="icofont-ui-delete"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 py-md-3">
            <div class="form-group" data-aos="fade-left" data-aos-delay="300">
              <Label>Email</Label>
              <input
                class="form-control"
                placeholder="Email..."
                type="email"
                v-model="email"
              />
            </div>
            <div class="form-group" data-aos="fade-right" data-aos-delay="200">
              <Label>Password</Label>
              <input
                class="form-control"
                placeholder="Password..."
                type="password"
                v-model="password"
              />
            </div>
            <div class="form-group" data-aos="fade-left" data-aos-delay="100">
              <Label>Level Akses</Label>
              <!-- <select class="custom-select" v-model="role"> -->
              <select class="form-control" v-model="role">
                <option selected>Choose...</option>
                <option value="SUPER_USER">SUPER_USER</option>
                <option value="ADMIN">ADMIN</option>
                <option value="GUEST">GUEST</option>
              </select>
            </div>
          </div>
          <div class="col-md-12 p-md-2">
            <button
              @click="onSave()"
              class="btn btn-success m-md-1"
              data-aos="fade-left"
              data-aos-delay="100"
            >
              Simpan
            </button>

            <button
              @click="onCancel()"
              class="btn btn-warning m-md-1"
              data-aos="fade-left"
              data-aos-delay="300"
            >
              Tutup
            </button>
          </div>
        </div>
        <!-- </div> -->
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import { mapActions } from "vuex";
export default {
  props: ["index"],
  data() {
    return {
      errors: [],
      name: "",
      username: "",
      password: "",
      email: "",
      role: "",

      // DATA GAMBAR
      image: "",
      avatar: null,
    };
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    onSave() {
      // Menggunakan form-data (npm i form-data)
      // tidak bisa menggunakan data biasa,
      // karena berisi data -> file avatar
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("name", this.name);
      dataQ.set("username", this.username);
      dataQ.set("email", this.email);
      dataQ.set("password", this.password);
      dataQ.set("avatar", this.avatar);
      dataQ.set("role", this.role);
      this.setSpinner(true);
      Axios.post("auth/register", dataQ)
        .then((response) => {
          this.$notify({
            group: "auth",
            title: "Sukses",
            text: "User baru sudah ditambahkan",
          });
          this.setSpinner(false);
          this.$router.push("/users");
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "ERROR : " + error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
    onCancel() {
      this.$router.push("/users");
    },

    // METHOD UNTUK GAMBAR
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
      // Notify plugin needs to be installed
      // https://quasar.dev/quasar-plugins/notify#Installation
      // this.$q.notify({
      //   type: "negative",
      //   message: `${rejectedEntries.length} file(s) did not pass validation constraints`,
      // });
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
