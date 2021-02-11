<template>
  <div class="col-md-12">
    <div class="row kotak-pendidikan" v-if="!isEdit">
      <div class="col-md-8">
        {{ pendidikan.jenjang }} :
        <!-- <hr /> -->
        {{ pendidikan.sekolah }}
        <hr />
        Masuk: {{ pendidikan.tahun_masuk }}
        <br />
        Lulus: {{ pendidikan.tahun_lulus }}
      </div>
      <div class="col-md-4 align-middle">
        <div class="col-sm-3 p-sm-1">
          <button @click="onEdit()" class="btn btn-success">
            <i class="icofont-edit"></i>
          </button>
        </div>
        <div class="col-sm-3 p-sm-1">
          <button @click="onDelete()" class="btn btn-danger">
            <i class="icofont-trash"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="row kotak-pendidikan" v-else>
      <div class="col-md-8">
        <input type="text" placeholder="Jenjang..." v-model="jenjang" />
        <input type="text" placeholder="Sekolah..." v-model="sekolah" />
        <input type="text" placeholder="Masuk(th)..." v-model="tahun_masuk" />
        <input type="text" placeholder="Lulus(th)..." v-model="tahun_lulus" />
      </div>
      <div class="col-md-4 align-middle">
        <div class="col-sm-3 p-sm-1">
          <button @click="onBack()" class="btn btn-primary">
            <i class="icofont-reply"></i>
          </button>
        </div>
        <div class="col-sm-3 p-sm-1">
          <button @click="onSave()" class="btn btn-success">
            <i class="icofont-save"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import { mapActions } from "vuex";
export default {
  name: "pendidikan-item",
  props: ["pendidikan"],
  data() {
    return {
      isEdit: false,
      //   data untuk form edit
      jenjang: "",
      sekolah: "",
      tahun_masuk: "",
      tahun_lulus: "",
    };
  },
  mounted() {},
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    onEdit() {
      this.isEdit = true;
      this.isiForm();
    },
    onBack() {
      this.isEdit = false;
      this.kosongkanForm();
    },
    onSave() {
      let data = {
        id: this.pendidikan.id,
        user_id: this.pendidikan.user_id,
        guru_id: this.pendidikan.guru_id,
        jenjang: this.jenjang,
        sekolah: this.sekolah,
        tahun_masuk: this.tahun_masuk,
        tahun_lulus: this.tahun_lulus,
      };
      // console.log(data);
      this.setSpinner(true);
      Axios.post("pendidikan/update/", data)
        .then((response) => {
          //   this.$parent.loadGurus();
          this.pendidikan = response.data.data;
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Pendidikan sudah diedit",
            type: "success", //nilai lain, error dan success
          });
          this.setSpinner(false);
          this.isEdit = false;
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: `ERROR ` + error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
    onDelete() {
      this.$confirm({
        message: "Yakin akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            this.setSpinner(true);
            Axios.post("pendidikan/destroy/" + this.pendidikan.id)
              .then((response) => {
                // this.$parent.loadGurus();
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: "Satu data pendidikan sudah dihapus",
                  type: "warn", //nilai lain, error dan success
                });
                this.setSpinner(false);
                this.$parent.reloadGuru();
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
    isiForm() {
      this.jenjang = this.pendidikan.jenjang;
      this.sekolah = this.pendidikan.sekolah;
      this.tahun_masuk = this.pendidikan.tahun_masuk;
      this.tahun_lulus = this.pendidikan.tahun_lulus;
    },
    kosongkanForm() {
      this.jenjang = "";
      this.sekolah = "";
      this.tahun_masuk = "";
      this.tahun_lulus = "";
    },
  },
};
</script>
