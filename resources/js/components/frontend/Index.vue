<template>
  <div>
    <Header title="Blogs"></Header>
    <v-content>
      <v-container>
        <v-layout row wrap>
          <v-flex xs12 sm4 v-for="item in items" :key="item.slug">
            <detail-card
              :hover="true"
              margin="ml-4 mt-4"
              :to="{name:'front.blog.show',params:{slug:item.slug,category:item.category.slug}}"
              :img="item.thumb_path"
              :chip="item.category.name"
            >
              <div slot="text">
                <h3 class="title mb-0">{{ item.title }}</h3>
                <div></div>
              </div>
            </detail-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </div>
</template>

<script>
import Header from "../Header";
import DetailCard from "../utility/DetailCard";

export default {
  components: { Header, DetailCard },
  data() {
    return {
      items: []
    };
  },
  mounted() {
    axios
      .post(`${api}/api/blog`)
      .then(res => {
        this.items = res.data.data;
      })
      .catch(err => {
        this.$route.push({ name: "front.blog.index" });
      });
  }
};
</script>

<style>
</style>
