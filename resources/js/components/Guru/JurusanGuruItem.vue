<template>
  <div class="personal" data-aos="fade-left" data-aos-delay="300">
    <div v-bind:class="['personal-item', 'personal-item-'+warna] ">
      <h5>{{guru.nama}}</h5>
      <span>{{guru.jabatan}}</span>
    </div>
    <div class="personal-logo">
      <img :src="urlImage + '/guru/' + guru.avatar" alt="" />
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "jurusan-guru-item",
  props: ["guru","warna"],
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
    }),
  },
};
</script>
