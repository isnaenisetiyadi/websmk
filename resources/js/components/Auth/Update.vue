<template>
  <div>
    <div class="container-fluid banner" height="50px"></div>
  </div>
</template>

<script>
import Axios from "axios";
import { mapActions } from "vuex";
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
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    onSave() {
      const data = {
        name: this.name,
        username: this.username,
        email: this.email,
        password: this.password,
        role: this.role,
      };
      Axios.post("auth/register", data)
        .then((response) => {
          // this.index.users = reponse.data;
          this.$router.push("/users");
          this.setSpinner(false);
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "ERROR : " + error.message,
            type: "error", //nilai lain, error dan success
          });
          this.setSpinner(false);
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
