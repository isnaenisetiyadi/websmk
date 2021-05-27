<template>
  <nav>
    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title class="text-uppercase grey--text">
        <span class="font-weight-light">smkn 1</span>
        <span class="font-weight-bold">mepanga</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>

      <v-btn
        plain
        color="grey"
        class="d-none d-sm-flex"
        v-if="!getUsers"
        router
        to="/entry/login"
      >
        <span>Sign In</span>
        <!-- <v-icon right>mdi-exit-to-app</v-icon> -->
      </v-btn>
      <v-btn plain color="grey" class="d-none d-sm-flex" v-else @click="logout()">
        <span>Sign Out</span>
        <v-icon right>mdi-exit-to-app</v-icon>
      </v-btn>
    </v-app-bar>

    <!-- dropdown menu -->

    <v-navigation-drawer dark v-model="drawer" app class="info">
      <v-list shaped>
        <v-layout column align-center>
          <v-flex xs12 class="mt-5 text-center">
            <v-avatar size="100" elevation="2" v-if="!getUsers">
              <!-- <img src="img/person-1.png" alt="" /> -->
              <v-icon x-large> mdi-account-circle </v-icon>
            </v-avatar>
            <v-speed-dial
              v-model="fab"
              :direction="direction"
              :open-on-hover="hover"
              :transition="transition"
              v-else
            >
              <template v-slot:activator>
                <v-btn x-large v-model="fab" color="blue darken-2" dark fab>
                  <v-icon v-if="fab"> mdi-close </v-icon>
                  <!-- <v-icon v-else> mdi-account-circle </v-icon> -->
                  <!-- <v-icon v-else> -->
                    <template v-else>

                    <v-img width="60" v-if="!getUsers.avatar" class="rounded-circle" src="img/person-1.png"></v-img>
                    <v-img width="60" v-else class="rounded-circle" :src="'/images/users/' + getUsers.avatar"></v-img>
                    </template>
                  <!-- </v-icon> -->
                </v-btn>
                <!-- <v-avatar size="100" elevation="2" fab>
                  <img src="img/person-1.png" alt="" />
                </v-avatar> -->
              </template>
              <v-btn fab dark small color="green" @click="logout()">
                <v-icon>mdi-exit-to-app</v-icon>
              </v-btn>
            </v-speed-dial>
            <!-- <p class="caption white--text mt-1">Zaki Naki</p> -->
          </v-flex>
          <v-flex xs12 class="mb-5 text-center">
            <v-btn outlined rounded class="info" overline v-if="!getUsers" router to="/entry/login">
              <span> Sign In </span>
            </v-btn>
          </v-flex>
        </v-layout>

        <v-list-item router to="/">
          <v-list-item-icon>
            <v-icon>mdi-view-dashboard-variant</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title> Beranda </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item router :to="'/berita/' + PostUtama.slug">
          <v-list-item-icon>
            <v-icon>mdi-dresser-outline</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title> Berita </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-group light prepend-icon="mdi-school">
          <template v-slot:activator>
            <v-list-item-title>Akademik</v-list-item-title>
          </template>
          <v-list-item v-for="link in akademiks" :key="link.text" router :to="link.route">
            <v-list-item-icon>
              <!-- <v-icon>{{ link.icon }}</v-icon> -->
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ link.text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
        <v-list-group light prepend-icon="mdi-book-arrow-up-outline">
          <template v-slot:activator>
            <v-list-item-title>Jurusan</v-list-item-title>
          </template>
          <v-list-item
            v-for="link in jurusans"
            :key="link.text"
            router
            :to="'/jurusan/viewer/' + link.slug"
          >
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ link.nama }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
        <v-list-group light prepend-icon="mdi-book-check-outline">
          <template v-slot:activator>
            <v-list-item-title>Organisasi</v-list-item-title>
          </template>
          <v-list-item
            v-for="link in organisasis"
            :key="link.nama"
            router
            :to="'/organisasi/viewer/' + link.slug"
          >
            <v-list-item-icon>
              <v-icon></v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ link.nama }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
        <v-list-group light prepend-icon="mdi-shape-plus" v-if="getUsers">
          <template v-slot:activator>
            <v-list-item-title>Pengaturan</v-list-item-title>
          </template>
          <v-list-item
            v-for="link in pengaturans"
            :key="link.text"
            router
            :to="link.route"
          >
            <v-list-item-icon>
              <v-icon>{{ link.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ link.text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>
  </nav>
</template>

<script>
import Axios from "axios";
import { mapGetters } from "vuex";

export default {
  name: "navbar",
  props: ["sekolah"],
  data() {
    return {
      drawer: false,
      // linkberita: "/berita/" + this.getNews.slug,
      PostUtama: {},
      jurusans: {},
      organisasis: {},
      links: [
        { icon: "mdi-view-dashboard-variant", text: "Beranda", route: "/" },
        { icon: "mdi-dresser-outline", text: "Berita", route: "/berita" },
      ],
      pengaturans: [
        { icon: "mdi-account-circle", text: "User", route: "/users" },
        { icon: "mdi-newspaper-variant-outline", text: "Berita", route: "/entry/berita" },
        { icon: "mdi-shape-outline", text: "Kategori Berita", route: "/kategori" },
        { icon: "mdi-shield-account", text: "GTK", route: "/gurus" },
        { icon: "mdi-align-horizontal-center", text: "Organisasi", route: "/organisasi/entry" },
        // { icon: "mdi-alpha-p-box-outline", text: "Program Organisasi", route: "/gudang" },
        { icon: "mdi-chair-school", text: "Identitas Sekolah", route: "/sekolah" },
      ],
      akademiks: [
        { icon: "mdi-human-male-board", text: "GTK", route: "/gtk" },
        { icon: "mdi-badge-account-outline", text: "Siswa", route: "/cash/keluar" },
      ],

      //data action button
      direction: "right",
      fab: false,
      fling: false,
      hover: false,
      tabs: null,
      top: false,
      right: true,
      bottom: true,
      left: false,
      transition: "slide-y-reverse-transition",

      // jurusans: [
      //   { icon: "mdi-wallet-giftcard", text: "TKJ", route: "/jurusan" },
      //   { icon: "mdi-tag-text-outline", text: "AKL", route: "/jurusan" },
      //   { icon: "mdi-tag-text-outline", text: "APAT", route: "/jurusan" },
      //   { icon: "mdi-tag-text-outline", text: "ATPH", route: "/jurusan" },
      // ],
      // organisasis: [
      //   { icon: "mdi-wallet-giftcard", text: "OSIS", route: "/organisasi/viewer" },
      //   { icon: "mdi-tag-text-outline", text: "Pramuka", route: "/organisasi" },
      //   { icon: "mdi-tag-text-outline", text: "Padus", route: "/organisasi" },
      //   { icon: "mdi-tag-text-outline", text: "Olahraga", route: "/organisasi" },
      //   { icon: "mdi-tag-text-outline", text: "PSHT", route: "/organisasi" },
      //   { icon: "mdi-tag-text-outline", text: "Jujitsu", route: "/organisasi" },
      // ],
    };
  },
  watch: {
    top(val) {
      this.bottom = !val;
    },
    right(val) {
      this.left = !val;
    },
    bottom(val) {
      this.top = !val;
    },
    left(val) {
      this.right = !val;
    },
  },
  computed: {
    ...mapGetters({
      getUsers: "auth/user",
      getUrl: "constant/urlImage",
      // getNews: "news/post",
    }),
    activeFab() {
      switch (this.tabs) {
        case "one":
          return { class: "purple", icon: "account_circle" };
        case "two":
          return { class: "red", icon: "edit" };
        case "three":
          return { class: "green", icon: "keyboard_arrow_up" };
        default:
          return {};
      }
    },
  },
  mounted() {
    // this.loadJurusan();
    // console.log(this.getNews)
    this.showPostUtama();
    this.showJurusans();
    this.showOrganisasis();
  },
  methods: {
    logout() {
      Axios.post("auth/logout")
        .then((response) => {
          this.$store.dispatch("auth/set", null);
          this.$router.push("/entry/login");
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Anda sudah keluar",
            type: "success", //nilai lain, error dan success
          });
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
    showPostUtama() {
      Axios.get("post/showPostUtama")
        .then((response) => {
          this.PostUtama = response.data.data;
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
    showJurusans() {
      Axios.get("jurusan/getAll")
        .then((response) => {
          this.jurusans = response.data;
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
    showOrganisasis() {
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
  },
};
</script>

<style>
/* This is for documentation purposes and will not be needed in your application */
.v-speed-dial {
  position: relative;
}

#create .v-btn--floating {
  position: relative;
}
</style>
