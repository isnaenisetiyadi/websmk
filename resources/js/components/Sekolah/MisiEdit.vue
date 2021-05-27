<template>
  <div class="text-center">
    <v-btn class="warning" plain dark icon @click="sheet = !sheet">
      <v-icon>mdi-pencil</v-icon>
      <!-- <span class="caption">Berkomentar</span> -->
    </v-btn>
    <v-bottom-sheet v-model="sheet" class="primary" hide-overlay>
      <v-sheet>
        <v-toolbar dark color="warning">
          <v-btn icon dark @click="sheet = !sheet">
            <v-icon x-large>mdi-menu-down</v-icon>
          </v-btn>
          <h1 class="overline">Edit Misi</h1>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn plain @click="onSave()" :disabled="!text">
              <v-icon small>mdi-content-save</v-icon>
              <span>Simpan</span>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>

        <v-layout row class="ma-3" justify-center>
          <v-flex xs12 sm6 class="pa-2">
            <v-textarea label="Misi" v-model="text" color="info"></v-textarea>
          </v-flex>
          <v-flex xs12 sm6 class="pa-2">
            <v-card>
              <h3 class="subtitle-1">Avatar</h3>
              <v-img
                :src="'images/sekolah/' + misi.avatar"
                v-if="avatar_switch_image"
                class="text-center pa-2"
              >
                <v-btn fab class="error" @click="hapusAvatar()">
                  <v-icon>mdi-delete-outline</v-icon>
                </v-btn>
              </v-img>
              <UploadAvatar
                :max="1"
                fileError="Jenis file tidak didukung"
                uploadMsg="Tab atau Klik untuk memilih file"
                @change="rubahAvatar"
                v-else
              />
            </v-card>
          </v-flex>
        </v-layout>
      </v-sheet>
    </v-bottom-sheet>
  </div>
</template>
<script>
import Axios from "axios";
import UploadAvatar from "vue-upload-drop-images";
export default {
  props: ["misi"],
  data() {
    return {
      sheet: false,

      text: "",
      avatar: undefined,
      avatar_switch_image: "",

      role: {
        required: [(value) => !!value || "Harus diisi."],
        email: [
          (value) => {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return pattern.test(value) || "e-mail tidak valid";
          },
        ],
        avatar: [
          (value) =>
            !value || value.size < 500000 || "Ukuran file tidak boleh lebih dari 2 MB!",
        ],
      },
    };
  },
  components: { UploadAvatar },
  mounted() {
    this.isiData();
    
  },
  methods: {
    rubahAvatar(files) {
      //   console.log(files[0]);
      if (files) {
        this.avatar = files[0];
      } else {
        this.avatar = null;
      }
      //   console.log(this.avatar);
    },
    onSave() {
      let formData = require("form-data");
      let dataQ = new formData();
      dataQ.set("user_id", this.$store.state.auth.user.id);
      dataQ.set("sekolah_id", 1);
      dataQ.set("text", this.text);
      dataQ.set("avatar", this.avatar);

      // this.setSpinner(true);
      Axios.post("misi/update/" + this.misi.id, dataQ)
        .then((response) => {
          this.$notify({
            group: "success",
            title: "Sukses",
            text: response.data.message,
            type: "success", //nilai lain, error dan success
          });
          this.sheet = false;
          // this.setSpinner(false);
          this.$emit("isiMisiLagi");
          // this.kosongkanData();
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
    kosongkanData() {
      this.text = "";
    },
    hapusAvatar() {
      this.avatar_switch_image = "";
    },
    isiData() {
      this.text = this.misi.text;
      if (this.misi.avatar) {
        this.avatar_switch_image = this.misi.avatar;
      }
    },
  },
};
</script>
