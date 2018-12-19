<template>
  <div @click="toggle">
    <v-tooltip top color="cyan">
      <v-btn flat icon slot="activator">
        <v-icon :color="classes">favorite</v-icon>
        <span class="ml-1" v-text="favoriteCount"></span>
      </v-btn>
      <span>Like this {{favType}}</span>
    </v-tooltip>
  </div>
</template>

<script>
export default {
  props: ["isLiked", "count", "slug", "favType", "absolute"],

  data() {
    return {
      favoriteCount: this.count,
      isFavorited: this.isLiked
    };
  },
  computed: {
    classes() {
      return this.isFavorited ? "red accent-4" : "pink lighten-4";
    },
    endPoint() {
      if (this.slug) {
        return `${window.apiEndpoint}/${this.slug}/like`;
      }
    },
    float() {
      return this.absolute ? this.absolute : false;
    }
  },
  methods: {
    toggle() {
      if (window.App.signedIn) {
        this.isFavorited ? this.destroy() : this.create();
      }
    },
    destroy() {
      axios.delete(this.endPoint);
      this.isFavorited = false;
      this.favoriteCount--;
    },
    create() {
      axios.post(this.endPoint);
      this.isFavorited = true;
      this.favoriteCount++;
    }
  }
};
</script>