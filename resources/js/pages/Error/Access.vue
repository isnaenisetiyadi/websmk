<template>
  <section class="section-error">
    <div class="container-fluid banner-error" height="50px"></div>
    <div class="container-fluid body-error">
      <div class="text-center center">
        <h1>
          <i class="icofont-lock"></i>
        </h1>
        <span>Access Denied</span>
        <hr />
        <button @click="goHome()" class="btn btn-success">
          <i class="icofont-home"></i>
        </button>
      </div>
      
    </div>
  </section>
</template>

<script>
export default {
  methods: {
    goHome() {
      this.$router.push("/");
    },
  },
};
</script>
