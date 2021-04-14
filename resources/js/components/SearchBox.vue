<template>
  <div class="input-group input-group-lg">
    <div class="input-group-prepend">
      <span class="input-group-text" :id="name">{{ name }}</span>
    </div>
    <input :type="type" v-model="filters[name]" class="form-control" />
    <button
      type="button"
      @click="filters[name] = null"
      class="btn btn-danger"
    >
      <i class="fas fa-times"></i>
    </button>
  </div>
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