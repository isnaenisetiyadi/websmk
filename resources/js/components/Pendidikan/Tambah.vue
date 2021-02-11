<template>
  <!-- Vertically centered modal -->
  <div>
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Tambah Riwayat Pendidikan</h5>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="" class="form-label">Jenjang/ Tingkat</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Jenjang..."
                    v-model="jenjang"
                  />
                </div>
                <div class="form-group">
                  <label for="" class="form-label">Nama Sekolah</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Sekolah..."
                    v-model="sekolah"
                  />
                </div>
                <div class="form-group">
                  <label for="" class="form-label">Tahun Masuk</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="2000"
                    v-model="tahun_masuk"
                  />
                </div>
                <div class="form-group">
                  <label for="" class="form-label">Tahun Lulus</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="2000"
                    v-model="tahun_lulus"
                  />
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="onCancel()">
                  Tutup
                </button>
                <button v-on:click="onSave()" type="button" class="btn btn-success">
                  Simpan
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Axios from "axios";
export default {
  props: ["isAdd"],
  data() {
    return {
      jenjang: "",
      sekolah: "",
      tahun_masuk: "",
      tahun_lulus: "",
    };
  },
  computed: {
    ...mapGetters({
      getUser: "auth/user",
      getAddPendidikan: "addMode/mode",
    }),
  },
  mounted() {
    // console.log(this.$refs.isAdd);
  },
  methods: {
    ...mapActions({
      setPendidikanDialog: "pendidikanDialog/set",
      addPendidikan: "pendidikan/add",
      modeAddPendidikan: "addMode/set",
      setSpinner: "spinner/set",
    }),
    onCancel() {
      this.setPendidikanDialog(false);
      this.modeAddPendidikan(null);
    },
    onSave() {
      if (this.getAddPendidikan) {
        const data = {
          //   id: Math.random().toString(36).slice(10),
          user_id: this.getUser.id,
          guru_id: this.getAddPendidikan,
          jenjang: this.jenjang,
          sekolah: this.sekolah,
          tahun_masuk: this.tahun_masuk,
          tahun_lulus: this.tahun_lulus,
          //   Axios.
        };
        this.setSpinner(true);
        Axios.post("pendidikan/simpan", data)
          .then((response) => {
            this.$notify({
              group: "success",
              title: "Sukses",
              text: "Satu guru  sudah ditambah, REFRESH untuk melihat hasilnya",
              type: "success", //nilai lain, error dan success
            });
            // this.$parent.reloadGuru();
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
      } else {
        const data = {
          id: Math.random().toString(36).slice(10),
          user_id: this.getUser.id,
          guru_id: 1,
          jenjang: this.jenjang,
          sekolah: this.sekolah,
          tahun_masuk: this.tahun_masuk,
          tahun_lulus: this.tahun_lulus,
        };
        this.addPendidikan(data);
      }
      this.onCancel();
      //   this.$bus.$on('isAdd', true => {

      //   })
    },
  },
};
</script>
