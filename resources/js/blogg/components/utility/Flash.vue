<template>
  <v-snackbar :timeout="timeout" :color="color" multi-line top vertical v-model="snackbar">
    {{ body }}
    <v-btn dark flat @click.native="snackbar = false">Close</v-btn>
  </v-snackbar>
</template>

<script>
export default {
  props: ["message"],
  data() {
    return {
      body: "",
      color: "",
      snackbar: false,
      timeout: 6000
    };
  },
  created() {
    if (this.message) {
      this.flash(this.message);
    }

    Event.$on("flash", data => this.flash(data));
  },
  methods: {
    hide() {
      setTimeout(() => {
        this.show = false;
      }, 3000);
    },
    flash(data) {
      this.body = data.message;
      this.snackbar = true;
      this.color = data.color;
      this.hide();
    }
  }
};
</script>
<style>
.alert-flash {
  position: fixed;
  right: 25px;
  top: 100px;
  z-index: 11;
}
</style>