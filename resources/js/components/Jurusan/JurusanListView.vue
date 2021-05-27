<template>
  <v-carousel cycle height="200" hide-delimiter-background show-arrows-on-hover>
    <v-carousel-item v-for="(jurusan, index) in jurusans" :key="index">
      <v-card color="#00ACC1" dark height="200" router :to="'/jurusan/viewer/' + jurusan.slug">
        <v-img
          class="white--text align-end"
          height="200px"
          src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
        >
        <v-card-text>

          <v-card-title>{{ jurusan.nama }}</v-card-title>
          <v-card-subtitle class="caption">{{ jurusan.deskripsi }}</v-card-subtitle>
        </v-card-text>
         <v-avatar>
             <v-icon>mdi-home</v-icon>
         </v-avatar>
        </v-img>

        
      </v-card>
    </v-carousel-item>
  </v-carousel>
</template>
<script>
export default {
    props: ["jurusans"]
}
</script>