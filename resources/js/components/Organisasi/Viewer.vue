<template>
  <section class="organisasi-section" id="hero">
    <div class="wave">
      <svg
        width="100%"
        height="355px"
        viewBox="0 0 1920 355"
        version="1.1"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
      >
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
            <path
              d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z"
              id="Path"
            ></path>
          </g>
        </g>
      </svg>
    </div>
    <!-- KODE UNTUK MENU ORGANISASI (MELAYANG) -->
    <div class="fly-mn" v-if="organisasis">
      <!-- <div v-bind:class="[isActive ? activeClass : '', errorClass]"></div> -->
      <!-- <div v-bind:class="{ active: isActive }"></div> -->
      <div class="fly-mn-left p-2" :class="[sideMenu ? 'fly-mn-80' : 'fly-mn-0']">
        <button
          v-for="(organisasi, index) in organisasis"
          :key="index"
          type="button"
          class="btn btn-gradient mb-2 btn-100"
          :class="{ 'btn-hide': !sideMenu }"
          v-on:click="viewOrganisasi(organisasi)"
        >
          {{ organisasi.nama | subStrBtn }}..
        </button>
      </div>
      <div clickable class="fly-mn-right" v-on:click="hideMenu()">
        <i class="icofont-curved-double-left icon-lg" v-if="sideMenu"></i>
        <i class="icofont-curved-double-right icon-lg" v-else></i>
      </div>
    </div>
    <!-- AKHIR DARI : KODE UNTUK MENU ORGANISASI (MELAYANG) -->

    <div class="container" v-if="organisasiItem">
      <div class="row align-items-center header">
        <div class="col-12">
          <h1 data-aos="fade-right">{{ organisasiItem.deskripsi | upperCase }}</h1>
          <h2 data-aos="fade-right">{{ organisasiItem.nama }}</h2>
          <p>{{ organisasiItem.deskripsi }}</p>

          <div class="row"></div>
        </div>
      </div>
    </div>

    <div class="container" v-if="organisasiItem">
      <div class="row">
        <!-- <div v-if="organisasiItem.program"> -->
        <div
          v-on:click="pergike()"
          class="program"
          data-aos="fade-up"
          data-aos-delay="100"
          v-for="(program, index) in organisasiItem.program"
          :key="index"
        >
          <div class="program-avatar">
            <img
              :src="urlImage + '/program/' + program.avatar"
              alt=""
              v-if="program.avatar"
            />
            <img :src="urlImage + '/anything.jpg'" alt="" v-else />
          </div>
          <div class="program-text">
            <div class="program-caption">{{ program.nama | subStr12 }}..</div>
            <div class="program-description">{{ program.deskripsi | subStr150 }}...</div>
          </div>
        </div>
        <!-- </div> -->
        <!-- <div v-else >Belum ada program</div> -->
      </div>
    </div>
    <div class="container mb-5" style="margin-top: 50px" v-if="organisasiItem">
      <div class="row trending-frame">
        <div class="caption text-center">INFORMASI :</div>
        <div class="col-md-12">
          <!-- <div class="row">
            <div
              v-for="(berita, index) in organisasiItem.berita"
              :key="index"
              class="trending-item"
            >
              <Trending :berita="berita" />
            </div>
          </div> -->
          <div class="row" v-if="organisasiItem.berita">
            <div
              class="trending-item"
              v-for="(berita, index) in organisasiItem.berita"
              :key="index"
            >
              <Trending :berita="berita" />
            </div>
          </div>
          <div class="row" v-else style="width: 100%">
            <div class="col-md-12 align-middle text-center">
              <h1><i class="icofont-worried"></i></h1>
              <span>Belum ada INFORMASI apapun</span>
            </div>
          </div>
        </div>
        <!-- <Trending />
        <Trending />
        <Trending />
        <Trending /> -->
      </div>
    </div>
  </section>
</template>

<script>
import Axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  components: {
    Trending: () => import("../Trending/Trending.vue"),
    // KoplakItem: () => import("components/KoplakItem.vue"),
  },

  data() {
    return {
      organisasiItem: {},
      organisasis: {},
      sideMenu: true,
    };
  },
  mounted() {
    this.loadOrganisasis();
  },
  computed: {
    ...mapGetters({
      urlImage: "constant/urlImage",
    }),
  },
  methods: {
    ...mapActions({
      setSpinner: "spinner/set",
    }),
    loadOrganisasis() {
      this.setSpinner(true);
      Axios.get("organisasi/showAll")
        .then((response) => {
          this.organisasis = response.data.data;
          this.organisasiItem = this.organisasis[0];
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
    pergike() {
      // buat kode mengarah ke link
      // alert("go to link")
      // this.route.path("/berita");
      this.$router.push("/berita");
    },
    viewOrganisasi(organisasi) {
      this.organisasiItem = organisasi;
      // this.hideMenu();
      this.$notify({
        group: "success",
        text: organisasi.nama,
        type: "success", //nilai lain, error dan success
      });
    },
    hideMenu() {
      if (this.sideMenu) {
        this.sideMenu = false;
      } else {
        this.sideMenu = true;
      }
    },
  },
};
</script>
