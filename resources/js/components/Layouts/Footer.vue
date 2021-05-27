<template>
  <v-footer dark padless>
    <v-card class="flex" flat tile>
      <!-- <v-card-title class="teal text-center d-block">
        <v-row>
          <v-flex sm8 class="d-none d-sm-flex">
            <strong class="subheading my-2">Bagikan halaman ini ke sosmed kamu</strong>
          </v-flex>
          <v-flex xs12 sm4>
            <v-row>
              <v-flex xs3 v-for="icon in icons" :key="icon">
                <ShareNetwork 
                network="whatsapp"
                url="http://www.smkn1mepanga.sch.id/#/berita/titipane-gusti"
                title="Titipane Gusti"
                description="Berita tentang lagu"

                >
                <v-btn class="ma-4" dark icon>
                  <v-icon size="24px">
                    {{ icon }}
                  </v-icon>
                </v-btn>
                </ShareNetwork>
              </v-flex>
            </v-row>
          </v-flex>
        </v-row>
      </v-card-title> -->

      <v-card-text class="py-2 white--text text-center">
        {{ new Date().getFullYear() }} <strong>&copy; smkn1mepanga</strong>
      </v-card-text>
    </v-card>
  </v-footer>
</template>

<script>
export default {
  props: ["app"],
  data() {
    return {
      icons: ["mdi-facebook", "mdi-twitter", "mdi-linkedin", "mdi-instagram"],
    };
  },
};
</script>
