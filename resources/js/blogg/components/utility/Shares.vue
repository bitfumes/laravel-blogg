<template>
  <v-menu offset-y open-on-hover>
    <v-btn icon slot="activator">
      <v-icon small color="indigo">share</v-icon>
    </v-btn>
    <v-list>
      <v-list-tile>
        <v-btn
          :href="`http://www.facebook.com/sharer/sharer.php?u=${path}&title=${title}`"
          target="_blank"
          fab
          small
          color="indigo"
          dark
          icon
        >
          <v-icon dark class="ml-1">fab fa-facebook-f</v-icon>
        </v-btn>
      </v-list-tile>
      <v-list-tile>
        <v-btn
          :href="`http://twitter.com/intent/tweet?status=${path}`"
          target="_blank"
          fab
          small
          color="blue"
          dark
          icon
        >
          <v-icon dark>fab fa-twitter</v-icon>
        </v-btn>
      </v-list-tile>
    </v-list>
  </v-menu>
</template>

<script>
export default {
  props: ["title"],
  computed: {
    path() {
      return window.location.href;
    }
  }
};
</script>

<style>
</style>
