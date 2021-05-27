<template>
  <v-layout row>
    <v-flex
      xs12
      sm4
      md3
      class="mb-2 px-1"
      v-for="(berita, index) in beritas"
      :key="index"
    >
      <v-divider inset></v-divider>
      <v-list-item route :to="'/berita/' + berita.berita.slug" >
     
        <v-list-item-avatar tile>
          <v-img :src="'images/berita/' + berita.berita.avatar" v-if="berita.berita.avatar"></v-img>
          <v-img src="images/noimage-width.png" v-else></v-img>
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title v-html="berita.berita.judul"></v-list-item-title>
          <v-list-item-subtitle class="caption font-weight-thin" v-html="berita.berita.deskripsi"></v-list-item-subtitle>
          <!-- <v-list-item-subtitle class="caption" color="grey lighten-2" >{{berita.created_at | formatDate }}</v-list-item-subtitle> -->
        </v-list-item-content>

        <v-list-item-action>
          <v-list-item-action-text class="caption ">{{
            berita.created_at | formatMonth
          }}</v-list-item-action-text>
          <v-badge inline overlap color="info">
            <template v-slot:badge>
              <v-icon>mdi-eye-outline</v-icon>
            </template>

            <template>
              <v-list-item-subtitle
                color="white"
                class="caption font-weight-thin"
                v-html="berita.views"
              ></v-list-item-subtitle>
            </template>
          </v-badge>
        </v-list-item-action>
      </v-list-item>
    </v-flex>
  </v-layout>
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
