<template>
  <div>
    <Header title="Blogs"></Header>
    <v-content>
      <v-container>
        <v-layout>
          <v-flex xs12>
            <!-- Featured Image -->
            <detail-card to :img="item.image_path" img_height="400px">
              <div slot="text">
                <p class="display-1 text-xs-center">{{ item.title}}</p>
              </div>
            </detail-card>

            <!-- Infomration Bar -->
            <info-bar
              class="mt-2"
              :published_at="item.published_at"
              :favoriteCounts="item.likeCounts"
              :slug="item.slug"
              :isLiked="item.isLiked"
            ></info-bar>

            <!-- Body Section -->
            <blog-body :content="item.body"></blog-body>
            <!--  Disqus Section -->
            <disqus></disqus>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </div>
</template>

<script>
import Header from "../Header";
import InfoBar from "./InfoBar";
import BlogBody from "./Body";
import Disqus from "../utility/Disqus";
export default {
  components: { Header, InfoBar, Disqus, BlogBody },
  data() {
    return {
      item: []
    };
  },
  mounted() {
    let params = this.$route.params;
    axios
      .post(`/api/blog/${params.category}/${params.slug}`)
      .then(res => {
        this.item = res.data.data;
      })
      .catch(err => {});
  }
};
</script>

<style>
</style>
