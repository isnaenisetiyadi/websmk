<template>
  <div class="container">
    <!-- INI KODE UNTUK EDIT USER -->
    <div v-if="update" class="container">
      <div class="row mb-5 align-items-end">
        <div class="col-md-12" data-aos="fade-up">
          <h2>Edit User</h2>
        </div>
      </div>

      <div class="col-md-12 mb-5" data-aos="fade-down">
        <!-- <div class="card-body"> -->
        <!-- <form> -->
        <div class="row border">
          <div class="alert alert-danger" v-if="errors.length">
            <ul class="mb-0">
              <li v-for="(error, index) in errors" :key="index">
                {{ error }}
              </li>
            </ul>
          </div>

          <div class="col-md-6 py-md-3">
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
                <img :src="getImage(image)" class="image-avatar" alt="" />
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
            <!-- 
              <div class="form-group" data-aos="fade-right" data-aos-delay="200">
                <Label>Password</Label>
                <input
                  class="form-control"
                  placeholder="Password..."
                  type="password"
                  v-model="password"
                />
              </div>
               -->
            <div class="form-group" data-aos="fade-left" data-aos-delay="100">
              <Label>Level Akses</Label>
              <!-- <select class="custom-select" v-model="role"> -->
              <select class="form-control" v-model="role">
                <option selected>Choose...</option>
                <option value="SUPER USER">SUPER USER</option>
                <option value="ADMIN">ADMIN</option>
                <option value="GUEST">GUEST</option>
              </select>
            </div>
          </div>
          <!-- </form> -->
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
    <!-- AKHIR KODE UNTUK EDIT USER -->

    <!-- DIBAWAH INI ADALAH -->
    <!-- KODE UNTUK MENAMPILKAN DATA USER DALAM BENTUK TABEL -->
    <div v-else class="card mb-5">
      <div class="card-header">
        <div class="float-left card-judul" data-aos="fade-left">User List</div>

        <div class="input-group-append float-right" data-aos="fade-right">
          <router-link to="/entry/register" class="btn btn-success">
            <i class="icofont-ui-add"></i>
          </router-link>
        </div>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr data-aos="fade-up" class="tabel-lebar">
              <!-- <th scope="col">#</th> -->
              <th scope="col">Nama</th>
              <th scope="col ">Username</th>
              <th scope="col">Email</th>
              <th scope="col">Role</th>
              <th scope="col">Aksi</th>
            </tr>
            <tr data-aos="fade-up" class="tabel-sedang">
              <!-- <th scope="col">#</th> -->
              <th scope="col">Biodata</th>
              <th scope="col">Aksi</th>
            </tr>
            <!-- <tr data-aos="fade-up" class="tabel-kecil"> -->
            <!-- <th scope="col">#</th> -->
            <!-- <th scope="col">User</th> -->
            <!-- </tr> -->
          </thead>
          <tbody v-for="(user, index) in users" :key="index">
            <tr data-aos="fade-up" data-aos-delay="300" class="tabel-lebar">
              <!-- <td scope="row">{{index+1}}</td> -->
              <td>{{ user.name }}</td>
              <td>{{ user.username }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.role }}</td>
              <td>
                <i
                  class="icofont-eye-alt text-success link-i"
                  @click="onView(user.id)"
                ></i>
                <i
                  class="icofont-trash link-i text-danger"
                  @click="onDelete(user.id)"
                ></i>
              </td>
            </tr>
            <tr data-aos="fade-up" data-aos-delay="300" class="tabel-sedang">
              <!-- <td scope="row">{{index+1}}</td> -->
              <td>
                {{ user.name }} <br />
                {{ user.username }} <br />
                {{ user.email }} <br />
                {{ user.role }}
              </td>
              <td>
                <!-- <div class="col"> -->
                <div class="row">
                  <div class="col">
                    <!-- <i
                          class="icofont-eye-alt text-success link-i"
                          @click="onView(user.id)"
                        ></i> -->
                    <button @click="onView(user.id)" class="btn btn-success">
                      <i class="icofont-eye-alt"></i>
                    </button>
                  </div>
                  <div class="col">
                    <!-- <i
                          class="icofont-trash link-i text-danger"
                          @click="onDelete(user.id)"
                        ></i> -->
                    <button @click="onDelete(user.id)" class="btn btn-danger">
                      <i class="icofont-trash"></i>
                    </button>
                  </div>
                </div>
                <!-- </div> -->
              </td>
            </tr>
            <tr data-aos="fade-up" data-aos-delay="300" class="tabel-kecil">
              <!-- <td scope="row">{{index+1}}</td> -->
              <td>
                <div class="row">
                  <div class="col-md">
                    {{ user.name }} <br />
                    {{ user.username }} <br />
                    {{ user.email }}<br />
                    {{ user.role }}
                  </div>
                  <div class="col">
                    <!-- <div class="row">
                      <div class="col"> -->
                    <!-- <i
                          class="icofont-eye-alt text-success link-i"
                          @click="onView(user.id)"
                        ></i> -->
                    <button @click="onView(user.id)" class="btn btn-success">
                      <i class="icofont-eye-alt"></i>
                    </button>
                    <!-- </div>
                      <div class="col"> -->
                    <!-- <i
                          class="icofont-trash link-i text-danger"
                          @click="onDelete(user.id)"
                        ></i> -->
                    <button @click="onDelete(user.id)" class="btn btn-danger">
                      <i class="icofont-trash"></i>
                    </button>
                    <!-- </div>
                    </div> -->
                  </div>
                </div>
              </td>
              <td></td>

              <td></td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          <!-- {{ this.users.links() }} -->
        </div>
      </div>
    </div>
    <!-- AKHIR DARI KODE UNTUK MENAMPILKAN DATA USER DALAM BENTUK TABEL -->
  </div>
</template>

<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  name: "user-list",
  props: ["users", "parent"],
  data() {
    return {
      update: false,
      errors: [],
      id: "",
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
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
    }),
  },
  mounted() {
    // console.log(this.users);
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    onDelete(id) {
      this.$confirm({
        message: "Yakin akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            this.setSpinner(true);
            Axios.post("auth/destroy/" + id)
              .then((response) => {
                this.parent.init();
                // console.log(response.data);
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: "Satu user: " + response.data.data.name + " sudah dihapus",
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
    onView(id) {
      // this.$router.push("/entry/update/" + id);
      this.update = true;
      // this.$router.push({ name: "userupdate", params: { userId: id } });
      this.setSpinner(true);
      Axios.get("auth/show/" + id)
        .then((response) => {
          this.id = response.data.data.id;
          this.name = response.data.data.name;
          this.username = response.data.data.username;
          this.email = response.data.data.email;
          // this.password = response.data.data.password;
          this.role = response.data.data.role;
          this.avatar = response.data.data.avatar;
          this.image = response.data.data.avatar;
          // console.log(this.avatar);
          this.setSpinner(false);
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
    onSave() {
      //Ini cara yg dipakai bila data
      //Tidak berisi format data
      // const data = {
      //   name: this.name,
      //   username: this.username,
      //   email: this.email,
      //   password: this.password,
      //   role: this.role,
      // };

      // Kode di bawah ini menggunakan form-data
      // karena berisi file avatar (foto profil)
      // form-data diisntal (npm install form-data)
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("name", this.name);
      dataQ.set("username", this.username);
      dataQ.set("email", this.email);
      dataQ.set("password", this.password);
      dataQ.set("avatar", this.avatar);
      dataQ.set("role", this.role);
      // console.log(this.avatar);
      this.setSpinner(true);
      Axios.post("auth/update/" + this.id, dataQ)
        .then((response) => {
          this.parent.init();
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Satu user: " + response.data.data.name + " sudah diedit",
            type: "success", //nilai lain, error dan success
          });
          this.update = false;
          this.setSpinner(false);
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
      this.update = false;
    },

    // METHOD UNTUK GAMBAR
    getImage(image) {
      if (this.avatar != "" && this.avatar.length > 0 && this.avatar != null) {
        return this.urlImage + "/users/" + image;
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
