<template>
  <!-- <v-card> -->
  <v-list class="py-0 my-0">
    <v-list-item class="py-0 my-0">
      <v-list-item-action>
        <!-- <v-btn dark icon class="warning">
            <v-icon>mdi-pencil</v-icon>
          </v-btn> -->
        <MisiEdit :misi="misi" @isiMisiLagi="isiMisiLagi" v-if="misi" />
      </v-list-item-action>
      <!-- <v-list-item-avatar tile v-if="misi.avatar" class="mr-2">
        <v-img :src="'images/sekolah/' + misi.avatar"></v-img>
      </v-list-item-avatar> -->
      <v-list-item-content>
        <!-- <v-list-item-title>Judul</v-list-item-title> -->

        <!-- <v-list-item-subtitle>{{misi.text}}</v-list-item-subtitle> -->
        <div class="caption" v-if="misi">{{ misi.text }}</div>
      </v-list-item-content>

      <v-list-item-action>
        <v-btn plain dark icon class="error" @click="onDelete()">
          <v-icon>mdi-delete</v-icon>
        </v-btn>
      </v-list-item-action>
    </v-list-item>
  </v-list>
  <!-- </v-card> -->
</template>
<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
import MisiEdit from "./MisiEdit";
export default {
  data() {
    return {
      editKategori: false,
      text: "",
      image: "",
      avatar: "",

      misi: undefined,
    };
  },
  components: { MisiEdit },
  props: ["misiParent"],
  mounted() {
    this.misi = this.misiParent;
  },
  computed: {
    ...mapGetters({
      getUser: "auth/user",
      urlImage: "constant/urlImage",
    }),
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    kosongkandata() {
      this.text = "";
      this.image = "";
      this.avatar = "";
    },
    isiMisiLagi() {
      Axios.get("misi/show/" + this.misi.id)
        .then((response) => {
          this.misi = response.data.data;
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
      this.editKategori ? (this.editKategori = false) : (this.editKategori = true);
      // this.editKategori = false;
      this.kosongkandata();
      this.init();
    },
    onDelete() {
      this.$confirm({
        message: "Yakin akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            // this.setSpinner(true);
            Axios.post("misi/destroy/" + this.misi.id)
              .then((response) => {
                this.$emit("loadSekolah");
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: "Satu misi sudah dihapus",
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
    onSave() {
      // const data = {
      //   id: this.misi.id,
      //   user_id: this.getUser.id,
      //   sekolah_id: this.misi.sekolah_id,
      //   text: this.text,
      // };
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("user_id", this.getUser.id);
      dataQ.set("sekolah_id", this.$parent.sekolah.id);
      dataQ.set("avatar", this.avatar);
      dataQ.set("text", this.text);
      this.setSpinner(true);
      Axios.post("misi/update/" + this.misi.id, dataQ)
        .then((response) => {
          this.$parent.loadSekolah();
          this.editKategori = false;
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Satu misi  sudah diedit",
            type: "success", //nilai lain, error dan success
          });
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "Backend " + error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
    // METHOD UNTUK GAMBAR
    getImage(image) {
      if (this.avatar != "" && this.avatar.length > 0 && this.avatar != null) {
        return this.urlImage + "/sekolah/" + image;
      } else {
        return image;
      }
    },
    onImageChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      this.avatar = files[0];
      if (files.length) {
        return this.createImage(files[0]);
      }
    },
    createImage(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;
      reader.onload = (e) => {
        vm.image = e.target.result;
        // this.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    removeImage() {
      // console.log(this.image);
      this.image = "";
      this.avatar = "";
    },
    onRejected(rejectedEntries) {
      this.$notify({
        group: "error",
        title: "Gagal",
        text: `${rejectedEntries.length} file(s) did not pass validation constraints`,
        type: "error", //nilai lain, error dan success
      });
    },
    // AKHIR METHOD GAMBAR
  },
};
</script>
