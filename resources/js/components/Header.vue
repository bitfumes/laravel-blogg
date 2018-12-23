<template>
  <v-toolbar app fixed clipped-left>
    <v-toolbar-side-icon @click="openDrawer"></v-toolbar-side-icon>
    <v-toolbar-title>{{ title }}</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items class="hidden-sm-and-down">
      <v-btn flat>
        <router-link :to="{name:'blog.index'}">Blog</router-link>
      </v-btn>
      <v-btn flat>
        <router-link :to="{name:'dashboard'}">Dashboard</router-link>
      </v-btn>
    </v-toolbar-items>
  </v-toolbar>
</template>

<script>
export default {
  props: ["title"],
  methods: {
    openDrawer() {
      Event.$emit("openDrawer");
    }
  }
};
</script>

<style>
</style>
