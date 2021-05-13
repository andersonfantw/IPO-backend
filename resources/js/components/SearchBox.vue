<template>
  <b-input-group :prepend="name">
    <b-form-input :type="type" v-model="filters[name]"></b-form-input>
  </b-input-group>
</template>
<script>
export default {
  data() {
    return {};
  },
  props: {
    type: {
      type: String,
      required: true,
    },
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