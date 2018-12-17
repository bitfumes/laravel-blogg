<template>
  <v-toolbar>
    <v-toolbar-side-icon></v-toolbar-side-icon>
    <v-toolbar-title>Blog</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items class="hidden-sm-and-down">
      <v-btn flat>
        <router-link to="/blog">Blog</router-link>
      </v-btn>
    </v-toolbar-items>
  </v-toolbar>
</template>

<script>
export default {
  mounted() {
    axios
      .post("/api/blog")
      .then(result => {
        console.log(result);
      })
      .catch(err => {});
  }
};
</script>

<style>
</style>
