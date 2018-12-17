<template>
  <v-app id="inspire">
    <Sidebar></Sidebar>
    <v-content>
      <v-container>
        <v-layout>
          <v-flex xs12 sm12>
            <v-card>
              <v-container>
                <v-card-title primary-title>
                  <div>
                    <h3 class="headline mb-0">
                      <slot name="title">Give Title to Slot of title</slot>
                    </h3>
                  </div>
                  <v-spacer></v-spacer>
                  <slot name="title-right" class="align-right"></slot>
                </v-card-title>
                <slot name="content"></slot>
              </v-container>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>

    <Footer></Footer>
  </v-app>
</template>

<script>
import Sidebar from "./Sidebar";
import Footer from "./Footer";
export default {
  components: { Sidebar, Footer }
};
</script>

<style>
</style>
