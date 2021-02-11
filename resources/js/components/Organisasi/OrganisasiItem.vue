<template>
  <div>
    <div
      class="guru"
      data-toggle="collapse"
      data-aos="fade-down"
      data-aos-delay="300"
      aria-expanded="false"
      :data-target="'#gu' + organisasi.id"
      :id="organisasi.id"
    >
      <div :class="['guru-item', 'personal-item-' + warna]">
        <div>
          <h6>{{ organisasi.nama }}</h6>
          <span>{{ organisasi.deskripsi | subStr33 }}..</span>
        </div>
      </div>
      <div class="guru-avatar">
        <div>
          <div v-if="organisasi.avatar">
            <img :src="urlImage + '/organisasi/' + organisasi.avatar" alt="" />
          </div>
          <div v-else>
            <img :src="urlImage + '/anonymous.png'" alt="" />
          </div>
        </div>
      </div>
    </div>
    <div
      class="guru-body-container collapse"
      :id="'gu' + organisasi.id"
      :aria-labelledby="organisasi.id"
    >
      <div class="guru-body">
        <div>
          <!-- <div>
             <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis ullam adipisci distinctio temporibus dolorum in quae omnis quaerat corporis, reprehenderit consectetur saepe expedita, quo natus hic dignissimos, consequuntur fugiat eaque?</p>
         </div> -->
          <div class="guru-btn-group text-right">
            <button @click="onProgram()" class="btn btn-success btn-guru">
              <i class="icofont-eye"></i>
            </button>
            <button @click="onEdit()" class="btn btn-success btn-guru">
              <i class="icofont-edit"></i>
            </button>
            <button @click="onDelete()" class="btn btn-danger btn-guru">
              <i class="icofont-trash"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- batas -->
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Axios from "axios";
export default {
  name: "organisasi-item",
  props: ["organisasi", "warna"],
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
    }),
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
            this.setSpinner(true);
            Axios.post("organisasi/destroy/" + this.organisasi.id)
              .then((response) => {
                this.$parent.loadOrganisasi();
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: response.data.data.nama + " sudah dihapus",
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
