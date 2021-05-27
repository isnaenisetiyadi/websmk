<template>
  <v-card class="mx-auto" max-width="344" v-if="guru">
    <v-card-title class="white--text transparent-background py-1">
      <span class="caption font-weight-bold">{{ guru.nama }}</span>

      <v-spacer></v-spacer>

      <v-menu bottom left color="rgba(0, 0, 0, 0.445)" offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-btn dark icon v-bind="attrs" v-on="on">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>

        <v-list class="pa-0">
          <v-list-item class="pa-0 ma-0">
            <!-- <BeritaEdit :berita="berita" @isiBerita="isiBeritaLagi" /> -->
            <GuruEdit :guru="guru" @isiGuruLagi="isiGuruLagi" />
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
    <v-list-item three-line>
      <v-list-item-avatar size="80" color="grey">
        <img :src="'/images/guru/' + guru.avatar" v-if="guru.avatar" />
        <img src="/img/person-1.png" v-else />
      </v-list-item-avatar>
      <v-list-item-content three-line>
        <!-- <div class="overline mb-4">{{ guru.jabatan }}</div> -->
        <v-list-item-title class="overline">{{guru.jabatan}}</v-list-item-title>
        <v-list-item-title class="caption">
          {{ guru.nip }} / {{ guru.nuptk }}
        </v-list-item-title>
        <v-list-item-subtitle class="caption font-weight-thin"
          >{{ guru.alamat }} <br />
          <v-icon small>mdi-phone</v-icon>{{ guru.kontak }}</v-list-item-subtitle
        >
        <!-- <div class="overline mb-4">{{ guru.jabatan }}</div>
        <v-list-item-title class="caption mb-1">
          {{ guru.nip }} / {{ guru.nuptk }}
        </v-list-item-title>
        <v-list-item-subtitle class="caption font-weight-thin"
          >{{ guru.alamat }} <br />
          <v-icon small>mdi-phone</v-icon>{{ guru.kontak }}</v-list-item-subtitle
        > -->
      </v-list-item-content>
    </v-list-item>
    <v-card-actions class="py-0 my-0 info">
      <v-btn color="white darken-1" text @click="show = !show"> Pendidikan </v-btn>
      <v-spacer></v-spacer>
        <PendidikanAdd :guru="guru" @isiGuruLagi="isiGuruLagi" v-show="show" />
      <v-btn icon @click="show = !show">
        <v-icon>{{ show ? "mdi-chevron-up" : "mdi-chevron-down" }}</v-icon>
      </v-btn>
    </v-card-actions>

    <v-expand-transition>
      <div v-show="show">
        <!-- <v-divider></v-divider> -->

        <div v-if="guru.pendidikan[0]">
          <div v-for="pendidikan in guru.pendidikan" :key="pendidikan.index">
            <PendidikanItem :pendidikanParent="pendidikan" @isiGuruLagi="isiGuruLagi"/>
          </div>
        </div>
        <div v-else>
          <v-list>
            <v-list-item class="text-center">
              <v-list-item-subtitle class="caption font-weight-thin"
                >Tidak ada data Pendidikan</v-list-item-subtitle
              >
            </v-list-item>
          </v-list>
        </div>
      </div>
    </v-expand-transition>
  </v-card>
</template>

<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
import PendidikanItem from "../../components/Pendidikan/PendidikanItem.vue";
import PendidikanAdd from "../Pendidikan/PendidikanAdd";
import GuruEdit from "./GuruEdit";
export default {
  components: { PendidikanItem, GuruEdit, PendidikanAdd },
  props: ["guruParent"],
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
    }),
  },
  data() {
    return {
      show: false,
      guru: undefined,
    };
  },
  mounted() {
    this.guru = this.guruParent;
  },

  methods: {
    ...mapActions({
      setPendidikanDialog: "pendidikanDialog/set",
      addPendidikan: "pendidikan/add",
      modeAddPendidikan: "addMode/set",
      setSpinner: "spinner/set",
    }),

    onAdd() {
      this.setPendidikanDialog(true);
      // this.$refs.isAdd = false;
      this.modeAddPendidikan(this.guru.id);
    },
    onSave() {
      this.setSpinner(true);
      let formData = require("form-data");
      let dataQ = new formData();
      // dataQ.set("id", this.guru.id);
      dataQ.set("nama", this.nama);
      dataQ.set("nip", this.nip);
      dataQ.set("nuptk", this.nuptk);
      dataQ.set("alamat", this.alamat);
      dataQ.set("email", this.email);
      dataQ.set("kontak", this.kontak);
      dataQ.set("jabatan", this.jabatan);
      dataQ.set("avatar", this.avatar);
      Axios.post("guru/update/" + this.guru.id, dataQ)
        .then((response) => {
          this.$parent.loadGurus();
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Satu guru sudah diedit",
            type: "success", //nilai lain, error dan success
          });
          this.edit = false;
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: `ERROR ` + error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
    isiGuruLagi() {
      // this.setSpinner(true);
      Axios.get("guru/show/" + this.guru.id)

        .then((response) => {
          // console.log(response.data.data);
          this.guru = response.data.data;
          // this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: `ERROR ` + error.message,
            type: "error", //nilai lain, error dan success
          });
          // this.setSpinner(false);
        });
    },
    onDelete() {
      this.$confirm({
        message: "Yakin akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            this.setSpinner(true);
            Axios.post("guru/destroy/" + this.guru.id)
              .then((response) => {
                this.$parent.loadGurus();
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: "Satu guru: " + response.data.data.nama + " sudah dihapus",
                  type: "warn", //nilai lain, error dan success
                });
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
