<template>
  <div>
    <div class="col-md-12 py-2">
      <div class="row">
        <div class="col-md-8 px-0 d-flex align-items-center">
          <div>
            <div style="font-weight: bold; font-size: 8pt">{{ guru.nama }}</div>
            <div style="font-size: 6pt">{{ guru.jabatan }}</div>
          </div>
        </div>
        <div class="col-md-4 d-flex align-items-center text-center">
          <button @click="onDelete()" class="btn btn-danger">
            <!-- <i class="icofont-trash"></i> -->
            <!-- <i class="icofont-close-circled"></i> -->
            <i class="icofont-ui-close"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import { mapActions } from "vuex";
export default {
  props: ["guru"],
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
