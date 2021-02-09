<template>
  <section class="section">
    <div class="container-fluid banner" height="50px"></div>
    <div class="container">
      <div class="row">
        <div style="width: 100%">
          <div class="list-group">
            <KategoriItem
              v-for="(kategori, index) in kategoris"
              :key="index"
              :kategori="kategori"
            />
            <KategoriAdd v-if="kategoriAdd" />
            <button @click="onAdd()" class="btn btn-outline-primary" type="button" v-else>
              <i class="icofont-plus"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import KategoriItem from "../../components/Kategori/KategoriItem.vue";
import KategoriAdd from "../../components/Kategori/KategoriAdd.vue";
import Axios from "axios";
export default {
  components: { KategoriItem, KategoriAdd },
  data() {
    return {
      kategoriAdd: false,
      kategoris: {},
    };
  },
  mounted() {
    this.loadKategoris();
  },
  methods: {
    onAdd() {
      this.kategoriAdd ? (this.kategoriAdd = false) : (this.kategoriAdd = true);
    },
    loadKategoris() {
      Axios.get("kategori/showBerita")
        .then((response) => {
          this.kategoris = response.data.data;
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
};
</script>
