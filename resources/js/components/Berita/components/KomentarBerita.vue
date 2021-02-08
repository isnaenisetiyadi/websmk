<template>
  <div class="pt-5">
    <hr />
    <h3 class="mb-5">{{ komentar.length }} Komentar</h3>
    <ul class="comment-list">
      <li v-for="(koment, index) in komentar" :key="index" class="comment">
        <div class="vcard bio">
          <img src="img/person_1.jpg" alt="Free Website Template by Free-Template.co" />
        </div>
        <div class="comment-body">
          <h3 v-if="koment.user">{{ koment.user.name }}</h3>
          <h3 v-else>Anonim</h3>
          <div class="meta">{{ koment.created_at | formatDate }} | {{ koment.created_at | formatTime }}</div>
          <p>
            {{ koment.komen }}
          </p>
          <!-- <p><a href="#" class="reply">Reply</a></p> -->
        </div>
      </li>
    </ul>
    <!-- END comment-list -->

   
  </div>
</template>
<script>
import Axios from "axios";
export default {
  name: "komentar-berita",
  props: ["post","komenDariParent"],
  data() {
    return {
      komentar: [],
      pesan:''
    };
  },
  mounted() {
    this.loadKomentar();
  },
  methods: {
    loadKomentar() {
      Axios.get("komentar/showbyberitaid/" + this.post.id)
        .then((response) => {
          this.komentar = response.data.data;
        })
        .catch((error) => {
          console.log(error.message);
        });
    },
    
  },
  watch: {
      komenDariParent : function() {
          this.loadKomentar();
      }
  }
};
</script>
