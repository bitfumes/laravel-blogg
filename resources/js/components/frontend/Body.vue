<template>
  <v-card class="mt-2">
    <v-card-text class="subheading" v-html="content"></v-card-text>
  </v-card>
</template>

<script>
export default {
  props: ["content"]
};
</script>

<style>
</style>
