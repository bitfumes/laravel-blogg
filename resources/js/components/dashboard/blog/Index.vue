<template>
  <Dashboard>
    <div slot="title">
      <span>Blogs</span>
      <router-link :to="{name:'blog.create'}">
        <v-btn small color="white">New Blog</v-btn>
      </router-link>
    </div>
    <div slot="content">
      <v-data-table :headers="headers" :items="items" :pagination.sync="pagination" hide-actions>
        <template slot="items" slot-scope="props">
          <td>
            <v-avatar :size="50" color="grey lighten-4">
              <img :src="props.item.thumb_path" alt="avatar">
            </v-avatar>
          </td>
          <td>{{ props.item.title }}</td>
          <td class="text-xs-left">{{ props.item.published_at }}</td>
          <td class="justify-center layout px-0 mt-2">
            <v-icon small color="orange" class="mr-2" @click="editItem(props.item)">edit</v-icon>
            <v-icon small color="red" @click="deleteItem(props.item)">delete</v-icon>
          </td>
        </template>
        <template slot="no-data">
          <v-btn color="primary" @click="getItems">Reset</v-btn>
        </template>
      </v-data-table>

      <div class="text-xs-center pt-2">
        <v-pagination v-model="pagination.page" :length="pages"></v-pagination>
      </div>
    </div>
  </Dashboard>
</template>

<script>
export default {
  data() {
    return {
      search: "",
      pagination: {},
      headers: [
        { text: "Thumb", value: null, sortable: false },
        {
          text: "Title",
          align: "left",
          sortable: false,
          value: "title",
          width: "50%"
        },
        { text: "Published", value: "published_at" }
      ],
      items: [],
      itemUrl: "/api/category"
    };
  },
  created() {
    this.getItems();
  },
  methods: {
    getItems() {
      axios
        .post("/api/blog")
        .then(res => {
          this.items = Object.values(res.data["data"]);
        })
        .catch(err => {});
    }
  },
  computed: {
    pages() {
      if (
        this.pagination.rowsPerPage == null ||
        this.pagination.totalItems == null
      )
        return 0;

      return Math.ceil(
        this.pagination.totalItems / this.pagination.rowsPerPage
      );
    }
  }
};
</script>

<style>
</style>
