<template >
  <Dashboard>
    <div slot="title">Write new Blog</div>

    <div slot="content">
      <form @submit="onSubmit">
        <v-text-field
          label="Title"
          placeholder="Your Rocking Title"
          v-model="form.title"
          required
          class="mt-3"
          counter="40"
          :rules="[() => !!form.title && form.title.length <= 80 || 'Title must be less than 80 characters']"
        ></v-text-field>

        <v-container grid-list-md text-xs-center>
          <v-layout>
            <v-flex xs6>
              <v-select
                item-text="name"
                item-value="id"
                :items="categories"
                v-model="form.category_id"
                label="Category"
                autocomplete
              ></v-select>
            </v-flex>
            <v-flex xs6>
              <v-select
                item-text="name"
                item-value="id"
                :items="tags"
                multiple
                autocomplete
                chips
                v-model="form.tag_ids"
                label="Tags"
              ></v-select>
            </v-flex>
          </v-layout>
        </v-container>

        <br>
        <markdown-editor
          v-model="form.body"
          preview-class="markdown-body"
          :highlight="true"
          ref="markdownEditor"
          :configs="configs"
        ></markdown-editor>

        <Featured-Image :formImage="form.image"></Featured-Image>

        <v-container grid-list-md>
          <v-layout>
            <v-flex xs6>
              <v-checkbox :label="`Published`" v-model="form.category_id"></v-checkbox>
            </v-flex>
            <v-flex xs6>
              <v-btn color="success" type="submit">Store</v-btn>
            </v-flex>
          </v-layout>
        </v-container>
      </form>
    </div>
  </Dashboard>
</template>

<script>
import Dashboard from "./Dashboard";
import markdown from "../../simplemde-configs";
import FeaturedImage from "./ImageUpload/Image";

export default {
  data() {
    return {
      form: {
        body: null,
        title: null,
        tag_ids: [],
        category_id: null,
        image: null
      },
      categories: [],
      tags: []
    };
  },
  created() {
    this.setImage();
    this.getCategory();
    this.getTags();
  },
  methods: {
    getCategory() {
      axios.get(`/api/category`).then(res => {
        this.categories = res.data.data;
      });
    },
    getTags() {
      axios.get(`/api/tag`).then(res => {
        this.tags = res.data.data;
      });
    },
    onSubmit() {},
    setImage() {
      Event.$on("image", value => (this.form.image = value));
    }
  },
  mixins: [markdown],
  components: { Dashboard, FeaturedImage }
};
</script>

<style>
.vue-input-tag-wrapper {
  border-radius: 20;
}
</style>
