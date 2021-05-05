<template>
  <a class="list-group-item list-group-item-action" :href="menu_item.url">
    <h5 class="mb-0">
      <i class="fas fa-caret-right"></i> {{ menu_item.label }}
      <span class="badge badge-danger badge-pill">{{ NoOfNews }}</span>
    </h5>
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
  },
  created() {
    this.getNoOfNews();
  },
  methods: {
    getNoOfNews() {
      const self = this;
      if (self.menu_item.api) {
        axios
          .post(self.menu_item.api)
          .then((res) => {
            // let json = self.getDecryptedJsonObject(res.data);
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