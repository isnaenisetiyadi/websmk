<template>
  <div>
    <div class="container-fluid banner" height="50px"></div>
    <div class="container">
      <div class="row mb-5 align-items-end">
        <div class="col-md-12" data-aos="fade-up">
          <h2>Tambah Guru</h2>
        </div>

        <div class="col-md-12 mb-5" data-aos="fade-down">
          <div class="row border">
            <div class="col-md-6 py-md-3">
              <div class="form-group">
                <Label>Nama</Label>
                <input
                  class="form-control"
                  placeholder="Nama..."
                  type="text"
                  v-model="nama"
                />
                <small class="text-danger"> </small>
              </div>
              <div class="form-group">
                <Label>Nip</Label>
                <input
                  class="form-control"
                  placeholder="Nip..."
                  type="text"
                  v-model="nip"
                />
                <small class="text-danger"> </small>
              </div>
              <div class="form-group">
                <Label>Nuptk</Label>
                <input
                  class="form-control"
                  placeholder="Nuptk..."
                  type="text"
                  v-model="nuptk"
                />
                <small class="text-danger"> </small>
              </div>
              <div class="form-group">
                <Label>Alamat</Label>

                <textarea
                  class="form-control"
                  placeholder="Alamat..."
                  id="floatingTextarea2"
                  style="height: 100px"
                  v-model="alamat"
                ></textarea>
                <small class="text-danger"> </small>
              </div>
            </div>

            <div class="col-md-6 py-md-3">
              <div class="form-group">
                <Label>Email</Label>
                <input
                  class="form-control"
                  placeholder="Email..."
                  type="email"
                  v-model="email"
                />
                <small class="text-danger"> </small>
              </div>
              <div class="form-group">
                <Label>HP</Label>
                <input
                  class="form-control"
                  placeholder="Nomor HP..."
                  type="text"
                  v-model="kontak"
                />
                <small class="text-danger"> </small>
              </div>

              <div class="form-group">
                <Label>Jabatan</Label>
                <input
                  class="form-control"
                  placeholder="Jabatan..."
                  type="text"
                  v-model="jabatan"
                />
                <small class="text-danger"> </small>
              </div>
              <div class="form-group">
                <Label>Foto profil</Label>
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
          </div>
        </div>
        <div class="col-md-12 mb-5">
          <div class="sticky top-right">
            <button @click="onAdd()">
              <i class="icofont-ui-add"></i>
            </button>
          </div>
          <label>Pendidikan</label>
          <table class="table" v-if="pendidikans.length">
            <thead>
              <tr>
                <th scope="col">Tingkatan</th>
                <th scope="col">Sekolah/ PT</th>
                <th scope="col">Tahun Masuk</th>
                <th scope="col">Tahun Lulus</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(pendidikan, index) in pendidikans" :key="index">
                <td>{{ pendidikan.jenjang }}</td>
                <td>{{ pendidikan.sekolah }}</td>
                <td>{{ pendidikan.tahun_masuk }}</td>
                <td>{{ pendidikan.tahun_lulus }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-md-12 mb-5">
          <div class="guru-btn-group text-right">
            <button @click="onCancel()" class="btn btn-primary btn-guru">
              <!-- <i class="icofont-arrow-left"></i> -->
              <i class="icofont-reply"></i>
            </button>
            <button @click="onSave()" class="btn btn-success btn-guru">
              <i class="icofont-save"></i>
            </button>
            <!-- <button @click="onCoba()" class="btn btn-success btn-guru">
              <i class="icofont-bear-tracks"></i>
            </button> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";

export default {
  computed: {},
  data() {
    return {
      edit: false,

      nama: "",
      nip: "",
      nuptk: "",
      alamat: "",
      email: "",
      kontak: "",
      jabatan: "",
      avatar: null,
      image: "pendidikan/",
    };
  },
  mounted() {
    this.setPendidikan([]);
  },
  computed: {
    ...mapGetters({
      pendidikans: "pendidikan/pendidikans",
      getUser: "auth/user",
    }),
  },
  methods: {
    ...mapActions({
      setPendidikanDialog: "pendidikanDialog/set",
      setPendidikan: "pendidikan/set",
      setSpinner: "spinner/set",
    }),
    // METHOD UNTUK GAMBAR
    getImage(image) {
      if (this.avatar) {
        if (this.avatar != "" && this.avatar.length > 0 && this.avatar != null) {
          return this.urlImage + "/guru/" + image;
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
    onCancel() {
      this.$router.push("/gurus");
    },
    onAdd() {
      this.setPendidikanDialog(true);
    },
    onCoba() {
      console.log(this.pendidikans);
      for (let i = 0; i < this.pendidikans.length; i++) {
        console.log(this.pendidikans[i].sekolah);
      }
    },
    onSave() {
      this.setSpinner(true);
      let formData = require("form-data");
      let dataQ = new formData();
      let encodedPendidikan = JSON.stringify(this.pendidikans);
      dataQ.set("user_id", this.getUser.id);
      dataQ.set("nip", this.nip);
      dataQ.set("nuptk", this.nuptk);
      dataQ.set("nama", this.nama);
      dataQ.set("email", this.email);
      dataQ.set("alamat", this.alamat);
      dataQ.set("kontak", this.kontak);
      dataQ.set("avatar", this.avatar);
      dataQ.set("jabatan", this.jabatan);
      dataQ.set("pendidikans", encodedPendidikan);

      Axios.post("guru/store", dataQ)
        .then((response) => {
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Satu guru  sudah ditambah",
            type: "success", //nilai lain, error dan success
          });
          this.$router.push("/gurus");
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "SINI Beo " + error.message,
            type: "error", //nilai lain, error dan success
          });
        });
      this.setSpinner(false);
    },
  },
};
</script>
