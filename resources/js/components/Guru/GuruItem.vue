<template>
  <div>
    <div
      class="guru"
      data-toggle="collapse"
      data-aos="fade-down"
      data-aos-delay="300"
      aria-expanded="false"
      :data-target="'#gu' + guru.id"
      :id="guru.id"
    >
      <div :class="['guru-item', 'personal-item-' + warna]">
        <div v-if="!edit">
          <h6>{{ guru.nama }}</h6>
          <span>{{ guru.jabatan }}</span>
        </div>
        <div v-else>
          <h6>Edit Data Guru</h6>
          <span>{{ guru.nama }}</span>
        </div>
      </div>
      <div class="guru-avatar">
        <div v-if="!edit">
          <div v-if="guru.avatar">
            <img :src="urlImage + '/guru/' + guru.avatar" alt="" />
          </div>
        </div>
        <div v-else>
          <i class="icofont-edit"></i>
        </div>
      </div>
    </div>
    <div
      class="guru-body-container collapse"
      :id="'gu' + guru.id"
      :aria-labelledby="guru.id"
    >
      <div class="guru-body">
        <div v-if="!edit">
          <table class="table guru-table">
            <tr>
              <td>Nip</td>
              <td>{{ guru.nip }}</td>
            </tr>
            <tr>
              <td>Nuptk</td>
              <td>{{ guru.nuptk }}</td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td>{{ guru.alamat }}</td>
            </tr>
            <tr>
              <td>Email</td>
              <td>{{ guru.email }}</td>
            </tr>
            <tr>
              <td>HP</td>
              <td>{{ guru.kontak }}</td>
            </tr>
          </table>
          <div class="guru-btn-group text-right">
            <button @click="onEdit()" class="btn btn-success btn-guru">
              <i class="icofont-edit"></i>
            </button>
            <button @click="onDelete()" class="btn btn-danger btn-guru">
              <i class="icofont-trash"></i>
            </button>
          </div>
        </div>
        <div v-else>
          <table class="table guru-table">
            <tr>
              <td class="align-middle">Nama</td>
              <td>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Nama"
                  v-model="nama"
                />
              </td>
            </tr>
            <tr>
              <td class="align-middle">Nip</td>
              <td>
                <input type="text" class="form-control" placeholder="Nip" v-model="nip" />
              </td>
            </tr>
            <tr>
              <td class="align-middle">Nuptk</td>
              <td>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Nuptk"
                  v-model="nuptk"
                />
              </td>
            </tr>
            <tr>
              <td class="align-middle">Alamat</td>
              <td>
                <input
                  type="text"
                  class="form-control"
                  placeholder="alamat"
                  v-model="alamat"
                />
              </td>
            </tr>
            <tr>
              <td class="align-middle">Email</td>
              <td>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Email"
                  v-model="email"
                />
              </td>
            </tr>
            <tr>
              <td class="align-middle">HP</td>
              <td>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Kontak"
                  v-model="kontak"
                />
              </td>
            </tr>
            <tr>
              <td class="align-middle">Jabatan</td>
              <td>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Jabatan"
                  v-model="jabatan"
                />
              </td>
            </tr>
            <tr>
              <td class="align-middle">Foto</td>
              <td>
                <div>
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
                </div>
              </td>
            </tr>

            <!-- <tr>
            </tr> -->
          </table>
          <div class="col-md-12">
            <div class="row mb-5">
              <div class="ml-3 text-dark">Pendidikan</div>
              <div class="sticky top-right">
                <button @click="onAdd()">
                  <i class="icofont-ui-add"></i>
                </button>
              </div>
            </div>
            <div class="row mb-5">
              <div
                class="col-md-12"
                v-for="(pendidikan, index) in guru.pendidikan"
                :key="index"
              >
                <PendidikanItem :pendidikan="pendidikan" />
              </div>
            </div>
            <div class="guru-btn-group text-right">
              <button @click="onEdit()" class="btn btn-primary btn-guru">
                <!-- <i class="icofont-arrow-left"></i> -->
                <i class="icofont-reply"></i>
              </button>
              <button @click="onSave()" class="btn btn-success btn-guru">
                <i class="icofont-save"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- batas -->
  </div>
</template>

<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
import PendidikanItem from "../../components/Pendidikan/PendidikanItem.vue";
export default {
  components: { PendidikanItem },
  props: ["guru", "warna"],
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
    }),
  },
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
      image: "",
    };
  },

  methods: {
    ...mapActions({
      setPendidikanDialog: "pendidikanDialog/set",
      addPendidikan: "pendidikan/add",
      modeAddPendidikan: "addMode/set",
      setSpinner: "spinner/set",
    }),
    onEdit() {
      if (this.edit) {
        this.edit = false;
      } else {
        this.isiData();
        this.edit = true;
      }
    },
    onAdd() {
      this.setPendidikanDialog(true);
      // this.$refs.isAdd = false;
      this.modeAddPendidikan(this.guru.id);
    },
    onSave() {
      this.setSpinner(true);
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("id", this.guru.id);
      dataQ.set("nama", this.nama);
      dataQ.set("nip", this.nip);
      dataQ.set("nuptk", this.nuptk);
      dataQ.set("alamat", this.alamat);
      dataQ.set("email", this.email);
      dataQ.set("kontak", this.kontak);
      dataQ.set("jabatan", this.jabatan);
      dataQ.set("avatar", this.avatar);
      Axios.post("guru/update/", dataQ)
        .then((response) => {
          this.$parent.loadGurus();
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Satu guru sudah diedit",
            type: "success", //nilai lain, error dan success
          });
          this.edit = false;
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: `ERROR ` + error.message,
            type: "error", //nilai lain, error dan success
          });
        });
      this.setSpinner(false);
    },
    reloadGuru() {
      Axios.get("guru/show/" + this.guru.id)
        .then((response) => {
          // console.log(response.data.data);
          this.guru = response.data.data;
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: `ERROR ` + error.message,
            type: "error", //nilai lain, error dan success
          });
        });
    },
    onDelete() {
      this.$confirm({
        message: "Yakin akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            Axios.post("guru/destroy/" + this.guru.id)
              .then((response) => {
                this.$parent.loadGurus();
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: "Satu guru: " + response.data.data.nama + " sudah dihapus",
                  type: "warn", //nilai lain, error dan success
                });
              })
              .catch((error) => {
                this.$notify({
                  group: "error",
                  title: "Gagal",
                  text: error.message,
                  type: "error", //nilai lain, error dan success
                });
              });
          }
        },
      });
    },
    isiData() {
      this.nama = this.guru.nama;
      this.nip = this.guru.nip;
      this.nuptk = this.guru.nuptk;
      this.alamat = this.guru.alamat;
      this.email = this.guru.email;
      this.kontak = this.guru.kontak;
      this.jabatan = this.guru.jabatan;
      this.avatar = this.guru.avatar;
      this.image = this.guru.avatar;
    },
    // METHOD UNTUK GAMBAR
    getImage(image) {
      if (this.avatar != "" && this.avatar.length > 0 && this.avatar != null) {
        return this.urlImage + "/guru/" + image;
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
