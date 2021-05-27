<template>
  <!-- <section class="section">
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
  </section> -->
  <v-container>
    <h1 class="subtitle overline mt-1 mb-2">Kategori Berita</h1>
    <div v-if="kategoris">
      <v-list class="ma-0 pa-0">
        <v-row class="ma-0 pa-0">
          <v-flex
            xs12
            sm6
            v-for="kategori in kategoris"
            :key="kategori.nama"
            class="pa-2"
          >
            <v-card class="pa-0 ma-0">
              <KategoriItem :kategori="kategori" @loadKategoris="loadKategoris" />
            </v-card>
          </v-flex>
          <v-flex xs12 sm6 class="pa-2">
            <v-card class="pa-0 ma-0" v-show="add">
              <KategoriAdd @onAdd="onAdd" @loadKategoris="loadKategoris"/>
            </v-card>
            <v-card class="pa-0 ma-0" v-show="!add">
              <v-btn @click="add = !add" block class="success pa-5">
                <v-icon large>mdi-plus</v-icon>
              </v-btn>
            </v-card>
          </v-flex>
        </v-row>
      </v-list>
    </div>
  </v-container>
</template>
<script>
import KategoriItem from "../../components/Kategori/KategoriItem.vue";
import KategoriAdd from "../../components/Kategori/KategoriAdd.vue";
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  components: { KategoriItem, KategoriAdd },
  data() {
    return {
      add: false,
      kategoris: {},
    };
  },
  mounted() {
    this.loadKategoris();
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    onAdd() {
      this.add ? (this.add = false) : (this.add = true);
    },
    loadKategoris() {
      // this.setSpinner(true);
      Axios.get("kategori/showBerita")
        .then((response) => {
          this.kategoris = response.data.data;
          // this.setSpinner(false);

        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, error dan success
          });
          // this.setSpinner(false);
        });
    },
    
  },

};
</script>
