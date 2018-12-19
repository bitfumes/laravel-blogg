<template>
  <div>
    <Header title="Blog Dashboard"></Header>

    <v-navigation-drawer v-model="drawer" clipped fixed app>
      <v-list dense>
        <v-list-tile v-for="item in links" :key="item.name">
          <v-list-tile-action>
            <v-icon>dashboard</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <router-link :to="{name:item.to}">
              <v-list-tile-title>{{ item.name }}</v-list-tile-title>
            </router-link>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>

<script>
import Header from "../Header";
export default {
  components: { Header },
  data: () => ({
    drawer: null,
    links: [
      { name: "Dashboard", to: "dashboard" },
      { name: "Blogs", to: "blog.index" },
      { name: "Categories", to: "category" },
      { name: "Tags", to: "tag" }
    ]
  }),
  created() {
    Event.$on("openDrawer", () => (this.drawer = !this.drawer));
  },
  props: {
    source: String
  }
};
</script>