<template>
  <div class="input-group input-group-lg">
    <div class="input-group-prepend">
      <span class="input-group-text rounded-0 bg-info text-white" :id="name">{{
        name
      }}</span>
    </div>
    <select
      v-model="filters[name]"
      class="form-control bg-secondary text-white rounded-0"
    >
      <slot></slot>
    </select>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  props: {
    name: {
      type: String,
      required: true,
    },
    storeNameSpaced: {
      type: String,
      required: true,
    },
  },
  computed: {
    filters: {
      get() {
        return this.$store.state[this.storeNameSpaced].filters;
      },
      set(value) {
        this.$store.commit(this.storeNameSpaced + "/filters", value);
      },
    },
  },
  methods: {},
};
</script>