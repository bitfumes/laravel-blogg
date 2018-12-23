<template>
  <Dashboard>
    <div slot="title">Blog Dashboard</div>

    <div slot="content">
      <v-layout justify-center>
        <v-flex xs12 md4 class="ml-2" v-for="item in items" :key="item.title">
          <detail-card :title="item.title" :to="item.to" btnName="Explore" :img="item.img"></detail-card>
        </v-flex>
      </v-layout>
    </div>
  </Dashboard>
</template>

<script>
import DetailCard from "../../../components/utility/DetailCard";
export default {
  components: { DetailCard },
  data() {
    return {
      items: [
        {
          to: { name: "dashboard.blog.index" },
          img: "/vendor/blogg/images/blog.jpeg",
          title: "Total Blogs"
        },
        {
          to: { name: "dashboard.category" },
          img: "/vendor/blogg/images/category.jpeg",
          title: "Total Categories"
        },
        {
          to: { name: "dashboard.tag" },
          img: "/vendor/blogg/images/tag.jpeg",
          title: "Total Tags"
        }
      ]
    };
  }
};
</script>

<style>
</style>
