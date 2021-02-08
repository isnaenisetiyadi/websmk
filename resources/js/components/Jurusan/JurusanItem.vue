<template>
  <div class="container">
    <div data-aos="fade-down" data-aos-delay="300" class="guru" :id="jurusan.id">
      <!-- <JurusanTambah v-if="addJurusan" :jurusan="jurusan" /> -->
      <div :class="['guru-item', 'personal-item-' + warna]">
        <div>
          <h6>{{ jurusan.nama }}</h6>
          <span>{{ jurusan.deskripsi | subStr23}}..</span>
        </div>
      </div>
      <div class="jurusan-avatar">
        <div v-if="jurusan.logo">
          <img :src="urlImage + '/jurusan/' + jurusan.logo" alt="" />
        </div>
        <div v-else>
          <img :src="urlImage + '/anonymous.png'" alt="" />
        </div>
      </div>
      <div class="jurusan-btn-group btn-right btn-top">
        <button
          class="btn-jurusan"
          data-toggle="collapse"
          aria-expanded="false"
          :data-target="'#ju' + jurusan.id"
        >
          <i class="icofont-user"></i>
        </button>
        <button @click="onEdit()" class="btn-jurusan" alt="Edit data jurusan">
          <i class="icofont-edit"></i>
        </button>
        <button @click="onDelete()" class="btn-jurusan">
          <i class="icofont-trash"></i>
        </button>
      </div>
    </div>
    <div
      class="guru-body-container collapse"
      :id="'ju' + jurusan.id"
      :aria-labelledby="jurusan.id"
    >
      <div class="guru-body">
        <div class="mt-3 mb-3">
          <div class="sticky bottom-left">
            <button @click="onAdd()">
              <i class="icofont-ui-add"></i>
            </button>
          </div>
          <div v-for="(guru, index) in gurus" :key="index">
            <GuruJurusan :guru="guru" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Axios from "axios";
import GuruJurusan from "../../components/Jurusan/GuruJurusan";
import JurusanTambah from "../../components/Jurusan/JurusanTambah";
export default {
  name: "jurusan-item",
  props: ["jurusan", "loadGuruJurusan","warna"],
  components: { GuruJurusan, JurusanTambah },
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
    }),
  },
  data() {
    return {
      gurus: {},
      //   addJurusan: false,
    };
  },
  mounted() {
    this.loadGurus();
  },
  methods: {
    onEdit() {
      this.$parent.addJurusan = true;
      this.$parent.jurusanEdit = this.jurusan;
      // this.addJurusan = true;
    },
    onDelete() {
      this.$confirm({
        message: "Yakin jurusan " + this.jurusan.nama + " akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            Axios.post("jurusan/destroy/" + this.jurusan.id)
              .then((response) => {
                this.$parent.loadJurusans();
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: "Satu jurusan: " + response.data.data.nama + " sudah dihapus",
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
    onAdd() {
      this.$parent.gurujurusan = this.gurus;
      this.$parent.gurujurusan_id = this.jurusan.id;
      // console.log(this.gurus);
      this.$parent.addGuruJurusan = true;
    },
    loadGurus() {
      Axios.get("jurusan/show/" + this.jurusan.id)
        .then((response) => {
          this.gurus = response.data.data[0].guru;
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
  },
  watch: {
    loadGuruJurusan: function () {
      this.loadGurus();
    },
  },
};
</script>
