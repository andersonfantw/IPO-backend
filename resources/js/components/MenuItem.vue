<template>
  <a
    class="list-group-item list-group-item-action list-group-item-dark d-flex w-100 justify-content-between"
    :href="menu_item.url"
  >
    <h5 class="mb-0">
      <i class="fas fa-caret-right"></i> {{ menu_item.label }}
    </h5>
    <span class="badge badge-danger badge-pill">{{ NoOfNews }}</span>
  </a>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      NoOfNews: null,
    };
  },
  props: {
    menu_item: Object,
    no_of_news: Number,
  },
  created() {
    this.NoOfNews = this.no_of_news;
    // this.getNoOfNews();
  },
  methods: {
    getNoOfNews() {
      const self = this;
      if (self.menu_item.api) {
        axios
          .post(self.menu_item.api)
          .then((res) => {
            if (res.data.NoOfNews > 0) {
              self.NoOfNews = res.data.NoOfNews;
            }
          })
          .catch((error) => {
            console.log(error.response);
          });
      }
    },
  },
};
</script>