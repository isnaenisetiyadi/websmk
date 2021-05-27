<template>
  <div>
    <!-- <v-btn color="info" small rounded dark @click="sheet = !sheet">
      <v-icon small>mdi-comment-plus</v-icon>
      <span class="caption">Berkomentar</span>
    </v-btn> -->
    <v-card @click="sheet = !sheet">
      <v-list-item three-line>
        <v-list-item-content>
          <!-- <div class="overline mb-4">OVERLINE</div> -->
          <v-list-item-title class="subtitle-1 mb-1">{{
            program.nama
          }}</v-list-item-title>
          <v-list-item-subtitle class="caption">{{
            program.deskripsi
          }}</v-list-item-subtitle>
        </v-list-item-content>

        <v-list-item-avatar tile size="80" color="grey">
          <v-img v-if="program.avatar" :src="'/images/program/' + program.avatar">
          </v-img>
          <v-img v-else src="/images/noimage-close.png"> </v-img>
        </v-list-item-avatar>
      </v-list-item>

      <!-- <v-card-actions>
        <v-btn outlined rounded text> Button </v-btn>
      </v-card-actions> -->
    </v-card>
    <v-bottom-sheet v-model="sheet" class="primary" hide-overlay>
      <v-sheet class="text-center trans">
        <!-- <v-btn class="mt-3" plain text color="red" @click="sheet = !sheet">
          <v-icon x-large>mdi-menu-down</v-icon></v-btn
        > -->
        <v-toolbar dark color="warning">
          <v-btn icon dark @click="sheet = !sheet">
            <v-icon x-large>mdi-menu-down</v-icon>
          </v-btn>
          <v-toolbar-title class="subtitle-1"> {{ program.nama }} </v-toolbar-title>
          <!-- <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn plain @click="saveKomen()" :disabled="!komen">
              <v-icon small>mdi-content-save</v-icon>
              <span>Komentari</span>
            </v-btn>
          </v-toolbar-items> -->
        </v-toolbar>
        <div class="pa-3 mt-3">
          <v-layout row justify-center class="mb-3 pa-3">
            <div v-html="program.konten" class="ql-editor caption"></div>
          </v-layout>
        </div>
      </v-sheet>
    </v-bottom-sheet>
  </div>
</template>
<script>
export default {
  props: ["program"],
  data() {
    return {
      sheet: false,
    };
  },
};
</script>
