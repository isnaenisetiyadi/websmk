<template>
  <div>
    <div class="container-fluid banner" height="50px"></div>
    <Userlist :users="users" :parent="this"></Userlist>
  </div>
</template>

<script>
import Userlist from "./Userlist";
import Axios from "axios";
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
    init() {
      Axios.get("auth/users")
      .then((response)=>{
        this.users = response.data.data;
        // console.log(this.users);
      })
      .catch((error) => {
        alert(error.response.data.error);
      })
    },
  },
};
</script>
