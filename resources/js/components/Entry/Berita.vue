<template>
  <section class="section">
    <div class="container-fluid banner" height="50px"></div>
    <div v-if="add" class="container">
      <div class="row mb-5 align-items-end">
        <div class="col-md-12" data-aos="fade-down">
          <h2>Entry Berita</h2>
          <p class="mb-0">
            Fasilitas entry pengumuman, berita dan informasi lain untuk siswa, guru dan
            civitas akademik lainnya.
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-5 mb-md-0" data-aos="fade-down">
          <div class="row">
            <div class="col-md-6 form-group">
              <label for="name">Judul</label>
              <input
                type="text"
                v-model="judul"
                class="form-control"
                data-rule="minlen:4"
                data-msg="Please enter at least 4 chars"
              />
              <div class="validate"></div>
            </div>
            <div class="col-md-6 form-group">
              <label for="name">Kategori</label>

              <select class="form-control" v-model="kategori_id">
                <option selected value="">Kategori...</option>
                <option
                  v-for="(kategori, index) in kategoris"
                  :key="index"
                  v-bind:value="kategori.id"
                >
                  {{ kategori.nama }}
                </option>
              </select>
              <div class="validate"></div>
            </div>

            <div class="col-md-12 form-group">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md">
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
                    <div class="col-md">
                      <label for="name">Deskripsi</label>
                      <textarea
                        class="form-control"
                        v-model="deskripsi"
                        cols="30"
                        rows="5"
                        data-rule="required"
                        data-msg="Please write something for us"
                      ></textarea>
                      <div class="validate"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tampil juga di Jurusan</label>
                    <MultiSelect
                      placeholder="Pilih..."
                      v-model="jurusanDipilih"
                      mode="tags"
                      valueProp="id"
                      label="nama"
                      berit
                      :searchable="true"
                      :options="jurusans"
                      @deselect="onDeleteJurusan"
                    />
                  </div>
                  <div class="form-group">
                    <label>Tampil juga di Organisasi</label>
                    <MultiSelect
                      placeholder="Pilih..."
                      v-model="organisasiDipilih"
                      mode="tags"
                      valueProp="id"
                      label="nama"
                      :searchable="true"
                      :options="organisasis"
                      @deselect="onDeleteOrganisasi"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 form-group">
              <label for="name">Isi Berita</label>
              <quill-editor v-model="konten" :options="editorOption" class="editor" />
            </div>

            <div class="col-md-12 form-group">
              <button
                @click="onSave()"
                class="btn btn-success m-md-1"
                data-aos="fade-left"
                data-aos-delay="100"
              >
                Simpan
              </button>
              <button
                @click="onPost(id)"
                class="btn btn-success m-md-1"
                data-aos="fade-left"
                data-aos-delay="100"
                v-if="id"
              >
                Post
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
          <!-- </form> -->
        </div>
      </div>
    </div>
    <!-- KODE UNTUK MENAMPILKAN DATA USER DALAM BENTUK TABEL -->
    <div class="container">
      <div class="card mb-5">
        <div class="card-header">
          <div class="float-left card-judul" data-aos="fade-left">Post List</div>

          <div class="input-group-append float-right" data-aos="fade-right">
            <button @click="onAdd" class="btn btn-success">
              <i class="icofont-ui-add"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr data-aos="fade-up">
                <!-- <th scope="col">#</th> -->
                <th scope="col">Judul</th>
                <th scope="col">Deskripsi</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(berita, index) in beritas"
                :key="index"
                data-aos="fade-up"
                data-aos-delay="300"
              >
                <!-- <berita-list :berita="berita"/> -->
                <!-- <td scope="row">{{index+1}}</td> -->
                <td>{{ berita.judul }}</td>
                <td>{{ berita.deskripsi }}</td>
                <td>
                  {{ berita.created_at | formatDate }} <br />
                  {{ berita.created_at | formatTime }}
                </td>

                <td>
                  <i
                    class="icofont-eye-alt text-success link-i"
                    @click="onView(berita.id)"
                  ></i>
                  <i
                    class="icofont-trash link-i text-danger"
                    @click="onDelete(berita.id)"
                  ></i>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="d-flex justify-content-center">
            <!-- {{ this.users.links() }} -->
          </div>
        </div>
      </div>
    </div>
    <!-- AKHIR DARI KODE UNTUK MENAMPILKAN DATA USER DALAM BENTUK TABEL -->
  </section>
</template>

<script>
// import { VueEditor } from "vue2-editor";
import { mapGetters } from "vuex";
import Axios from "axios";
// import Multiselect from '@vueform/multiselect';
// import MultiSelect from '@vueform/multiselect'
import MultiSelect from "@vueform/multiselect/dist/multiselect.vue2.js";
export default {
  components: {
    // VueEditor,
    BeritaList: () => import("./BeritaList"),
    MultiSelect,
  },
  data() {
    return {
      id: null,
      judul: "",
      deskripsi: "",
      kategori_id: "",
      konten: "",
      add: false,
      kategoris: {},
      beritas: [],
      editorOption: {
        debug: "info",
        placeholder: "Type your post...",
        theme: "snow",
        height: "100px",
      },

      // data untuk multiselect jurusan
      jurusanDipilih: [],
      jurusans: {},

      // data untuk multiselect jurusan
      organisasiDipilih: [],
      organisasis: {},

      // data image/avatar
      image: "",
      avatar: null,
    };
  },
  mounted() {
    this.init();
  },
  computed: {
    ...mapGetters({
      // getUser: "auth/user",
      urlImage: "constant/urlImage",
    }),
  },
  methods: {
    onAdd() {
      this.add = true;
    },
    onCancel() {
      this.add = false;
      this.kosongkanData();
    },
    onSave() {
      // const data = {
      //   judul: this.judul,
      //   user_id: this.$store.state.auth.user.id, // percobaan kode
      //   kategori_id: this.kategori_id,
      //   deskripsi: this.deskripsi,
      //   konten: this.konten,
      // };

      let encodedJurusanDipilih = JSON.stringify(this.jurusanDipilih);
      let encodedOrganisasiDipilih = JSON.stringify(this.organisasiDipilih);
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("judul", this.judul);
      dataQ.set("user_id", this.$store.state.auth.user.id);
      dataQ.set("kategori_id", this.kategori_id);
      dataQ.set("deskripsi", this.deskripsi);
      dataQ.set("konten", this.konten);
      dataQ.set("jurusans", encodedJurusanDipilih);
      dataQ.set("organisasis", encodedOrganisasiDipilih);
      dataQ.set("avatar", this.avatar);

      if (this.id === null) {
        Axios.post("auth/berita/store", dataQ)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: response.data.message,
              type: "success", //nilai lain, error dan success
            });
            this.add = false;
            this.isiBerita();
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Gagal",
              text: error.message,
              type: "error", //nilai lain, error dan success
            });
          });
      } else {
        Axios.post("auth/berita/update/" + this.id, dataQ)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: response.data.message,
              type: "success", //nilai lain, error dan success
            });
            this.add = false;
            this.kosongkanData();
            this.isiBerita();
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
    init() {
      this.isiKategori();
      this.isiBerita();
      this.isiJurusan();
      this.isiOrganisasi();
    },
    isiKategori() {
      Axios.get("kategoris")
        .then((response) => {
          this.kategoris = response.data.data;
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.data,
            type: "error", //nilai lain, error dan success
          });
        });
    },
    kosongkanData() {
      this.id = null;
      this.judul = "";
      this.deskripsi = "";
      this.kategori_id = "";
      this.konten = "";
      this.image = "";
      this.avatar = null;

      // data untuk multiselect jurusan dan organisasi
      this.jurusanDipilih = [];
      this.organisasiDipilih = [];
    },
    isiBerita() {
      Axios.get("auth/berita")
        .then((response) => {
          this.beritas = response.data.data;
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, warn, error dan success
          });
        });
    },
    isiJurusan() {
      Axios.get("jurusan/getAll")
        .then((response) => {
          this.jurusans = response.data;
          // console.log(this.jurusans);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.data,
            type: "error", //nilai lain, error dan success
          });
        });
    },
    isiOrganisasi() {
      Axios.get("organisasi/getall")
        .then((response) => {
          this.organisasis = response.data;
          // console.log(this.jurusans);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.data,
            type: "error", //nilai lain, error dan success
          });
        });
    },
    onDeleteJurusan(value) {
      // console.log(value);
      // console.log(value);
      if (this.id) {
        const data = {
          berita_id: this.id,
          jurusan_id: value,
        };
        Axios.post("auth/berita/excludeJurusan", data)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: response.data.message,
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
    onDeleteOrganisasi(value) {
      // console.log(value);
      // console.log(value);
      if (this.id) {
        const data = {
          berita_id: this.id,
          organisasi_id: value,
        };
        Axios.post("auth/berita/excludeOrganisasi", data)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: response.data.message,
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
    onView(id) {
      this.id = id;
      Axios.get("auth/berita/show/" + id)
        .then((response) => {
          this.judul = response.data.data.judul;
          this.kategori_id = response.data.data.kategori_id;
          this.deskripsi = response.data.data.deskripsi;
          this.konten = response.data.data.konten;
          this.image = response.data.data.avatar;
          this.avatar = response.data.data.avatar;

          let jd = response.data.data.jurusan;
          let og = response.data.data.organisasi;

          // console.log(jd)
          this.jurusanDipilih = [];
          jd.forEach((jur) => {
            // console.log(jur.id)
            this.jurusanDipilih.push(jur.id);
          });
          this.organisasiDipilih = [];
          og.forEach((element) => {
            this.organisasiDipilih.push(element.id);
          });
          this.add = true;
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, error dan success
          });
          this.kosongkanData();
        });
    },
    onDelete(id) {
      this.$confirm({
        message: "Yakin akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            Axios.post("auth/berita/destroy/" + id)
              .then((response) => {
                this.isiBerita();
                // console.log(response.data);
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: "Satu berita: " + response.data.data.judul + " sudah dihapus",
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
    onPost(id) {
      const data = {
        user_id: this.$store.state.auth.user.id,
        berita_id: id,
      };
      Axios.post("auth/post/store", data)
        .then((response) => {
          if (this.add) {
            this.add = false;
          }
          this.$notify({
            group: "success",
            title: "Sukses",
            text: response.data.message,
            type: "success", //nilai lain, error dan success
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
    },
    // METHOD UNTUK GAMBAR
    getImage(image) {
      if (this.avatar) {
        if (this.avatar != "" && this.avatar.length > 0 && this.avatar != null) {
          return this.urlImage + "/berita/" + image;
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
  },
};
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
<style lang="scss"></style>
