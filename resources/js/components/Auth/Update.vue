<template>
  <div>
    <div class="container-fluid banner" height="50px"></div>
    
  </div>
</template>

<script>
import Axios from "axios";
export default {
  props: ["index"],
  data() {
    return {
      errors: [],
      name: "",
      username: "",
      password: "",
      email: "",
      role: "",
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    onSave() {
      const data = {
        name: this.name,
        username: this.username,
        email: this.email,
        password: this.password,
        role: this.role,
        
      };
      Axios.post("auth/register", data).then((response) => {
        // this.index.users = reponse.data;
        this.$router.push("/users");
      });
    },
    onCancel() {
      this.$router.push("/users");
    },
    init() {
      Axios.get("auth/show/" + userId).then((response) => {
        this.name = response.data.name;
      });
    },
  },
};
</script>
