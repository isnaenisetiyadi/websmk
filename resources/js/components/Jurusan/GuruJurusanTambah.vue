<template>
  <div>
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <!-- <h5 class="modal-title">{{jurusan.id? "Edit Jurusan" : "Jurusan Baru"}}</h5> -->
                <h5 class="modal-title">Daftar Guru Kejuruan</h5>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <!-- <Label>F</Label> -->
                  <div class="input-group mb-3">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Cari..."
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

                <div class="form-group">
                  <select v-model="gurudipilih" multiple class="form-control">
                    <option v-for="(guru, index) in gurus" :key="index" :value="guru.id">
                      {{ guru.nama }}
                    </option>
                  </select>
                  <!-- {{ gurudipilih }} -->
                  <!-- <small class="text-danger"> {{ gurudipilih }}</small>
                  <small class="text-danger"> {{ gurudipilih }}</small> -->
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="onClose()">
                  <!-- Tutup -->
                  <i class="icofont-reply"></i>
                </button>
                <button v-on:click="onSave()" type="button" class="btn btn-success">
                  <i class="icofont-check"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import Axios from "axios";
import { mapGetters } from "vuex";
export default {
  props: ["gurujurusan", "jurusan_id"],
  data() {
    return {
      keyword: "",
      gurudipilih: [],
      gurus: {},
    };
  },
  computed: {
    ...mapGetters({
      getUser: "auth/user",
      urlImage: "constant/urlImage",
    }),
  },
  mounted() {
    this.loadGurus();
  },
  watch: {
    keyword: function () {
      this.loadGurus();
    },
  },
  methods: {
    loadGurus() {
      let list_id = [];
      this.gurujurusan.forEach((guru) => {
        list_id.push(guru.id);
      });
      let encodedlist_id = JSON.stringify(list_id);
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("list_id", encodedlist_id);
      dataQ.set("keyword", this.keyword);
      Axios.post("guru/getGuruJurusan", dataQ)
        .then((response) => {
          this.gurus = response.data.data;
        })
        .catch((error) => {
          // code for catch here
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, error dan success
          });
        });
    },
    onClose() {
      this.$parent.addGuruJurusan = false;
      //   this.$parent.jurusanEdit = {};
    },
    onSave() {
      if (this.gurudipilih.length) {
        //KODE UPDATE
        let encodedGuruDipilih = JSON.stringify(this.gurudipilih);
        let formData = require("form-data");
        let dataQ = new formData();
        dataQ.set("user_id", this.getUser.id);
        dataQ.set("jurusan_id", this.jurusan_id);
        dataQ.set("gurudipilih", encodedGuruDipilih);
        // console.log(dataQ);
        Axios.post("guru/includeJurusan", dataQ)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: "Guru kejuruan sudah ditambah",
              type: "success", //nilai lain, error dan success
            });
            this.onClose();
            // this.$parent.loadJurusans();
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Gagal",
              text: "SINI BRO " + error.message,
              type: "error", //nilai lain, error dan success
            });
          });
        this.onClose();
      } else {
        this.$confirm({
          message: "Tidak ada guru dipilih !",
          button: { no: "OK"},
        });
      }
    },
  },
};
</script>
