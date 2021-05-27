<template>
  <v-layout row>
    <v-flex xs12 sm4 class="mb-2 px-1" v-for="(guru, index) in gurus" :key="index">
      <v-list-item router :to="'/guru/' + guru.slug" dark class="purple lighten-1">
        <v-list-item-avatar>
          <v-img :src="'/images/guru/' + guru.avatar"></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title>{{ guru.nama }}</v-list-item-title>
          <v-list-item-subtitle class="caption font-weight-thin">{{
            guru.jabatan
          }}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </v-flex>
  </v-layout>
</template>

<script>
import Axios from "axios";
import { mapActions } from "vuex";
export default {
  props: ["gurus"],
  data() {
    return {};
  },
  mounted() {},
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    onDelete() {
      this.$confirm({
        message: "Yakin " + this.guru.nama + " akan dikeluarkan dari jurusan ini?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            const data = {
              guru_id: this.guru.pivot.guru_id,
              jurusan_id: this.guru.pivot.jurusan_id,
            };
            this.setSpinner(true);
            Axios.post("guru/excludeJurusan/", data)
              .then((response) => {
                this.$parent.loadGurus();
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: "Satu guru: " + response.data.data.nama + " sudah dihapus",
                  type: "warn", //nilai lain, error dan success
                });
                this.$parent.loadGurus();
                this.setSpinner(false);
              })
              .catch((error) => {
                this.$notify({
                  group: "error",
                  title: "Gagal",
                  text: error.message,
                  type: "error", //nilai lain, error dan success
                });
                this.setSpinner(false);
              });
          }
        },
      });
    },
  },
};
</script>
