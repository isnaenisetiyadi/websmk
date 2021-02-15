<template>
  <div class="list-group-item">
    <div v-if="!editKategori" class="input-group align-middle">
      <label for="" class="form-control">
        {{ kategori.nama }}
      </label>
      <button @click="onEdit()" class="btn btn-outline-primary" type="button">
        <i class="icofont-edit"></i>
      </button>
      <button @click="onDelete()" class="btn btn-outline-danger" type="button">
        <i class="icofont-trash"></i>
      </button>
    </div>
    <div v-if="editKategori" class="input-group align-middle">
      <input
        type="text"
        class="form-control"
        placeholder="Kategori Berita"
        aria-label="Recipient's username with two button addons"
        v-model="nama"
      />
      <button @click="onEdit()" class="btn btn-outline-primary" type="button">
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
import { mapActions } from "vuex";
export default {
  data() {
    return {
      editKategori: false,
      nama: "",
    };
  },
  props: ["kategori"],
  mounted() {
    this.nama = this.kategori.nama;
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    onEdit() {
      this.editKategori ? (this.editKategori = false) : (this.editKategori = true);
    },
    onDelete() {
      this.$confirm({
        message: "Yakin akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            this.setSpinner(true);
            Axios.post("kategori/destroy/" + this.kategori.id)
              .then((response) => {
                this.$parent.loadKategoris();
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
    onSave() {
      const data = {
        id: this.kategori.id,
        nama: this.nama,
      };
      this.setSpinner(true);
      Axios.post("kategori/update/" + this.kategori.id, data)
        .then((response) => {
          this.$parent.loadKategoris();
          this.editKategori = false;
          this.$notify({
            group: "success",
            title: "Sukses",
            text: "Satu kategori  sudah diedit",
            type: "success", //nilai lain, error dan success
          });
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "SINI Beo " + error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
  },
};
</script>
