<template >
  <Dashboard>
    <div slot="title">Write new Blog</div>

    <div slot="content">
      <form @submit.prevent="onSubmit">
        <v-text-field
          label="Title"
          placeholder="Your Rocking Title"
          v-model="form.title"
          required
          class="mt-3"
          counter="40"
          :rules="[() => !!form.title && form.title.length <= 80 || 'Title must be less than 80 characters']"
        ></v-text-field>
        <span class="red--text" v-if="errors.title">{{ errors.title[0] }}</span>

        <v-container grid-list-md>
          <v-layout>
            <v-flex xs6>
              <v-autocomplete
                item-text="name"
                item-value="id"
                :items="categories"
                v-model="form.category_id"
                label="Category"
                autocomplete
              ></v-autocomplete>
              <span class="red--text" v-if="errors.category_id">{{ errors.category_id[0] }}</span>
            </v-flex>
            <v-flex xs6>
              <v-autocomplete
                item-text="name"
                item-value="id"
                :items="tags"
                multiple
                autocomplete
                chips
                v-model="form.tag_ids"
                label="Tags"
              ></v-autocomplete>
              <span class="red--text" v-if="errors.tag_ids">{{ errors.tag_ids[0] }}</span>
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
              <v-checkbox :label="`Published`" v-model="form.published"></v-checkbox>
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
import markdown from "../../../simplemde-configs";
import FeaturedImage from "../ImageUpload/Image";

export default {
  data() {
    return {
      form: {
        body: "Hello",
        title: "This is title",
        tag_ids: [1, 2],
        category_id: 1,
        image: null,
        published: true
      },
      categories: [],
      tags: [],
      errors: []
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
    onSubmit() {
      axios
        .post("/api/blog/store", this.form)
        .then(res => {
          flash("Created.");
          this.$router.push({ name: "blog.index" });
        })
        .catch(err => {
          this.errors = err.response.data.errors;
          document.documentElement.scrollTop = 0;
          flash("Please check for any error", "error");
        });
    },
    setImage() {
      Event.$on("image", value => (this.form.image = value));
    }
  },
  mixins: [markdown],
  components: { FeaturedImage }
};
</script>

<style>
.vue-input-tag-wrapper {
  border-radius: 20;
}
</style>
