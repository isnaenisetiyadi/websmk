<template>
  <section class="section">
    <div class="container-fluid banner" height="50px"></div>
    <div class="container mb-5" style="min-height: 100px">
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
      page: "",
    };
  },
  name: "guru-page",
  mounted() {
    this.loadGurus();
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    loadGurus(page) {
      this.setSpinner(true);
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
