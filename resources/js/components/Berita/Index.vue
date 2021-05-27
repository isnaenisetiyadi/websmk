<template>
  <div>
    <div class="v-speed-dial mt-50 d-flex d-sm-none">
      <BeritaMenuSticky floating />
    </div>
    <v-container class="pa-5">
      <v-layout row>
        <v-flex xs12 sm7 md9>
          <v-card flat tile v-if="post.berita" class="pa-5">
            <v-list-item two-line>
              <v-list-item-content>
                <v-list-item-title class="subheading font-weight-bold">
                  {{ post.berita.judul }}
                </v-list-item-title>
                <v-list-item-subtitle class="caption font-weight-thin">
                  {{ post.created_at | formatDate }}
                  <v-chip x-small class="mb-0" color="warning" pill>
                    {{ post.views }}
                    <!-- User Account -->
                    <!-- <v-icon right> mdi-account-outline </v-icon> -->
                    <v-icon small right>mdi-eye-outline</v-icon>
                  </v-chip>
                  {{ post.berita.user.name }}
                </v-list-item-subtitle>
              </v-list-item-content>
              <v-list-item-action>
                <ShareIt 
                :url="'berita/' + post.berita.slug"
                :title="post.berita.judul"
                :description="post.berita.deskripsi"
                />
              </v-list-item-action>
            </v-list-item>
            <v-divider></v-divider>

            <!-- <v-card-content> -->
            <div v-html="post.berita.konten" class="ql-editor caption"></div>
            <!-- </v-card-content> -->
            <v-divider></v-divider>
            <v-card-actions>
              <KomentarBerita :post="post.berita" :komenDariParent="loadKomentarChild" />
            </v-card-actions>
          </v-card>
        </v-flex>
        <v-flex xs12 sm5 md3>
          <v-card flat tile class="pa-5 z-back">
            <!-- <v-text overline>UJI MENU</v-text> -->
            <!-- <v-card-text oveline>UJI MENU</v-card-text> -->
            <h1 class="subtitle overline mt-5 mb-3">Kategori Berita</h1>
            <KategoriBerita />
            <h1 class="subtitle overline mt-5 mb-3">Arsip Berita</h1>
            <BeritaArsip />
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
import Axios from "axios";
import KategoriBerita from "./components/KategoriBerita.vue";
import ShareIt from "../ShareNetwork/Share";
// import KomentarBerita from "./components/KomentarBerita";
import { mapActions, mapGetters } from "vuex";
import KomentarBerita from "./components/KomentarBerita.vue";
import Trending from "../../components/Trending/Trending.vue";
import BeritaArsip from "./BeritaArsipSidemenu";
import BeritaMenuSticky from "./BeritaMenuSticky";
export default {
  components: {
    KategoriBerita,
    KomentarBerita,
    Trending,
    BeritaArsip,
    BeritaMenuSticky,
    ShareIt,
  },
  computed: {
    ...mapGetters({
      getNews: "news/post",
      getUsers: "auth/user",
    }),
  },
  data() {
    return {
      post: {},
      berita: {},
      komentar: "",
      loadKomentarChild: "",
      kategoris: {},
    };
  },

  mounted() {
    // this.init();
    // this.loadKategori();
    this.loadBerita();
    this.loadKategoris();
  },
  watch: {
    post: function () {
      if (this.loadKomentarChild) {
        this.loadKomentarChild = "";
      } else {
        this.loadKomentarChild = "Load Komenl";
      }
    },
    $route(to, from) {
      this.loadBerita();
    },
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
      setNews: "news/set",
    }),
    saveKomen() {
      var userId = null;
      if (this.getUsers) {
        userId = this.getUsers.id;
      }
      const data = {
        user_id: userId,
        berita_id: this.getNews.berita.id,
        komentar_id: null,
        komen: this.komentar,
        kategoris: {},
      };
      this.setSpinner(true);
      Axios.post("komentar/store", data)
        .then((response) => {
          // console.log(response.data);
          // this.loadKomentar();
          // this.KomentarBerita.$emit('loadKomentar');
          if (this.loadKomentarChild) {
            this.loadKomentarChild = "";
          } else {
            this.loadKomentarChild = "Load Komenl";
          }
          this.komentar = "";
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Komentar sudah terkirim (" + response.data.message + ")",
            type: "success", //nilai lain, error dan success
          });
          this.setSpinner(false);
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
    },
    loadKategoris() {
      this.setSpinner(true);
      Axios.get("kategori/showBerita")
        .then((response) => {
          this.kategoris = response.data.data;
          // console.log(this.kategoris);
          this.setSpinner(false);
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
    },
    loadBerita() {
      let { slug } = this.$route.params;
      let url = "/post/slug/" + slug;
      url = encodeURI(url);
      Axios.get(url)
        .then((response) => {
          this.post = response.data.data;
          this.$vuetify.goTo(0);
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
/* stile speed-dial */
.v-speed-dial {
  position: fixed;
  /* margin-top: 50px; */
}
.mt-30 {
  margin-top: 50px;
}
.z-back {
  z-index: 0;
}
/* akhir dari speed-dial */
</style>
