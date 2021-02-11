<template>
  <div>
    <div class="container-fluid banner" height="50px"></div>
    <Userlist :users="users" :parent="this"></Userlist>
  </div>
</template>

<script>
import Userlist from "./Userlist";
import Axios from "axios";
import { mapActions } from "vuex";
export default {
  name: "index",
  data() {
    return {
      users: [],
    };
  },
  components: {
    Userlist,
  },
  mounted() {
    this.init();
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    init() {
      this.setSpinner(true);
      Axios.get("auth/users")
        .then((response) => {
          this.users = response.data.data;
          // console.log(this.users);
          this.setSpinner(false);
        })
        .catch((error) => {
          // alert(error.response.data.error);
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "ERROR : " + error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
        });
    },
  },
};
</script>
