<template>
  <div>
    <img
      :src="images / logo / logo_smk.png"
      alt="Image"
      class="logo-smk"
      data-aos="fade-down"
      data-aos-delay="100"
      v-for="(jurusan, index) in jurusans"
      :key="index"
    />
  </div>
</template>

<script>
export default {
    props: ["jurusan"]
}
</script>