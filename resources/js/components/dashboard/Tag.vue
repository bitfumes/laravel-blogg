<template>
  <Dashboard>
    <div slot="title"></div>

    <div slot="content">
      <div>
        <v-toolbar flat color="white">
          <v-toolbar-title>Tags CRUD</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <v-btn slot="activator" color="primary" dark class="mb-2">New Tag</v-btn>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container grid-list-md>
                  <v-layout wrap>
                    <v-flex xs12>
                      <v-text-field v-model="editedItem.name" label="Tag name"></v-text-field>
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="store">Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>

        <v-data-table :headers="headers" :items="items" :pagination.sync="pagination" hide-actions>
          <template slot="items" slot-scope="props">
            <td>{{ props.item.name }}</td>
            <td class="text-xs-left">{{ props.item.blogCount }}</td>
            <td class="justify-center layout px-0 mt-2">
              <v-icon small color="orange" class="mr-2" @click="editItem(props.item)">edit</v-icon>
              <v-icon small color="red" @click="deleteItem(props.item)">delete</v-icon>
            </td>
          </template>
          <template slot="no-data">
            <v-btn color="primary" @click="getItems">Reset</v-btn>
          </template>
        </v-data-table>
      </div>

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
      dialog: false,
      search: "",
      pagination: {},
      selected: [],
      editedIndex: -1,
      editedItem: {
        name: ""
      },
      defaultItem: {
        name: ""
      },
      headers: [
        {
          text: "Name",
          align: "left",
          value: "name",
          width: "50%"
        },
        { text: "Blog Linked", value: "blogCount" },
        { text: "Actions", align: "center", value: null }
      ],
      items: [],
      itemUrl: "/api/tag"
    };
  },
  created() {
    this.getItems();
  },
  methods: {
    getItems() {
      axios.get(`${this.itemUrl}`).then(res => {
        this.items = res.data.data;
        this.pagination.totalItems = res.data.data.length;
      });
    },
    editItem(item) {
      this.editedIndex = this.items.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.items.indexOf(item);
      confirm("Are you sure you want to delete this item?") &&
        axios.delete(`${this.itemUrl}/${item.name}`).then(res => {
          this.items.splice(index, 1);
        });
    },
    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    store() {
      if (this.editedIndex > -1) {
        this.updateItem(this.items[this.editedIndex].name);
        Object.assign(this.items[this.editedIndex], this.editedItem);
      } else {
        this.saveItem();
        this.items.push(this.editedItem);
      }
      this.close();
    },
    saveItem() {
      axios
        .post(`${this.itemUrl}`, { name: this.editedItem.name })
        .then(res => flash("Item stored"));
    },
    updateItem(item) {
      axios
        .put(`${this.itemUrl}/${item}`, { name: this.editedItem.name })
        .then(res => flash("Item updated"))
        .catch(err => flash("Item is not updated", "danger"));
    }
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
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
