<template>
  <v-container>
    <h1 class="subtitle overline mt-1 mb-2">Guru</h1>
    <GuruAdd @loadGurus="loadGurus" />
    <v-layout row>
      <v-flex xs12 sm6 md4 class="pa-2" v-for="guru in gurus.data" :key="guru.nama">
        <GuruItem :guruParent="guru" />
      </v-flex>
    </v-layout>
    <v-layout row>
      <v-flex xs12>
        <div class="text-center">
          <v-pagination
            v-model="page"
            @input="loadGurus"
            :length="gurus.meta.last_page"
            v-if="gurus.data"
          ></v-pagination>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import Axios from "axios";
import GuruItem from "../../components/Guru/GuruItem.vue";
import GuruAdd from "../../components/Guru/GuruAdd";
import { mapActions, mapGetters } from "vuex";
export default {
  components: { GuruItem, GuruAdd },
  data() {
    return {
      gurus: {},
      page: 1,
      namaKeyword: "",
    };
  },
  watch: {
    namaKeyword: function () {
      if (!this.namaKeyword) {
        this.loadGurus();
      }
    },
  },
  name: "guru-page",
  mounted() {
    this.loadGurus(this.page);
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    validasiKeyboard: function (e) {
      if (e.keyCode === 13) {
        this.loadGurus();
      }
    },
    loadGurus(page) {
      // this.setSpinner(true);
      // Axios.get("guru/showByName/?page=" + page + "/" + this.namaKeyword )
      // if (this.gurus.data) {
      //   page = this.gurus.meta.last_page;
      // }
      let keyword = "";
      if (this.namaKeyword) {
        keyword = "/" + this.namaKeyword;
        Axios.get("guru/showByName" + keyword + "?page=" + page)
          // Axios.get("gurus?page=" + page)
          .then((response) => {
            this.gurus = response.data;
            // this.setSpinner(false);
            // console.log(this.gurus)
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Gagal",
              text: "ERROR : " + error.message,
              type: "error", //nilai lain, error dan success
            });
            // this.setSpinner(false);
          });
      } else {
        // Axios.get("guru/showByName" + keyword + "?page=" + page)
        Axios.get("gurus?page=" + page)
          .then((response) => {
            this.gurus = response.data;
            // this.setSpinner(false);
            // console.log(this.gurus);
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Gagal",
              text: "ERROR : " + error.message,
              type: "error", //nilai lain, error dan success
            });
            // this.setSpinner(false);
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
