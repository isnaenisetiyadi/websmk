<template>
  <section class="section">
    <div class="container-fluid banner" height="50px"></div>
    <JurusanTambah v-if="addJurusan" :jurusan="jurusanEdit" />
    <GuruJurusanTambah
      v-if="addGuruJurusan"
      :gurujurusan="gurujurusan"
      :jurusan_id="gurujurusan_id"
    />
    <div class="container mb-5" style="min-height: 100px">
      <div class="row">
        <!-- <GuruItem /> -->
        <div
          class="guru-container"
          v-for="(jurusan, index) in jurusans.data"
          :key="index"
        >
          <JurusanItem 
          :jurusan="jurusan" 
          :loadGuruJurusan="addGuruJurusan" 
          :warna="index"
          />
        </div>
      </div>
      <div class="mb-5">
        <!-- <pagination
          :data="gurus"
          @pagination-change-page="loadGurus"
          align="center"
        ></pagination> -->
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
import JurusanItem from "../../components/Jurusan/JurusanItem";
import JurusanTambah from "../../components/Jurusan/JurusanTambah";
import GuruJurusanTambah from "../../components/Jurusan/GuruJurusanTambah";

export default {
  components: { JurusanItem, JurusanTambah, GuruJurusanTambah },

  mounted() {
    this.loadJurusans();
  },
  data() {
    return {
      addJurusan: false,
      addGuruJurusan: false,
      jurusans: {},
      jurusanEdit: {},

      //   dari itemchild
      gurujurusan: {},
      gurujurusan_id: null,

      // memanggil fungsi gurus di child juruan item
    //   loadGuruJurusan: "",
    };
  },
  methods: {
    loadJurusans(page) {
      Axios.get("jurusans?page=" + page)
        .then((response) => {
          this.jurusans = response.data;
          this.meta = response.data.meta;
          // console.log(this.gurujurusan);
          // console.log(this.meta);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "ERROR : " + error.message,
            type: "error", //nilai lain, error dan success
          });
        });
    },
    onAdd() {
      //   console.log(this.addJurusan);
      this.addJurusan = true;
      // console.log(this.addJurusan);
    },
  },
//   watch: {
//     addGuruJurusan: function () {
//       if (this.loadGuruJurusan) {
//         this.loadGuruJurusan = "";
//       } else {
//         this.loadGuruJurusan = "Load";
//       }
//     },
//   },
};
</script>
