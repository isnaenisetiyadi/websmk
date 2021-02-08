<template>
  <!-- <div
    style="padding: 0; margin: 0; float: left"
    v-bind:class="[adaJurusan ? 'display-inherit' : 'display-none']"
  > -->
    <div
      style="background-color: $f8f8f8"
      v-if="berita.post"
    >
      <div
        
        data-aos="fade-up"
        data-aos-delay="100"
      >
        <!-- {{ (adaJurusan = true) }} -->
        <div @click="tampilBerita(berita.post.id)" class="trending-post-entry">
          <!-- <a href="blog-single.html" class="d-block mb-2"> -->
          <img :src="urlImage + '/berita/' + berita.avatar" alt="Image" class="img-fluid" v-if="berita.avatar"/>
          <img :src="urlImage + '/anything.jpg'" alt="Image" class="img-fluid" v-else/>
          <div class="trending-post-text">
            <span class="trending-post-meta">
              <i class="icofont-ui-calendar"></i>
              {{ berita.created_at | formatDate }} | <i class="icofont-eye-alt"></i>
              {{ berita.post.views }}
              <!-- <a href="http://www.bitapp.id">{{ post.berita.id }}</a> -->
            </span>
            <h3>
              <a href="#">{{ berita.judul }}</a>
            </h3>
            <p>{{ berita.deskripsi | subStr }} ...</p>
            <!-- <p>
                <a href="http://btm.bitapp.id" class="trending-readmore">Selengkapnya</a>
              </p> -->
          </div>
          <!-- </a> -->
        </div>
      </div>
      <!-- <div v-else>{{ (adaJurusan = false) }}</div> -->
    </div>
  <!-- </div> -->
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
    }),
    tampilBerita(post_id) {
      if (post_id) {
        Axios.get("post/show/" + post_id)
          .then((response) => {
            // console.log(response.data.data)
            this.setNews(response.data.data);
            this.$router.push("/berita");
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Gagal",
              text: "ERROR : " + error.message,
              type: "error", //nilai lain, error dan success
            });
          });
      }
    },
  },
};
</script>
