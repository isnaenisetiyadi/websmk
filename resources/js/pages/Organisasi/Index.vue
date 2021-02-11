<template>
  <section class="section">
    <div class="container-fluid banner" height="50px"></div>
    <organisasi-tambah v-if="addOrganisasi" :organisasi="organisasiEdit" />
    <div class="container mb-5" style="min-height: 100px">
      <div class="row">
        <!-- <GuruItem /> -->

        <div
          class="guru-container"
          v-for="(organisasi, index) in organisasis.data"
          :key="index"
        >
          <organisasi-item :organisasi="organisasi" :warna="index" />
        </div>
      </div>
      <!-- <button @click="ujiStrVue()" class="btn btn-primary">Uji Random Str</button> -->
      <div class="mb-5">
        <pagination
          :data="organisasis"
          @pagination-change-page="loadOrganisasi"
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
import OrganisasiItem from "../../components/Organisasi/OrganisasiItem.vue";
import OrganisasiTambah from "../../components/Organisasi/OrganisasiTambah.vue";
import { mapActions } from "vuex";
export default {
  components: { OrganisasiItem, OrganisasiTambah },
  data() {
    return {
      //pemicu
      addOrganisasi: false,
      //data
      organisasis: {},
      organisasiEdit: {},
      page: "",
    };
  },
  mounted() {
    this.loadOrganisasi();
  },
  computed: {},
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    loadOrganisasi(page) {
      this.setSpinner(true);
      Axios.get("organisasis?page=" + page)
        .then((response) => {
          this.organisasis = response.data;
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
      this.addOrganisasi = true;
    },
  },
};
</script>
