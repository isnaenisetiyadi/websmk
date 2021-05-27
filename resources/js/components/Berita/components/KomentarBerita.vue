<template>
  <v-layout row class="ma-3" color="grey--text lighten-3">
    <h3 class="mb-3">{{ komentar.length }} Komentar</h3>
    <v-flex xs12 class="align-start">
      <KomentarAdd :berita="post" />
    </v-flex>

    <v-flex xs12 class="mb-2" v-for="(koment, index) in komentar" :key="index">
      <v-list-item tree-line>
        <v-list-item-avatar v-if="koment.user">
          <v-img
            :src="'images/users/' + koment.user.avatar"
            v-if="koment.user.avatar"
          ></v-img>
          <v-img src="images/noimage-close.png" v-else></v-img>
        </v-list-item-avatar>
        <v-list-item-avatar v-else>
          <v-img src="img/person-1.png"></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title class="subtitle-1 caption" v-if="koment.user">{{
            koment.user.name
          }}</v-list-item-title>
          <v-list-item-subtitle class="caption font-weight-thin"
            >{{ koment.created_at | formatDate }}
            <v-chip x-small class="mb-0" color="accent" pill>
              <v-icon small left>mdi-clock</v-icon>
              {{ koment.created_at | formatTime }}
            </v-chip>
          </v-list-item-subtitle>
          <v-list-item-subtitle>{{ koment.komen }}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </v-flex>
  </v-layout>
</template>
<script>
import Axios from "axios";
import KomentarAdd from "./KomentarAdd";
export default {
  name: "komentar-berita",
  props: ["post", "komenDariParent"],
  components: { KomentarAdd },
  data() {
    return {
      komentar: [],
      pesan: "",
    };
  },
  mounted() {
    this.loadKomentar();
  },
  methods: {
    loadKomentar() {
      Axios.get("komentar/showbyberitaid/" + this.post.id)
        .then((response) => {
          this.komentar = response.data.data;
        })
        .catch((error) => {
          console.log(error.message);
        });
    },
  },
  watch: {
    komenDariParent: function () {
      this.loadKomentar();
    },
  },
};
</script>
