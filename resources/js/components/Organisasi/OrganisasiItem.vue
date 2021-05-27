<template>
  <v-card class="mx-auto" max-width="344" v-if="organisasi">
    <v-img
      :src="'/images/organisasi/' + organisasi.avatar"
      height="150px"
      dark
      v-if="organisasi.avatar"
    >
      <v-card-title class="white--text transparent-background py-1">
        <span class="caption font-weight-bold">{{ organisasi.nama }}</span>
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
              <!-- <GuruEdit :guru="guru" @isiGuruLagi="isiGuruLagi" /> -->
              <OrganisasiEdit
                :organisasi="organisasi"
                @isiOrganisasiLagi="isiOrganisasiLagi"
              />
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
        <!-- <v-list-item-avatar size="80" color="grey">
        <img :src="'/images/organisasi/' + organisasi.avatar" v-if="organisasi.avatar" />
        <img src="/images/noimage-width.png" v-else />
      </v-list-item-avatar> -->
      </v-list-item>
    </v-img>
    <v-img src="/images/noimage-width.png" height="150px" dark v-else>
      <v-card-title class="white--text transparent-background py-1">
        <span class="caption font-weight-bold">{{ organisasi.nama }}</span>
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
              <!-- <GuruEdit :guru="guru" @isiGuruLagi="isiGuruLagi" /> -->
              <OrganisasiEdit
                :organisasi="organisasi"
                @isiOrganisasiLagi="isiOrganisasiLagi"
              />
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
        <!-- <v-list-item-avatar size="80" color="grey">
        <img :src="'/images/organisasi/' + organisasi.avatar" v-if="organisasi.avatar" />
        <img src="/images/noimage-width.png" v-else />
      </v-list-item-avatar> -->
      </v-list-item>
    </v-img>
    <v-card-actions class="py-0 my-0">
      <v-btn color="orange darken-1" text @click="show = !show"> Program Kerja </v-btn>
      <v-spacer></v-spacer>
      <ProgramAdd 
      :organisasi="organisasi"
      @isiOrganisasiLagi="isiOrganisasiLagi" 
      v-show="show" />
      <v-btn icon @click="show = !show" class="ml-0">
        <v-icon>{{ show ? "mdi-chevron-up" : "mdi-chevron-down" }}</v-icon>
      </v-btn>
    </v-card-actions>

    <v-expand-transition>
      <div v-show="show">
        <v-divider></v-divider>

        <!-- <v-card-text v-if="organisasi"> -->
        <!-- {{ berita.deskripsi }} -->
        <!-- Isi disini -->
        <div v-if="organisasi.program[0]">
          <div v-for="program in organisasi.program" :key="program.index">
            <ProgramItem 
            :programParent="program" 
            
            @isiOrganisasiLagi="isiOrganisasiLagi" />
          </div>
          
        </div>
        <!-- </v-card-text> -->
        <div v-else>
          <v-list>
            <v-list-item class="text-center">
              <v-list-item-subtitle class="caption font-weight-thin"
                >Tidak ada Program</v-list-item-subtitle
              >
            </v-list-item>
          </v-list>
        </div>
      </div>
    </v-expand-transition>
  </v-card>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Axios from "axios";
import OrganisasiEdit from "./OrganisasiEdit";
import ProgramAdd from "../Program/ProgramAdd";
import ProgramItem from "../Program/ProgramItem";
export default {
  name: "organisasi-item",
  props: ["organisasiParent"],
  components: { OrganisasiEdit, ProgramItem, ProgramAdd },
  data() {
    return {
      show: false,
      organisasi: undefined,
    };
  },
  // components: {OrganisasiAdd},
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
    }),
  },
  mounted() {
    this.organisasi = this.organisasiParent;
    // console.log(this.organisasi.program);
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    onDelete() {
      this.$confirm({
        message: "Yakin " + this.organisasi.nama + " akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            // this.setSpinner(true);
            Axios.post("organisasi/destroy/" + this.organisasi.id)
              .then((response) => {
                this.$parent.loadOrganisasi();
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: response.data.data.nama + " sudah dihapus",
                  type: "warn", //nilai lain, error dan success
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
          }
        },
      });
    },
    isiOrganisasiLagi() {
      Axios.get("organisasi/show/" + this.organisasi.id)
        .then((response) => {
          this.organisasi = response.data.data;
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: `ERROR ` + error.message,
            type: "error", //nilai lain, error dan success
          });
        });
    },
    onEdit() {
      this.$parent.addOrganisasi = true;
      this.$parent.organisasiEdit = this.organisasi;
    },
    onProgram() {
      this.$router.push("/program/entry");
    },
  },
};
</script>
