Í
<template>
  <v-layout row>
    <v-flex xs12 class="mb-2 px-1">
      <v-expansion-panels accordion>
       
        <v-expansion-panel v-for="(kategori, index) in kategoris" :key="index">
          <v-expansion-panel-header>
            {{ kategori.nama }}
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <div v-for="(berita, index) in kategori.berita" :key="index">
              <v-list-item router :to="'/berita/' + berita.post.slug" v-if="berita.post">
                <v-list-item-title>{{ berita.judul }}</v-list-item-title>
              </v-list-item>
            </div>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-flex>
  </v-layout>
</template>

<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "kategori-berita",
  // props: ["kategori"],
  data() {
    return {
      kategoris: {},
    };
  },
  mounted() {
    this.loadKategori();
  },
  methods: {
    ...mapActions({
      setNews: "news/set",
    }),
    loadKategori() {
      Axios.get("kategori/posts")
        .then((response) => {
          this.kategoris = response.data.data;
          // console.log(this.kategoris);
        })
        .catch((error) => {
          console.log(error.message);
        });
    },
    // tampilBerita(slug) {
    //   if (slug) {

    //     this.$router.push("/berita/" + slug);

    //   }
    // },
  },
};
</script>
