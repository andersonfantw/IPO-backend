<template>
  <div>
    <div v-for="menu in menus" :key="menu.label" class="list-group">
      <h4 class="mb-0">{{ menu.label }}</h4>
      <MenuItem
        v-for="item in menu.items"
        :key="item.label"
        :menu_item="item"
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