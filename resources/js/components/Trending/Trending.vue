<template>
  <!-- <div
    style="padding: 0; margin: 0; float: left"
    v-bind:class="[adaJurusan ? 'display-inherit' : 'display-none']"
  > -->
  <div style="background-color: $f8f8f8" v-if="berita.post">
    <div data-aos="fade-up" data-aos-delay="100">
      <div @click="tampilBerita(berita.post.id)" class="trending-post-entry">
        <img
          :src="urlImage + '/berita/' + berita.avatar"
          alt="Image"
          class="img-fluid"
          v-if="berita.avatar"
        />
        <img :src="urlImage + '/anything.jpg'" alt="Image" class="img-fluid" v-else />
        <div class="trending-post-text">
          <span class="trending-post-meta">
            <i class="icofont-ui-calendar"></i>
            {{ berita.created_at | formatDate }} | <i class="icofont-eye-alt"></i>
            {{ berita.post.views }}
          </span>
          <h3>
            <a href="#">{{ berita.judul }}</a>
          </h3>
          <p>{{ berita.deskripsi | subStr }} ...</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  name: "trending-item",
  props: ["berita", "jurusan_id"],
  data() {
    return {
      adaJurusan: true,
    };
  },
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
    }),
  },
  methods: {
    ...mapActions({
      setNews: "news/set",
      setSpinner: "spinner/set",
    }),
    tampilBerita(post_id) {
      if (post_id) {
        this.setSpinner(true);
        Axios.get("post/show/" + post_id)
          .then((response) => {
            this.setNews(response.data.data);
            this.setSpinner(false);
            this.$router.push("/berita");
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
      }
    },
  },
};
</script>
