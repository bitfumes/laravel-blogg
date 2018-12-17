<template>
  <div>
    <v-toolbar app fixed clipped-left>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <v-toolbar-title>Blog Dashboard</v-toolbar-title>
    </v-toolbar>

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

        <v-list-tile>
          <v-list-tile-action>
            <v-icon>settings</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>Settings</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>

<script>
export default {
  data: () => ({
    drawer: null,
    links: [
      { name: "Dashboard", to: "dashboard" },
      { name: "Blogs", to: "blog.index" },
      { name: "Categories", to: "category" },
      { name: "Tags", to: "tag" }
    ]
  }),
  props: {
    source: String
  }
};
</script>