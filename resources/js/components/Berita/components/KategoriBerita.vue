Í<template>
  <div class="sidebar-box" data-aos="fade-up" data-aos-delay="300">
    <div class="categories">
      <h3>Kategori</h3>
      <!-- <li v-for="(kategori, index) in kategoris" :key="index">
      <div id="accordion">
        {{kategori.nama}} 
      </div>    
      </li> -->
      <div id="accordion">
        <div class="kategori-card" v-for="(kategori, index) in kategoris" :key="index">
          <div class="kategori-header" id="headingOne">
            <h5 class="mb-0">
              <button
                class="kategori-btn kategori-btn-link"
                data-toggle="collapse"
                :data-target="'#kate' + kategori.id"
                aria-expanded="false"
                :aria-controls="kategori.nama"
              >
                {{ kategori.nama }} <!--({{ kategori.berita.length }})-->
              </button>
            </h5>
          </div>

          <div
            :id="'kate' + kategori.id"
            class="collapse"
            aria-labelledby="headingOne"
            data-parent="#accordion"
          >
            <div class="kategori-body">
              <ul>
                <li v-for="(berita, index) in kategori.berita" :key="index">
                  <router-link :to="'/berita/' + berita.post.slug" v-if="berita.post"  >
                  
                    {{ berita.judul }}
                  
                  </router-link>
                  <!-- <button @click="tampilBerita(berita.post.slug)" v-if="berita.post" class="kategori-btn-berita kategori-btn-link">
                    {{ berita.judul }}
                  </button> -->
                  <!-- <ul>
                    <li @click="tampilBerita(berita.post.id)" v-if="berita.post"> {{ berita.judul }}</li>
                  </ul> -->
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
    tampilBerita(slug) {
      if(slug){
        // Axios.get("post/show/" + post_id)
        // .then((response) => {
        //   // console.log(response.data.data)
        //   this.setNews(response.data.data)
        // })
        // .catch((error) => {
        //   this.$notify({
        //     group: "error",
        //     title: "Gagal",
        //     text: "ERROR : " + error.message,
        //     type: "error", //nilai lain, error dan success
        //   });
        // })
        this.$router.push("/berita/" + slug);
        // this.$router.go()
        // this.$router.go(this.$router.currentRoute)
      }
    },
  },
};
</script>
