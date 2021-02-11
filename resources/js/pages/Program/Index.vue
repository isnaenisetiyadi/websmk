<template>
  <section class="section">
    <div class="container-fluid banner" height="50px"></div>
    <div class="container mb-5">
      <program-tambah
        v-if="addProgram"
        :organisasis="organisasis"
        :organisasi_id="organisasi_id_child"
        :program="program"
        style="z-index: 999"
      />
      <div class="col-md-12 my-5" v-else>
        <div class="row">
          <div class="col-md-6">
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
          <div class="col-md-6">
            <div class="form-group">
              <!-- <Label>F</Label> -->
              <div class="input-group mb-3">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Nama..."
                  aria-label="Cari nama"
                  aria-describedby="basic-addon1"
                  v-model="keyword"
                />
                <span class="input-group-text" id="basic-addon1">
                  <i class="icofont-search"></i>
                </span>
              </div>

              <small class="text-danger"> </small>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="sticky top-right">
              <button @click="onAdd()">
                <i class="icofont-ui-add"></i>
              </button>
            </div>
            <table class="table table-bordered table-dark">
              <thead>
                <tr>
                  <th scope="col">Avatar</th>
                  <th scope="col">Program</th>
                  <!-- <th scope="col">Deskripsi</th> -->
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody v-for="(program, index) in programs" :key="index">
                <tr>
                  <th scope="row" rowspan="2" class="align-middle text-center">
                    <img class="avatar" :src="getImage(program.avatar)" alt="" />
                  </th>
                  <td>
                    {{ program.nama }} <br />
                    {{ program.deskripsi }}
                  </td>
                  <!-- <td>
                  </td> -->
                  <td rowspan="2">
                    <button @click="onEdit(program)" class="btn btn-success m-1">
                      <i class="icofont-eye"></i>
                    </button>
                    <button
                      @click="onDelete(program.id, program.nama)"
                      class="btn btn-danger m-1"
                    >
                      <i class="icofont-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Axios from "axios";
import ProgramTambah from "../../components/Program/ProgramTambah";
export default {
  components: { ProgramTambah },
  data() {
    return {
      program: {},
      programs: {},
      organisasis: {},
      organisasi_id: "",
      keyword: "",
      //   data untuk gambar
      image: "",
      avatar: null,

      // parameter pemicu
      addProgram: false,
    };
  },
  mounted() {
    this.loadOrganisasi();
    this.loadPrograms();
  },
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
    }),
  },

  watch: {
    organisasi_id: function () {
      this.loadPrograms();
    },
    keyword: function () {
      this.loadPrograms();
    },
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    loadOrganisasi() {
      this.setSpinner(true);
      Axios.get("organisasi/getall")
        .then((response) => {
          this.organisasis = response.data;
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
    },
    loadPrograms() {
      let data = {
        organisasi_id: this.organisasi_id,
        keyword: this.keyword,
      };
      this.setSpinner(true);
      Axios.post("program/showByOrganisasiSearch", data)
        .then((response) => {
          this.programs = response.data.data;
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
    },
    onAdd() {
      this.addProgram = true;
      if (!this.organisasi_id) {
        this.organisasi_id_child = this.program.organisasi_id;
      } else {
        this.organisasi_id_child = this.organisasi_id;
      }
    },
    onEdit(program) {
      this.addProgram = true;
      this.program = program;
      if (!this.organisasi_id) {
        this.organisasi_id_child = this.program.organisasi_id;
      } else {
        this.organisasi_id_child = this.organisasi_id;
      }
    },
    onDelete(id, nama) {
      this.$confirm({
        message: "Yakin " + nama + " akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            this.setSpinner(true);
            Axios.post("program/destroy/" + id)
              .then((response) => {
                this.loadPrograms();
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: nama + " sudah dihapus",
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
    // METHOD UNTUK GAMBAR
    getImage(image) {
      //   this.image = avatar;
      if (image) {
        if (image != "" || image.length > 0 || image != null) {
          return this.urlImage + "/program/" + image;
        } else {
          return this.urlImage + "/anonymous.png";
        }
      } else {
        return this.urlImage + "/anonymous.png";
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
  },
};
</script>
