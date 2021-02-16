<template>
  <section class="section">
    <div class="container-fluid banner" height="50px"></div>
    <div class="container">
      <div class="input-group mb-3">
        <input
          type="text"
          class="form-control"
          placeholder="Cari dengan nama guru"
          aria-label="Cari dengan nama guru"
          aria-describedby="basic-addon2"
          v-model="namaKeyword"
          v-on:keyup="validasiKeyboard"
        />
        <span
          class="input-group-text span-btn"
          id="basic-addon2"
          @click="loadGurus()"
        >
          <i class="icofont-search"></i>
        </span>
      </div>
    </div>
    <div class="container mb-5" style="min-height: 100px; padding-bottom: 10px">
      <div class="row">
        <!-- <GuruItem /> -->
        <div class="guru-container" v-for="(guru, index) in gurus.data" :key="index">
          <GuruItem :guru="guru" :warna="index" />
        </div>
      </div>
      <!-- <button @click="ujiStrVue()" class="btn btn-primary">Uji Random Str</button> -->
      <div class="mb-5">
        <pagination
          :data="gurus"
          @pagination-change-page="loadGurus"
          align="center"
        ></pagination>
      </div>
      <div class="sticky top-right">
        <button @click="onAdd()">
          <i class="icofont-ui-add"></i>
        </button>
      </div>
    </div>
  </section>
</template>

<script>
import Axios from "axios";
import GuruItem from "../../components/Guru/GuruItem.vue";
import { mapActions, mapGetters } from "vuex";
export default {
  components: { GuruItem },
  data() {
    return {
      gurus: {},
      page: 1,
      namaKeyword: "",
    };
  },
  watch: {
    namaKeyword: function(){
      if (!this.namaKeyword) {
        this.loadGurus();
      } 
    }
  },
  name: "guru-page",
  mounted() {
    this.loadGurus();
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    validasiKeyboard: function(e) {
      if (e.keyCode === 13) {
        this.loadGurus();
      } 
    },
    loadGurus(page) {
      this.setSpinner(true);
      // Axios.get("guru/showByName/?page=" + page + "/" + this.namaKeyword )
      let keyword = "";
      if (this.namaKeyword) {
        keyword = "/" + this.namaKeyword;
        Axios.get("guru/showByName" + keyword + "?page=" + page)
          // Axios.get("gurus?page=" + page)
          .then((response) => {
            this.gurus = response.data;
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
      } else {
        // Axios.get("guru/showByName" + keyword + "?page=" + page)
          Axios.get("gurus?page=" + page)
          .then((response) => {
            this.gurus = response.data;
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
      }
    },
    onAdd() {
      this.$router.push("/guru/tambah");
    },
    ujiStr() {
      Axios.get("ujistr")
        .then((response) => {
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error.message);
        });
    },
    ujiStrVue() {
      console.log(Math.random().toString(36).slice(10));
    },
  },
};
</script>
