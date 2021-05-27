<template>
  <v-list class="py-0 my-0" v-if="pendidikan">
    <v-list-item class="py-0 my-0">
      <v-list-item-action>
        <!-- <v-btn dark icon class="warning">
            <v-icon>mdi-pencil</v-icon>
          </v-btn> -->
        <PendidikanEdit :pendidikan="pendidikan" @isiPendidikanLagi="isiPendidikanLagi" v-if="pendidikan"/>
      </v-list-item-action>
      <v-list-item-content three-line>
        <v-list-item-title>{{ pendidikan.jenjang }}</v-list-item-title>

        <v-list-item-subtitle class="caption">{{
          pendidikan.sekolah
        }}</v-list-item-subtitle>
        <v-list-item-subtitle class="caption font-weight-thin"
          >{{ pendidikan.tahun_masuk }} -
          {{ pendidikan.tahun_lulus }}</v-list-item-subtitle
        >
      </v-list-item-content>
      <v-list-item-action>
        <v-btn plain dark icon class="error" @click="onDelete()">
          <v-icon>mdi-delete</v-icon>
        </v-btn>
      </v-list-item-action>
    </v-list-item>
  </v-list>
</template>

<script>
import Axios from "axios";
import { mapActions } from "vuex";
import PendidikanEdit from "./PendidikanEdit";
export default {
  name: "pendidikan-item",
  props: ["pendidikanParent"],
  components: { PendidikanEdit },
  data() {
    return {
      // isEdit: false,
      pendidikan: undefined,
      //   data untuk form edit
      jenjang: "",
      sekolah: "",
      tahun_masuk: "",
      tahun_lulus: "",
    };
  },
  mounted() {
    this.pendidikan = this.pendidikanParent;
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    isiPendidikanLagi() {
      Axios.get("pendidikan/show/" + this.pendidikan.id)
        .then((response) => {
          this.pendidikan = response.data.data;
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
    // onEdit() {
    //   this.isEdit = true;
    //   this.isiForm();
    // },
    // onBack() {
    //   this.isEdit = false;
    //   this.kosongkanForm();
    // },
    onSave() {
      let data = {
        user_id: this.pendidikan.user_id,
        guru_id: this.pendidikan.guru_id,
        jenjang: this.jenjang,
        sekolah: this.sekolah,
        tahun_masuk: this.tahun_masuk,
        tahun_lulus: this.tahun_lulus,
      };
      // console.log(data);
      // this.setSpinner(true);
      Axios.post("pendidikan/update/" + this.pendidikan.id, data)
        .then((response) => {
          //   this.$parent.loadGurus();
          this.pendidikan = response.data.data;
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Pendidikan sudah diedit",
            type: "success", //nilai lain, error dan success
          });
          // this.setSpinner(false);
          // this.isEdit = false;
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
    onDelete() {
      this.$confirm({
        message: "Yakin akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            // this.setSpinner(true);
            Axios.post("pendidikan/destroy/" + this.pendidikan.id)
              .then((response) => {
                // this.$parent.loadGurus();
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: "Satu data pendidikan sudah dihapus",
                  type: "warn", //nilai lain, error dan success
                });
                // this.setSpinner(false);
                this.$emit("isiGuruLagi");
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
    // isiForm() {
    //   this.jenjang = this.pendidikan.jenjang;
    //   this.sekolah = this.pendidikan.sekolah;
    //   this.tahun_masuk = this.pendidikan.tahun_masuk;
    //   this.tahun_lulus = this.pendidikan.tahun_lulus;
    // },
    kosongkanForm() {
      this.jenjang = "";
      this.sekolah = "";
      this.tahun_masuk = "";
      this.tahun_lulus = "";
    },
  },
};
</script>
