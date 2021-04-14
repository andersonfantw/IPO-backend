<template>
  <div class="input-group input-group-lg">
    <div class="input-group-prepend">
      <span class="input-group-text" :id="name">{{ name }}</span>
    </div>
    <select v-model="filters[name]" class="form-control">
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