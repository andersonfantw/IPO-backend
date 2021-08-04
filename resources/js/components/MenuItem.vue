<template>
  <a
    class="list-group-item list-group-item-action list-group-item-info d-flex w-100 justify-content-between"
    :href="menu_item.url"
  >
    <h5 class="mb-0">
      <i class="fas fa-caret-right"></i> {{ menu_item.label }}
    </h5>
    <span class="badge badge-danger badge-pill">{{ no_of_news }}</span>
  </a>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {};
  },
  props: {
    menu_item: Object,
    no_of_news: Number,
  },
  created() {},
  methods: {},
};
</script>