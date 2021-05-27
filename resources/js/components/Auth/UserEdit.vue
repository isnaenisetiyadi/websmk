<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          class="mt-3 mb-5"
          color="warning"
          outlined
          rounded
          v-bind="attrs"
          v-on="on"
        >
          <span>Edit</span>
          <v-icon>mdi-pencil-outline</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-toolbar dark color="warning">
          <v-btn icon dark @click="dialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Edit Data User</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn plain @click="onSave()">
              <v-icon small>mdi-content-save</v-icon>
              <span>Simpan</span>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-form ref="form">
          <v-layout row class="ma-3" justify-center>
            <v-flex xs12 sm6 md4 class="pa-2">
              <v-text-field
                color="info"
                v-model="name"
                label="Nama"
                required
                :rules="role.required"
                clearable
              ></v-text-field>
              <v-text-field
                color="info"
                v-model="username"
                block
                label="Username"
                required
                :rules="role.required"
                clearable
              ></v-text-field>
              <v-text-field
                v-model="password"
                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                :type="showPassword ? 'text' : 'password'"
                clearable
                label="Reset Password"
                counter
                @click:append="showPassword = !showPassword"
              ></v-text-field>
            </v-flex>
            <v-flex xs12 sm6 md4 class="pa-2">
              <v-text-field
                color="info"
                v-model="email"
                block
                label="Email"
                required
                :rules="role.email"
                clearable
              ></v-text-field>
              <v-select :items="rules" v-model="role" label="Level Akses"> </v-select>
              <v-file-input
                :rules="role.avatar"
                accept="image/png, image/jpeg, image/bmp"
                prepend-icon="mdi-camera"
                label="Avatar"
                v-model="avatar"
              ></v-file-input>
              <v-card flat v-if="user.avatar">
                <v-img rounded size="20" :src="'images/users/' + user.avatar"></v-img>
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
import { mapActions } from "vuex";
export default {
  props: ["user"],
  data() {
    return {
      dialog: false,
      showPassword: false,
      errors: [],
      name: "",
      username: "",
      password: "",
      email: "",
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
            !value || value.size < 200000 || "Ukuran file tidak boleh lebih dari 2 MB!",
        ],
      },

      // DATA GAMBAR
      image: "",
      avatar: null,
      rules: ["SUPER USER", "ADMIN", "SISWA"],
    };
  },
  mounted() {
    this.isiForm();
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    isiForm() {
      this.name = this.user.name;
      this.username = this.user.username;
      //   this.password = this.user.password;
      this.email = this.user.email;
      this.role = this.user.role;
    },
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

      Axios.post("auth/update/" + this.user.id, dataQ)
        .then((response) => {
          this.$notify({
            group: "auth",
            title: "Sukses",
            text: "Data user sudah di-update",
          });
          //   this.$parent.loadUsers();
          this.$emit("loadUsers");
          this.dialog = false;
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "ERROR : " + error.message,
            type: "error", //nilai lain, error dan success
          });
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
      // reader.readAsDataURL(file);
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
