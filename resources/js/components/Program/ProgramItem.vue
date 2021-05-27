<template>
  <v-list class="py-0 my-0" v-if="program">
    <v-list-item class="py-0 my-0">
      <v-list-item-action class="pr-1 mx-0">
        <!-- <v-btn dark icon class="warning">
          <v-icon>mdi-pencil</v-icon>
        </v-btn> -->
        <ProgramEdit :program="program" @isiProgramLagi="isiProgramLagi" />
        <!-- <MisiEdit :misi="misi" @isiMisiLagi="isiMisiLagi" v-if="misi" /> -->
      </v-list-item-action>
      <v-list-item-content class="px-1 mx-0">
        <div class="caption">{{ program.nama }}</div>
        <v-list-item-subtitle class="caption font-weight-thin">{{
          program.deskripsi
        }}</v-list-item-subtitle>
      </v-list-item-content>
      <v-list-item-action class="pl-1 mx-0">
        <!-- <v-btn plain dark icon class="error" @click="onDelete()"> -->
        <v-btn plain dark icon class="error" @click="onDelete()">
          <v-icon>mdi-delete</v-icon>
        </v-btn>
      </v-list-item-action>
    </v-list-item>
  </v-list>
</template>
<script>
import Axios from "axios";
import ProgramEdit from "./ProgramEdit";
export default {
  props: ["programParent"],
  components: {ProgramEdit},
  data() {
    return {
      program: undefined,
    };
  },
  mounted() {
    this.program = this.programParent;
    // console.log(this.programParet);
    // console.log(this.program);
  },
  methods: {
    isiProgramLagi() {
      Axios.get("program/show/" + this.program.id)
        .then((response) => {
          this.program = response.data.data;
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
    onDelete() {
      this.$confirm({
        message: "Yakin " + this.program.nama + " akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            // this.setSpinner(true);
            Axios.post("program/destroy/" + this.program.id)
              .then((response) => {
                this.$emit("isiOrganisasiLagi");

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
  },
};
</script>
