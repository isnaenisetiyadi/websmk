<template>
  <v-container class="pa-5">
    <v-layout row class="mb-3">
      <v-flex xs12 sm3 class="pa-1">
        <v-card flat>
          <v-img
            dark
            :src="'/images/organisasi/' + organisasiItem.avatar"
            v-if="organisasiItem.avatar"
          >
            <v-list-item>
              <v-list-item-content>
                <h2 class="font-weight-bold">{{ organisasiItem.nama }}</h2>
              </v-list-item-content>
            </v-list-item>
          </v-img>
          <v-img src="/images/noimage-width.png" v-else>
            <v-list-item>
              <v-list-item-content>
                <h2 class="font-weight-bold">{{ organisasiItem.nama }}</h2>
              </v-list-item-content>
            </v-list-item>
          </v-img>
          <v-card-actions>
            <v-card-text class="caption">{{ organisasiItem.deskripsi }}</v-card-text>
            <v-spacer></v-spacer>
            <ShareIt 
                :url="'organisasi/' + organisasiItem.slug"
                :title="organisasiItem.nama"
                :description="organisasiItem.deskripsi"
                />
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex xs12 sm9>
        <h1 class="subtitle overline ma-2 d-flex d-sm-none" v-if="organisasiItem.program">
          Aktifitas Organisasi
        </h1>
        <v-row class="pa-3">
          <v-flex
            xs12
            sm6
            v-for="(program, index) in organisasiItem.program"
            :key="index"
            class="pa-1"
          >
            <ProgramView :program="program" />
          </v-flex>
        </v-row>
      </v-flex>
    </v-layout>
    <h1 class="subtitle overline mt-5 mb-3">Organisasi Lain</h1>
    <v-layout row class="mb-3">
      <v-flex
        xs12
        sm4
        md3
        px-2
        mb-3
        v-for="(organisasi, index) in organisasis"
        :key="index"
      >
        <v-card
          color="grey lighten-2"
          router
          :to="'/organisasi/viewer/' + organisasi.slug"
        >
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title class="overline font-weight-bold">{{
                organisasi.nama
              }}</v-list-item-title>
              <v-list-item-subtitle class="caption font-weight-thin">{{
                organisasi.deskripsi
              }}</v-list-item-subtitle>
            </v-list-item-content>

            <v-list-item-avatar rounded color="purple lighten-5" elevation="3">
              <v-icon>mdi-eye-outline</v-icon>
            </v-list-item-avatar>
          </v-list-item>
        </v-card>
      </v-flex>
    </v-layout>
    <h1 class="subtitle overline mt-5 mb-3">Arsip Berita</h1>

    <BeritaArsip />
  </v-container>
</template>

<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
import ProgramView from "../Program/ProgramView";
import BeritaArsip from "../Berita/BeritaArsip";
import ShareIt from "../ShareNetwork/Share";
export default {
  components: {
    Trending: () => import("../Trending/Trending.vue"),
    ProgramView,
    BeritaArsip,
    ShareIt
    // KoplakItem: () => import("components/KoplakItem.vue"),
  },

  data() {
    return {
      organisasiItem: {},
      organisasis: {},
      sideMenu: true,
      rating: 4,
    };
  },
  mounted() {
    this.loadOrganisasis();
    this.viewOrganisasi();
  },
  watch: {
    $route(to, from) {
      this.viewOrganisasi();
    },
  },
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
    }),
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    loadOrganisasis() {
      Axios.get("organisasi/getAll")
        .then((response) => {
          this.organisasis = response.data;
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, error dan success
          });
        });
    },

    viewOrganisasi() {
      let { slug } = this.$route.params;
      let url = "/organisasi/slug/" + slug;
      url = encodeURI(url);
      Axios.get(url)
        .then((response) => {
          this.organisasiItem = response.data.data;
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
