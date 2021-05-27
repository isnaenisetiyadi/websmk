<template>
  <v-carousel cycle height="300" hide-delimiter-background show-arrows-on-hover>
    <v-carousel-item v-for="(berita, index) in beritas" :key="index">
      <v-card tile flat color="#00ACC1" dark height="300">
        <v-img
          class="white--text align-end"
          height="200px"
          :src="'images/berita/' + berita.berita.avatar"
          v-if="berita.berita.avatar"
        >
          <div class="transparent-background">
            <v-card-title>{{ berita.berita.judul }}</v-card-title>
            <v-card-subtitle>{{ berita.berita.deskripsi }}</v-card-subtitle>
          </div>
        </v-img>
        <v-img
          class="white--text align-end"
          height="200px"
          src="images/noimage-width.png"
          v-else
        >
          <div class="transparent-background">
            <v-card-title light>{{ berita.berita.judul }}</v-card-title>
            <v-card-subtitle>{{ berita.berita.deskripsi }}</v-card-subtitle>
          </div>
        </v-img>

        <v-card-text>
          <v-row align="center" justify="end">
            <v-btn outlined rounded small text router :to="'/berita/' + berita.slug">
              Selengkapnya...
            </v-btn>
            <v-spacer></v-spacer>
            <v-icon class="mr-1"> mdi-eye-outline </v-icon>
            <span class="subheading mr-2">{{ berita.views }}</span>
            <!-- <span class="mr-1">·</span>
            <v-icon class="mr-1"> mdi-share-variant </v-icon>
            <span class="subheading">45</span> -->
          </v-row>
        </v-card-text>
      </v-card>
    </v-carousel-item>
  </v-carousel>
</template>
<script>
import Axios from "axios";
export default {
  data() {
    return {
      beritas: {},
    };
  },
  mounted() {
    this.loadBerita();
  },
  methods: {
    loadBerita() {
      Axios.get("post/showRandom")
        .then((response) => {
          this.beritas = response.data.data;
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
  },
};
</script>

<style>
.transparent-background {
  background-color: rgba(0, 0, 0, 0.445);
}
</style>
