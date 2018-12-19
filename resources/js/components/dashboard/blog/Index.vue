<template>
  <Dashboard>
    <div slot="title">
      <span>Blogs</span>
      <router-link :to="{name:'blog.create'}">
        <v-btn small color="white">New Blog</v-btn>
      </router-link>
    </div>
    <div slot="content">
      <v-data-table :headers="headers" :items="items" :pagination.sync="pagination">
        <template slot="items" slot-scope="props">
          <td>
            <v-avatar :size="50" color="grey lighten-4">
              <img :src="props.item.thumb_path" alt="avatar">
            </v-avatar>
          </td>

          <td>{{ props.item.title }}</td>

          <td class="text-xs-left">{{ props.item.category.name }}</td>

          <td class="text-xs-left">{{ props.item.published_at }}</td>

          <td class="justify-center layout px-0 mt-2">
            <router-link :to="{name:'blog.edit', params: { slug: props.item.slug }}">
              <v-icon small color="orange" class="mr-2">edit</v-icon>
            </router-link>
            <v-icon small color="red" @click="deleteItem(props.item)">delete</v-icon>
          </td>
        </template>
        <template slot="no-data">
          <v-btn color="primary" @click="getItems">Reset</v-btn>
        </template>
      </v-data-table>

      <div class="text-xs-center pt-2">
        <v-pagination v-model="pagination.page" :length="pages" rows-per-page-items="10"></v-pagination>
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
        { text: "Category", value: "category" },
        { text: "Published", value: "published_at" },
        { text: "Actions", value: null, sortable: false }
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
        .post("/api/blog/all")
        .then(res => {
          this.items = Object.values(res.data["data"]);
          this.pagination.totalItems = res.data["data"].length;
        })
        .catch(err => {});
    },
    deleteItem(item) {
      const index = this.items.indexOf(item);
      confirm("Are you sure you want to delete this item?") &&
        axios.delete(`${item.path}`).then(res => {
          this.items.splice(index, 1);
        });
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
