<template>
  <div>
    <v-container class="pa-5">
      <v-layout row>
        <v-flex xs12 sm5 md4>
          <v-card color="grey lighten-4" text-center class="text-center ma-3 pa-2">
            <v-responsive class="pt-4">
              <v-avatar size="100" class="grey lighten-2">
                <img :src="'/images/guru/' + guruItem.avatar" v-if="guruItem.avatar" />
                <img src="/img/person-1.png" v-else />
              </v-avatar>
            </v-responsive>
            <v-card-text>
              <div class="subtitle-1">{{ guruItem.nama }}</div>
              <div class="caption grey--text">{{ guruItem.email }}</div>
            </v-card-text>
            <v-card-actions>
              <v-btn plain color="info">
                <v-icon small left>mdi-cellphone</v-icon>
                <span>{{ guruItem.kontak }}</span>
              </v-btn>
              <v-spacer></v-spacer>
              <ShareIt
                :url="'guru/' + guruItem.slug"
                :title="guruItem.nama"
                :description="'Guru dan Tenaga Kependidikan'"
              />
            </v-card-actions>
          </v-card>
        </v-flex>

        <v-flex xs12 sm7 md8>
          <v-card flat color="grey lighten-5" class="ma-3 pa-2">
            <v-row>
              <v-flex xs12 md6>
                <v-list-item two-line>
                  <v-list-item-content>
                    <v-list-item-title class="font-weight-thin">NIP</v-list-item-title>
                    <v-list-item-subtitle class="caption">{{
                      guruItem.nip
                    }}</v-list-item-subtitle>
                  </v-list-item-content>
                  <!-- <v-list-item-avatar>
                    <v-icon>mdi-pencil-box-outline</v-icon>
                  </v-list-item-avatar> -->
                  <v-list-item-content>
                    <v-list-item-title class="font-weight-thin">NUPTK</v-list-item-title>
                    <v-list-item-subtitle class="caption">{{
                      guruItem.nuptk
                    }}</v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item two-line>
                  <v-list-item-content>
                    <v-list-item-title class="font-weight-thin">Alamat</v-list-item-title>
                    <v-list-item-subtitle class="caption">
                      {{ guruItem.alamat }}
                    </v-list-item-subtitle>
                    <!-- <v-list-item-subtitle>
                                {{ Supp.alamat }}
                              </v-list-item-subtitle> -->
                  </v-list-item-content>
                </v-list-item>
              </v-flex>
              <v-flex xs12 md6>
                <v-card shaped class="grey lighten-4">
                  <v-list-item>
                    <v-list-item-content>
                      <v-icon>mdi-school</v-icon>
                    </v-list-item-content>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-content>
                      <v-list-item-title class="font-weight-bold"
                        >Pendidikan</v-list-item-title
                      >
                    </v-list-item-content>
                  </v-list-item>

                  <div v-if="guruItem.pendidikan[0]" class="pa-5">
                    <v-row
                      class="mx-4"
                      v-for="(pendidikan, index) in guruItem.pendidikan"
                      :key="index"
                    >
                      <v-flex xs2>
                        <span class="caption font-weight-bold">{{
                          pendidikan.jenjang
                        }}</span>
                      </v-flex>
                      <v-flex xs8>
                        <span class="caption">{{ pendidikan.sekolah }}</span>
                      </v-flex>
                      <v-flex xs2 class="text-right">
                        <span class="caption">{{ pendidikan.tahun_lulus }}</span>
                      </v-flex>
                    </v-row>
                  </div>
                  <div v-else class="align-center text-center pb-5 caption">
                    Tidak ada data pendidikan
                  </div>
                </v-card>
              </v-flex>
            </v-row>
          </v-card>
        </v-flex>
      </v-layout>
      <h1 class="subtitle overline mt-5 mb-3">GTK</h1>
      <Guru :gurus="gurus" />
      <h1 class="subtitle overline mt-5 mb-3">Arsip Berita</h1>

      <BeritaArsip />
    </v-container>
  </div>
</template>
<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
import Trending from "../../components/Trending/Trending.vue";
import ShareIt from "../ShareNetwork/Share";
import BeritaArsip from "../Berita/BeritaArsip";
import Guru from "../Jurusan/GuruJurusan";
export default {
  components: { Trending, BeritaArsip, Guru, ShareIt },
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
      propJurusan: "jurusan/jurusan",
    }),
  },
  data() {
    return {
      gurus: {},
      guruItem: {},
    };
  },
  mounted() {
    this.viewGuru();
    this.loadGurus();
  },
  watch: {
    $route(to, from) {
      this.viewGuru();
    },
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    init() {
      if (this.propJurusan) {
        this.jurusanItem = this.propJurusan;
      }
    },
    loadGurus() {
      this.setSpinner(true);
      Axios.get("guru/showAll")
        .then((response) => {
          this.gurus = response.data;
          // console.log(gurus);
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
    // loadGurus() {
    //   // this.setSpinner(true);
    //   Axios.get("jurusan/getAll")
    //     .then((response) => {
    //       this.jurusans = response.data;
    //       // if (!this.jurusanItem.nama) {
    //       //   this.jurusanItem = this.jurusans[0];
    //       // }
    //       // this.setSpinner(false);
    //     })
    //     .catch((error) => {
    //       this.$notify({
    //         group: "error",
    //         title: "Gagal",
    //         text: "ERROR : " + error.message,
    //         type: "error", //nilai lain, error dan success
    //       });
    //       // this.setSpinner(false);
    //     });
    // },

    viewGuru() {
      let { slug } = this.$route.params;
      let url = "/guru/slug/" + slug;
      url = encodeURI(url);
      Axios.get(url)
        .then((response) => {
          this.guruItem = response.data.data;
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
    hideMenu() {
      if (this.sideMenu) {
        this.sideMenu = false;
      } else {
        this.sideMenu = true;
      }
    },
  },
};
</script>
<style>
.sticky {
  /* position: absolute; */
  top: 0;
}
.transparent {
  opacity: 0.15;
}
.logo-latar {
  opacity: 0.15;
  z-index: 1;
  position: absolute;
  width: 30%;
}
</style>
