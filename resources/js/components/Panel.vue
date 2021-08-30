<template>
  <b-row
    no-gutters
    class="justify-content-center text-warning"
  >
    <b-col cols="2">
      <SideMenu />
    </b-col>
    <b-col cols="10">
      <router-view></router-view>
    </b-col>
  </b-row>
</template>
<script>
import SideMenu from "./SideMenu.vue";
export default {
  props: {},
  components: {
    SideMenu,
  },
  created() {},
};
</script>