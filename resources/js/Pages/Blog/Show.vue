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
              :title="item.title"
              :user="item.user"
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
import Header from "../../components/Header";
import InfoBar from "../../components/InfoBar";
import BlogBody from "../../components/Body";
import Disqus from "../../components/utility/Disqus";

export default {
  components: { Header, InfoBar, Disqus, BlogBody },
  data() {
    return {
      item: []
    };
  },
  beforeRouteEnter(to, from, next) {
    axios
      .post(`/api/blog/${to.params.category}/${to.params.slug}`)
      .then(res => {
        next(vm => (vm.item = res.data.data));
      })
      .catch(err => {
        next(vm => vm.$router.push({ name: "blog.index" }));
      });
  }
};
</script>

<style>
</style>
