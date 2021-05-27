<template>
  <v-card flat tile v-if="post.berita">
    <v-card color="grey lighten-4" flat tile height="300">
      <v-card-title class="headline"> {{ post.berita.judul }} </v-card-title>

      <!-- <v-card-subtitle>{{ post.berita.deskripsi }}</v-card-subtitle> -->
      <v-card-text>
        <v-card
          flat tile
          color="grey lighten-4"
          height="220"
          v-scroll.self="onScroll"
          class="overflow-y-auto overflow-visible wrap"
          wrap
        >
          <div v-html="post.berita.konten" class="ql-editor"></div>
          <v-card-actions>
            <v-btn outlined rounded small text router :to="'/berita/' + post.berita.slug"> Selengkapnya... </v-btn>
          </v-card-actions>
        </v-card>
      </v-card-text>
    </v-card>
  </v-card>
</template>
<script>
import Axios from "axios";
export default {
  data() {
    return {
      scrollInvoked: 0,
      post: {},
    };
  },
  mounted() {
    this.loadBerita();
  },
  methods: {
    onScroll() {
      this.scrollInvoked++;
    },
    loadBerita() {
      Axios.get("post/showUtama")
        .then((response) => {
          this.post = response.data.data;
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
/* .ql-editor {
    color: #306674;
} */

.ql-editor {
  max-height: 600px;
  overflow-y: scroll;
  /* background-color: #c5f3fc; */
}

.ql-editor h1,
.ql-editor h2,
.ql-editor h3,
.ql-editor h4 {
  color: #4d9baff3;
}

.ql-editor img {
  width: 50%;
  border-radius: 10px;
  margin-top: 10px;
  margin-bottom: 10px;
}

@media screen and (max-width: 768px) {
  .ql-editor img {
    width: 75%;
  }
}

@media screen and (max-width: 378px) {
  .ql-editor img {
    width: 100%;
  }
}

/* .ql-editor img {
    width: 50%;
    float: left;
} */

/* KODE STILE MENAMBAH KE PENAMPIL QUILL-EDITOR-TEXT*/
</style>
