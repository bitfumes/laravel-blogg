<template>
  <v-card class="mt-2">
    <v-card-text v-highlightjs class="body subheading" v-html="content"></v-card-text>
  </v-card>
</template>

<script>
export default {
  props: ["content"]
};
</script>

<style>
.body {
  padding: 3em;
}
</style>
