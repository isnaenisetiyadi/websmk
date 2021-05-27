<template>
  <div class="btn-absolute" >
    <v-btn fab icon dark color="indigo" @click="snackbar = true"> 
        <v-icon large>mdi-dots-vertical-circle-outline</v-icon>
    </v-btn>

    <v-snackbar v-model="snackbar" vertical top class="opacity-transparent">
      <h1 class="subtitle overline mt-5 mb-3">Kategori Berita</h1>
      <KategoriBerita />
      <template v-slot:action="{ attrs }">
        <v-btn dark text v-bind="attrs" @click="snackbar = false">
          tutup <v-icon>mdi-close-circle-outline</v-icon> 
        </v-btn>
      </template>

    </v-snackbar>
  </div>
  
</template>



<script>
import KategoriBerita from "./components/KategoriBerita";

export default {
  components: {
    KategoriBerita,
  },
  data: () => ({
    snackbar: false,
    text: "Lorem ipsum dolor sit amet",
    vertical: true,
  }),
};
</script>

<style>
    .btn-absolute {
        position: absolute;
    }
    .opacity-transparent {
        opacity: 0.9;
    }
</style>