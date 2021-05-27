<template>
  <div class="text-center" border z-index="99">
    <v-btn color="success" plain icon @click="sheet = !sheet">
      <v-icon large>mdi-share</v-icon>
      <!-- <span class="caption">Berkomentar</span> -->
    </v-btn>
    <v-bottom-sheet v-model="sheet" class="pa-0 ma-0" hide-overlay>
      <v-sheet class="ma-0">
        <v-layout row class="mb-0 py-2 grey lighten-2" radius justify-center>
          <v-flex xs3 sm2 md2 class="pa-2 text-center" justify-center>
            <ShareNetwork
              network="facebook"
              :url="'http://www.smkn1mepanga.sch.id/#/' + url"
              :title="title"
              :description="description"
            >
              <v-btn icon color="primary">
                <!-- <v-icon x-large>mdi-facebook</v-icon> -->
                <v-img width="40" src="/images/medsos/facebook.png"></v-img>
              </v-btn>
            </ShareNetwork>
          </v-flex>
          <v-flex xs3 sm2 md2 class="pa-2 text-center" justify-center>
            <ShareNetwork
              network="messenger"
              :url="'http://www.smkn1mepanga.sch.id/#/' + url"
              :title="title"
              :description="description"
            >
              <v-btn icon color="primary">
                <!-- <v-icon x-large>mdi-facebook</v-icon> -->
                <v-img width="40" src="/images/medsos/messenger.png"></v-img>
              </v-btn>
            </ShareNetwork>
          </v-flex>
          <v-flex xs3 sm2 md2 class="pa-2 text-center">
            <ShareNetwork
              network="whatsapp"
              :url="'http://www.smkn1mepanga.sch.id/#/' + url"
              :title="title"
              :description="description"
            >
              <v-btn icon color="success">
                <v-img width="40" src="/images/medsos/whatsapp.png"></v-img>
                <!-- <v-icon x-large>mdi-whatsapp</v-icon> -->
              </v-btn>
            </ShareNetwork>
          </v-flex>
          <v-flex xs3 sm2 md2 class="pa-2 text-center">
            <ShareNetwork
              network="telegram"
              :url="'http://www.smkn1mepanga.sch.id/#/' + url"
              :title="title"
              :description="description"
            >
              <v-btn icon color="info" elevation="2">
                <v-img width="40" src="/images/medsos/telegram.png"></v-img>
                <!-- <v-icon x-large>mdi-telegram</v-icon> -->
              </v-btn>
            </ShareNetwork>
          </v-flex>
          <v-flex xs3 sm2 md2 class="pa-2 text-center">
            <ShareNetwork
              network="twitter"
              :url="'http://www.smkn1mepanga.sch.id/#/' + url"
              :title="title"
              :description="description"
            >
              <v-btn icon color="info" elevation="2">
                <v-img width="40" src="/images/medsos/twitter.png"></v-img>
                <!-- <v-icon x-large>mdi-telegram</v-icon> -->
              </v-btn>
            </ShareNetwork>
          </v-flex>
        </v-layout>
      </v-sheet>
    </v-bottom-sheet>
  </div>
</template>
<script>
import Axios from "axios";

export default {
  props: ["url", "title", "description"],
  data() {
    return {
      sheet: false,
    };
  },
  components: {},
  mounted() {},
  methods: {},
};
</script>
