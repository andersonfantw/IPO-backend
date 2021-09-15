<template>
  <div class="sticky-top">
    <div
      v-for="menu in Menus"
      :key="menu.label"
      class="list-group rounded-0"
    >
      <div class="list-group-item list-group-item-success">
        <h4 class="mb-0">{{ menu.label }}</h4>
      </div>
      <!-- <MenuItem
        v-for="item in menu.items"
        :key="item.label"
        :menu_item="item"
        :no_of_news="item.no_of_news"
        :class="{ active: current_url == item.url }"
      /> -->

      <router-link
        v-for="item in menu.items"
        :key="item.label"
        class="
          list-group-item list-group-item-action list-group-item-info
          d-flex
          w-100
          justify-content-between
        "
        :to="item.url"
      >
        <h5 class="mb-0">
          <i class="fas fa-caret-right"></i> {{ item.label }}
        </h5>
        <b-badge
          v-if="counts[item.label] > 0"
          pill
          variant="danger"
        >{{counts[item.label]}}</b-badge>
      </router-link>
    </div>
  </div>
</template>
<script>
import axios from "axios";
// import MenuItem from "./MenuItem";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  mixins: [CommonFunctionMixin],
  data() {
    return {
      Menus: [],
      busy: true,
    };
  },
  props: {
    menus: Array,
    current_url: String,
  },
  components: {
    // MenuItem,
  },
  created() {
    // this.Menus = this.menus;
    this.reload();
  },
  methods: {
    reload() {
      const self = this;
      this.busy = true;
      axios
        .get(`MenuItem`)
        .then((res) => {
          console.log(res);
          self.Menus = res.data;
          self.busy = false;
        })
        .catch((error) => {
          console.log(error);
          self.checkLogin(error);
        });
    },
  },
  computed: {
    counts: {
      get() {
        return this.$store.state.Menu.counts;
      },
      // set(value) {
      //   this.$store.commit("Menu/counts", value);
      // },
    },
  },
  watch: {},
};
</script>