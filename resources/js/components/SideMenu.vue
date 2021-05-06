<template>
  <div>
    <div v-for="menu in menus" :key="menu.label" class="list-group rounded-0">
      <div class="list-group-item list-group-item-success">
        <h4 class="mb-0">{{ menu.label }}</h4>
      </div>
      <MenuItem
        v-for="item in menu.items"
        :key="item.label"
        :menu_item="item"
        :no_of_news="item.no_of_news"
        :class="{ active: current_url == item.url }"
      />
    </div>
  </div>
</template>
<script>
import MenuItem from "./MenuItem";
export default {
  data() {
    return {};
  },
  props: {
    menus: Array,
    current_url: String,
  },
  components: {
    MenuItem,
  },
  created() {},
};
</script>