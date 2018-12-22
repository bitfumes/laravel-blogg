<template>
  <v-card>
    <v-card-title v-if="user">
      <v-avatar class="grey lighten-4" :tile="false" size="70px">
        <img :src="user.avatar" alt="Avatar">
      </v-avatar>
      <div class="ml-3">
        Posted by
        <a class="teal--text" href="#">
          <span>{{ user.name }}</span>
        </a>
        <br>
        <span>{{ published_at }}</span>
        <br>
        <a
          href="https://twitter.com/bitfumes?ref_src=twsrc%5Etfw"
          class="twitter-follow-button"
          data-show-count="false"
        >Follow @bitfumes</a>
      </div>

      <v-spacer></v-spacer>

      <favorite v-if="slug" :isLiked="isLiked" :count="favoriteCounts" :slug="slug" favType="Blog"></favorite>

      <shares :title="title"></shares>
    </v-card-title>
  </v-card>
</template>


<script>
import Favorite from "../utility/Favorite";
import Shares from "../utility/Shares";
export default {
  components: { Favorite, Shares },
  props: {
    published_at: { type: String },
    favoriteCounts: { default: 0, type: Number },
    slug: { default: null },
    isLiked: { default: false },
    title: { default: null },
    user: { default: null },
    avatar: { default: null }
  }
};
</script>

<style>
</style>
