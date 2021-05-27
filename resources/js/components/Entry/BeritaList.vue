<template>
  <v-card class="mx-auto" max-width="344" v-if="berita">
    <v-img
      :src="'images/berita/' + berita.avatar"
      height="150px"
      dark
      v-if="berita.avatar"
    >
      <v-card-title class="white--text transparent-background py-1">
        <span class="caption font-weight-bold">{{ berita.judul }}</span>

        <v-spacer></v-spacer>

        <v-menu bottom left color="rgba(0, 0, 0, 0.445)" offset-y>
          <template v-slot:activator="{ on, attrs }">
            <v-btn dark icon v-bind="attrs" v-on="on">
              <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
          </template>

          <v-list class="pa-0">
            <v-list-item class="pa-0 ma-0">
              <BeritaEdit :berita="berita" @isiBerita="isiBeritaLagi" />
            </v-list-item>
            <v-divider></v-divider>
            <v-list-item class="pa-0 ma-0">
              <v-btn color="error" plain @click="onDelete()">
                <v-icon>mdi-delete-outline</v-icon>
                <span>Hapus</span>
              </v-btn>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-card-title>
    </v-img>
    <v-img src="images/noimage-width.png" height="100px" v-else>
      <v-card-title>
        <span class="caption font-weight-bold">{{ berita.judul }}</span>

        <v-spacer></v-spacer>

        <v-menu bottom left color="rgba(0, 0, 0, 0)">
          <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-bind="attrs" v-on="on">
              <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
          </template>

          <v-list>
            <v-list-item class="ma-0">
              <!-- <v-list-item-icon>
                <v-icon>mdi-delete-outline</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Hapus</v-list-item-title> -->
              <BeritaEdit :berita="berita" />
            </v-list-item>
            <v-list-item class="ma-0">
              <!-- <v-list-item-icon>
                <v-icon>mdi-pencil-outline</v-icon>
              </v-list-item-icon>
              <v-list-item-title>Edit</v-list-item-title> -->
              <v-btn class="mt-3 mb-5" color="error" plain @click="onDelete(berita.id)">
                <v-icon>mdi-delete-outline</v-icon>
                <span>Hapus</span>
              </v-btn>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-card-title>
    </v-img>

    <v-card-actions class="py-0 my-0">
      <v-switch
        v-model="posting"
        @change="PostUnPost()"
        label="Post"
        class="subtitle"
        color="info"
      ></v-switch>
      <v-spacer></v-spacer>
      <!-- <v-btn color="orange lighten-2" text @click="show = !show"> Deskripsi </v-btn> -->

      <v-btn icon @click="show = !show">
        <v-icon>{{ show ? "mdi-chevron-up" : "mdi-chevron-down" }}</v-icon>
      </v-btn>
    </v-card-actions>

    <v-expand-transition>
      <div v-show="show">
        <v-divider></v-divider>

        <v-card-text>
          {{ berita.deskripsi }}
        </v-card-text>
      </div>
    </v-expand-transition>
  </v-card>
</template>

<script>
import { date } from "vue";
import Axios from "axios";
import BeritaEdit from "./BeritaEdit";
export default {
  name: "berita-list",
  props: ["beritaParent"],
  components: { BeritaEdit },
  data() {
    return {
      // tanggalEntry: "",
      // jamEntry: "",
      show: false,
      posting: false,
      post_id: "",
      berita: undefined,
    };
  },
  mounted() {
    // this.isiTanggalJam();
    this.berita = this.beritaParent;
    this.posting = this.berita.post;
    if (this.berita.post) {
      this.post_id = this.berita.post.id;
    }
  },
  // watch: {
  //   posting: function () {
  //     if (this.posting) {
  //       // if (!this.berita.post) {
  //       this.onPost();
  //       // }
  //     } else {
  //       this.unPost();
  //     }
  //   },
  // },
  methods: {
    isiTanggalJam() {
      // if (this.berita.created_at) {
      //   this.tanggalEntry = date.formatDate(this.berita.created_at, "DD MMMM YYYY");
      //   this.jamEntry = date.formatDate(this.berita.created_at, "HH:mm");
      // }
    },
    isiBeritaLagi() {
      Axios.get("berita/show/" + this.berita.id)
        .then((response) => {
          this.berita = response.data.data;
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.data,
            type: "error", //nilai lain, error dan success
          });
        });
    },
    onDelete() {
      this.$confirm({
        message: "Yakin akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            // this.setSpinner(true);
            Axios.post("auth/berita/destroy/" + this.berita.id)
              .then((response) => {
                // this.parent.init();
                // console.log(response.data);
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  // text: "Satu Berita: " + response.data.data.judul + " sudah dihapus",
                  text: "Satu Berita sudah dihapus",
                  type: "warning", //nilai lain, error dan success
                });
                this.$emit("isiBerita");
                // this.setSpinner(false);
              })
              .catch((error) => {
                this.$notify({
                  group: "error",
                  title: "Gagal",
                  text: error.message,
                  type: "error", //nilai lain, error dan success
                });
                // this.setSpinner(false);
              });
          }
        },
      });
    },
    PostUnPost() {
      if (this.posting) {
        this.onPost();
      } else {
        this.unPost();
      }
    },
    onPost() {
      const data = {
        user_id: this.$store.state.auth.user.id,
        berita_id: this.berita.id,
        berita_judul: this.berita.judul,
      };
      // this.setSpinner(true);
      Axios.post("auth/post/store", data)
        .then((response) => {
          // if (this.add) {
          //   this.add = false;
          // }
          this.post_id = response.data.data.id;
          this.$notify({
            group: "success",
            title: "Sukses",
            text: response.data.message,
            type: "success", //nilai lain, error dan success
          });
          // this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, error dan success
          });
          // this.setSpinner(false);
        });
    },
    unPost() {
      Axios.post("auth/post/destroy/" + this.post_id)
        .then((response) => {
          this.berita.post = {};
          this.$notify({
            group: "success",
            title: "Sukses",
            text: response.data.message,
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
  },
};
</script>
<style>
.transparent-background {
  background-color: rgba(0, 0, 0, 0.445);
}
</style>
