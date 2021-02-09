<template>
  <div class="list-group-item">
    <div class="input-group" style="margin-top: 0; margin-bottom: 0">
      <input
        type="text"
        class="form-control"
        placeholder="Kategori Berita"
        aria-label="Recipient's username with two button addons"
        v-model="nama"
      />
      <button @click="onCancel()" class="btn btn-outline-primary" type="button">
        <i class="icofont-reply"></i>
      </button>
      <button @click="onSave()" class="btn btn-outline-primary" type="button">
        <i class="icofont-save"></i>
      </button>
    </div>
  </div>
</template>
<script>
import Axios from "axios";
export default {
  data() {
    return {
      nama: "",
    };
  },
  methods: {
    onCancel() {
      this.$parent.kategoriAdd = false;
    },
    onSave() {
      const data = {
        nama: this.nama,
      };

      Axios.post("kategori/store", data)
        .then((response) => {
          this.$parent.kategoriAdd = false;
          this.$parent.loadKategoris();
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Satu kategori  sudah ditambahkan",
            type: "success", //nilai lain, error dan success
          });
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "SINI Beo " + error.message,
            type: "error", //nilai lain, error dan success
          });
        });
    },
  },
};
</script>
