<template>
  <div>
    <div v-if="choose">
      <vue-avatar
        :width="width"
        :height="450"
        :border="0"
        style="top:0"
        ref="vueavatar"
        @vue-avatar-editor:image-ready="onImageReady"
        :image="image"
      ></vue-avatar>
      <br>
      <v-container grid-list-xl text-xs-center>
        <vue-avatar-scale
          ref="vueavatarscale"
          @vue-avatar-editor-scale:change-scale="onChangeScale"
          :width="250"
          :min="1"
          :max="3"
          :step="0.02"
        ></vue-avatar-scale>
        <br>
        <v-btn @click="saveClicked" :disabled="!selected" fab color="cyan" small class="white-text">
          <v-icon>file_upload</v-icon>
        </v-btn>
      </v-container>
    </div>

    <a href="#" @click="select" v-if="!choose">
      <img :src="formImage" alt id="avatar" :width="width" height="450">
      <br>
    </a>
    <v-container grid-list-xl text-xs-center>
      <v-btn @click="choose = true" v-if="!choose" fab color="pink" small class="white-text">
        <v-icon>clear</v-icon>
      </v-btn>
    </v-container>
  </div>
</template>

<script>
import upload from "./upload";

export default {
  mixins: [upload],
  props: ["formImage", "edit", "width"],
  data() {
    return {
      image: null
    };
  },
  created() {
    setTimeout(() => {
      this.image = this.formImage;
      if (!this.image) {
        this.choose = true;
      }
    }, 500);
  },
  watch: {
    image(value) {
      Event.$emit("image", value);
    }
  },
  methods: {
    post() {
      this.choose = false;
    }
  }
};
</script>