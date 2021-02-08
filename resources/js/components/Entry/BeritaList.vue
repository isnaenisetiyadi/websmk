<template>
  <div>
    <td>{{ berita.judul }}</td>
    <td>{{ berita.deskripsi }}</td>
    <td>{{tanggalEntry }}<br>
    <span>{{jamEntry}}</span>
     </td>

    <td>
      <i class="icofont-eye-alt text-success link-i" @click="onView(berita.id)"></i>
      <i class="icofont-trash link-i text-danger" @click="onDelete(berita.id)"></i>
    </td>
  </div>
</template>

<script>
import {date} from 'vue';
export default {
    name: "berita-list",
    props: ["berita"],
    data() { return {
        tanggalEntry: '',
        jamEntry: '',
    }},
    mounted() {
        this.isiTanggalJam();
    },
    methods: {
        isiTanggalJam(){
            this.tanggalEntry = date.formatDate(this.berita.created_at, "DD MMMM YYYY");
      this.jamEntry = date.formatDate(this.berita.created_at, "HH:mm");
        }
    }
};
</script>
