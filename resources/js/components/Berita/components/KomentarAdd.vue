<template>
  <div class="text-center">
    <v-btn color="info" small rounded dark @click="sheet = !sheet">
      <v-icon small>mdi-comment-plus</v-icon>
      <span class="caption">Berkomentar</span>
    </v-btn>
    <v-bottom-sheet v-model="sheet" class="primary" hide-overlay>
      <v-sheet class="text-center trans">
        <!-- <v-btn class="mt-3" plain text color="red" @click="sheet = !sheet">
          <v-icon x-large>mdi-menu-down</v-icon></v-btn
        > -->
        <v-toolbar dark color="warning">
          <v-btn icon dark @click="sheet = !sheet">
            <v-icon x-large>mdi-menu-down</v-icon>
          </v-btn>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn plain @click="saveKomen()" :disabled="!komen">
              <v-icon small >mdi-content-save</v-icon>
              <span>Komentari</span>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <div class="pa-3 mt-3">
          <v-layout row justify-center class="mb-3">
            <v-flex xs12 sm5 md4 class="px-2">
              <v-text-field
                prepend-icon="mdi-account-outline"
                color="info"
                v-model="nama"
                block
                label="Anda berkomentar sebagai"
                clearable
                disabled
              ></v-text-field>
            </v-flex>
            <v-flex xs12 sm5 md4 class="px-2">
              <v-textarea
                v-model="komen"
                prepend-icon="mdi-comment-outline"
                color="info"
                clearable
                autocomplete="email"
                label="Komentar"
                focused
                :rules="required"
              ></v-textarea>
            </v-flex>
          </v-layout>
        </div>
      </v-sheet>
    </v-bottom-sheet>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

import Axios from 'axios';
export default {
  props: ["berita"],
  data: () => ({

    sheet: false,
    required: [(value) => !!value || "Harus diisi."],
    nama: "",
    komen: "",
    
  }),
  computed: {
    ...mapGetters({
      getUsers: "auth/user",
    }),
    
  },
  mounted() {
    this.init();
  },
  watch: {
    keyword: function () {
      this.$parent.keyword = this.keyword;
    },
  },
  methods: {
    init() {
      if (this.getUsers)
      {
        this.nama = this.getUsers.name
      }else {
        this.nama = "Anonim"
      }
    },
    saveKomen() {
      var userId = null;
      if (this.getUsers) {
        userId = this.getUsers.id;
      }
      const data = {
        user_id: userId,
        berita_id: this.berita.id,
        komentar_id: null,
        komen: this.komen,
        kategoris: {},
      };
      // this.setSpinner(true);
      Axios.post("komentar/store", data)
        .then((response) => {
          // console.log(response.data);
          // this.loadKomentar();
          // this.KomentarBerita.$emit('loadKomentar');
          this.$parent.loadKomentar();
          this.komen = "";
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Komentar sudah terkirim (" + response.data.message + ")",
            type: "success", //nilai lain, error dan success
          });
          // this.setSpinner(false);
          this.sheet = false;
          
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "ERROR : " + error.message,
            type: "error", //nilai lain, error dan success
          });
          // this.setSpinner(false);
        });
    },
  },
};
</script>

<style>
.trans {
  opacity: 0.975;
}
</style>
