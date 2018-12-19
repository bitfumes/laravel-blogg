<template>
  <Dashboard>
    <div slot="title">Blog Dashboard</div>

    <div slot="content">
      <v-layout justify-center>
        <v-flex xs12 md4>
          <detail-card
            title="Total Blogs"
            :to="{name:'blog.index'}"
            btnName="Explore"
            img="/vendor/blogg/images/blog.jpeg"
          ></detail-card>
        </v-flex>
        <v-flex xs12 md4 class="ml-2">
          <detail-card
            title="Total Categories"
            :to="{name:'category'}"
            btnName="Explore"
            img="/vendor/blogg/images/category.jpeg"
          ></detail-card>
        </v-flex>
        <v-flex xs12 md4 class="ml-2">
          <detail-card
            title="Total Tags"
            :to="{name:'tag'}"
            btnName="Explore"
            img="/vendor/blogg/images/tag.jpeg"
          ></detail-card>
        </v-flex>
      </v-layout>
    </div>
  </Dashboard>
</template>

<script>
import DetailCard from "../utility/DetailCard";
export default {
  components: { DetailCard }
};
</script>

<style>
</style>
