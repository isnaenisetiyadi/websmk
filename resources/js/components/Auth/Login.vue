<template>
  <div>
    <div class="container-fluid banner" height="50px"></div>
    <div class="container">
      <div class="row mb-5 align-items-end">
        <div class="col-md-12" data-aos="fade-up">
          <h2>Login</h2>
        </div>
      </div>

      <div class="card mb-5" data-aos="fade-down">
        <div class="card-body">
          <div class="col-md-6 offset-md-3">
            <!-- <form v-on:submit.prevent="onSubmit"> -->
            <!-- <div class="alert alert-danger" v-if="errors.length">
                <ul class="mb-0">
                  <li v-for="(error, index) in errors" :key="index">
                    {{ error }}
                  </li>
                </ul>
              </div> -->

            <div class="form-group">
              <Label>Username</Label>
              <input
                class="form-control"
                placeholder="Username..."
                type="text"
                v-model="username"
                v-bind:class="{
                  'bg-danger-alert': errorUsername.length,
                }"
              />
              <small
                class="text-danger"
                v-for="(errorUser, index) in errorUsername"
                :key="index"
              >
                {{ errorUser }}
              </small>
            </div>
            <div class="form-group">
              <Label>Password</Label>
              <input
                class="form-control"
                placeholder="Password..."
                type="password"
                v-model="password"
              />
            </div>

            <button @click="onSubmit()" class="btn btn-success">Login</button>
            <!-- </form> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import { mapActions } from "vuex";
export default {
  name: "login",
  props: ["app"],
  data() {
    return {
      errorUsername: [],
      errorPassword: [],
      username: "",
      password: "",
    };
  },
  watch: {
    username(val) {
      if (!this.username) {
        this.errorUsername.push("Username harus diisi");
      } else {
        this.errorUsername = [];
      }
    },
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    onSubmit() {
      const data = {
        username: this.username,
        password: this.password,
      };
      this.setSpinner(true);
      Axios.post("auth/login", data)
        .then((response) => {
          this.$store.dispatch("auth/set", response.data);
          this.setSpinner(false);
          this.$router.push("/");
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, error dan success
          });
          this.$router.push("/");
        });
    },
  },
};
</script>
