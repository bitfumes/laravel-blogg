<template >
  <Dashboard>
    <div slot="title">Edit This Blog</div>

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

        <Featured-Image :formImage="form.image" :edit="false" :width="1080"></Featured-Image>

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
import PostEdit from "../ImageUpload/PostEdit";

export default {
  data() {
    return {
      form: {
        body: "",
        title: "",
        tag_ids: [],
        category_id: null,
        image: null,
        published: false,
        id: null,
        user_id: auth.user.id
      },
      categories: [],
      tags: [],
      errors: []
    };
  },
  created() {
    this.fatchEditBlog();
    this.setImage();
    this.getCategory();
    this.getTags();
  },
  computed: {
    slug() {
      return this.$route.params.slug;
    }
  },
  methods: {
    fatchEditBlog() {
      axios
        .post(`/api/blog/${this.slug}`, { editing: true })
        .then(res => {
          this.form.title = res.data.data.title;
          this.form.id = res.data.data.id;
          this.form.body = res.data.data.body;
          this.form.published = res.data.data.published_at ? true : false;
          this.form.body = res.data.data.body;
          this.form.image = res.data.data.image_path;
          this.form.category_id = res.data.data.category.id;
          this.form.tag_ids = res.data.data.tags.data.map(item => item.id);
        })
        .catch(err => {});
    },
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
        .put(`/api/blog/${this.slug}`, this.form)
        .then(res => {
          flash("Updated.");
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
  mixins: [markdown, PostEdit],
  components: { FeaturedImage }
};
</script>

<style>
.vue-input-tag-wrapper {
  border-radius: 20;
}
</style>
