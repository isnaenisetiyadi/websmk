<template>
  <!-- <div>
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
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <v-layout row justify-center>
    <v-flex xs12 sm6 md4 class="pa-5 caption">
      <v-card dark>
        <v-app-bar class=" mb-5">
          <h1 class="subtitle">Sign In</h1>
        </v-app-bar>
        <v-layout class="pa-5 mb-3" row>
          <v-flex xs12>
            <v-text-field
              prepend-icon="mdi-account-outline"
              color="info"
              v-model="username"
              block
              label="Username"
              clearable
              :rules="required"
            ></v-text-field>
          </v-flex>
          <v-flex xs12>
            <v-text-field
              prepend-icon="mdi-lock-outline"
              v-model="password"
              :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
              :type="showPassword ? 'text' : 'password'"
              clearable
              label="Password"
              counter
              @click:append="showPassword = !showPassword"
            ></v-text-field>
          </v-flex>
        </v-layout>
        <v-card-actions class="d-block pa-5">
          <!-- <v-spacer></v-spacer> -->
          <v-btn  class="info d-block" @click="onSubmit()">Sign In</v-btn>
        </v-card-actions>
      </v-card>
    </v-flex>
  </v-layout>
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
      required: [(value) => !!value || "Harus diisi."],
      showPassword: false,
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
          // this.setSpinner(false);
          this.$router.push("/");
           this.$notify({
            group: "success",
            title: "Sukses",
            text: "Berhasil masuk",
            type: "success", //nilai lain, error dan success
          });
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: error.message,
            type: "error", //nilai lain, error dan success
          });
          // this.$router.push("/");
        });
    },
  },
};
</script>
