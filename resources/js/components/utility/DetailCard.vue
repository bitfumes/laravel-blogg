<template>
  <router-link :to="to">
    <v-card :class="margin" :hover="hover">
      <v-card-media class="white--text" :height="img_height" :src="img">
        <v-flex xs12 align-end flexbox v-if="chip">
          <v-chip label small color="blue" text-color="white">{{ chip }}</v-chip>
        </v-flex>
        <v-container fill-height fluid>
          <v-layout fill-height>
            <v-flex xs12 align-end flexbox>
              <span class="headline">{{ title }}</span>
            </v-flex>
          </v-layout>
        </v-container>
      </v-card-media>
      <v-card-text>
        <slot name="text"></slot>
      </v-card-text>
    </v-card>
  </router-link>
</template>

<script>
export default {
  props: {
    title: { type: String },
    to: { default: "" },
    btnName: { default: "Explore" },
    img: { default: "" },
    img_height: { default: "200px" },
    chip: { default: "", type: String },
    margin: { default: "" },
    hover: { default: false }
  }
};
</script>

<style>
</style>
