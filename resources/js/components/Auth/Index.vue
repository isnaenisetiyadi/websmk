<template>
  <v-container>
    <h1 class="subtitle overline mt-1">User</h1>
    <Register @loadUsers="loadUsers"/>
    <v-card v-for="user in users" :key="user.name" class="mb-5">
      <v-layout row class="pa-5">
        <v-flex xs12 md1 class="text-center" center>
          <v-img
            width="40"
            v-if="!user.avatar"
            class="rounded-circle float-auto"
            src="img/person-1.png"
          ></v-img>
          <v-img
            width="40"
            v-else
            class="rounded-circle"
            :src="'/images/users/' + user.avatar"
          ></v-img>
        </v-flex>
        <v-flex xs6 md3>
          <div class="caption grey--text d-none d-sm-flex">Nama</div>
          <div class="caption">{{ user.name }}</div>
        </v-flex>
        <v-flex xs6 md3>
          <div class="caption grey--text d-none d-sm-flex">Login</div>
          <div class="caption">{{ user.username }}</div>
        </v-flex>
        <v-flex xs12 md2>
          <div class="caption grey--text d-none d-sm-flex">Akses</div>
          <div class="caption">{{ user.role }}</div>
        </v-flex>
        <v-flex xs12 class="d-flex d-sm-none mb-2">
          <v-divider></v-divider>
        </v-flex>
        <v-flex xs12 md3 class="text-center pt-1">
          <v-row>
            <v-col>
              <UserEdit :user="user" @loadUsers="loadUsers"/>
            </v-col>
            <v-col>
              <v-btn
              outlined 
              rounded
              color="error"
              @click="onDelete(user.id)"
                >
                <span>Hapus</span>
                <v-icon right>mdi-delete-outline</v-icon>
              </v-btn>
            </v-col>
          </v-row>
        </v-flex>
      </v-layout>
    </v-card>
  </v-container>
</template>

<script>
import Userlist from "./Userlist";
import Axios from "axios";
import { mapActions } from "vuex";
import Register from "./Register";
import UserEdit from "./UserEdit";
export default {
  name: "index",
  data() {
    return {
      users: [],
    };
  },
  components: {
    Userlist,
    Register,
    UserEdit,
  },
  mounted() {
    this.loadUsers();
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    loadUsers() {
      Axios.get("auth/users")
        .then((response) => {
          this.users = response.data.data;
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Gagal",
            text: "ERROR : " + error.message,
            type: "error", //nilai lain, error dan success
          });
        });
    },
    onDelete(id) {
      this.$confirm({
        message: "Yakin akan dihapus?",
        button: { no: "Tidak", yes: "Iya" },
        callback: (confirm) => {
          if (confirm) {
            
            Axios.post("auth/destroy/" + id)
              .then((response) => {
                this.loadUsers();
                // console.log(response.data);
                this.$notify({
                  group: "success",
                  title: "Sukses",
                  text: "Satu user: " + response.data.data.name + " sudah dihapus",
                  type: "warn", //nilai lain, error dan success
                });
              
              })
              .catch((error) => {
                this.$notify({
                  group: "error",
                  title: "Gagal",
                  text: error.message,
                  type: "error", //nilai lain, error dan success
                });
               
              });
          }
        },
      });
    },
  },
};
</script>
