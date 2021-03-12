<template>
  <Menu :model="menu" style="width: 100%" />
</template>
<script>
import Menu from "primevue/menu";
export default {
  data() {
    return {
      menu: null,
    };
  },
  props: {
    p_menu: String,
  },
  components: { Menu },
  created() {
    this.menu = JSON.parse(this.p_menu);
  },
};
</script>