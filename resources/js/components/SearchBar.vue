<template>
  <div class="row no-gutters">
    <div class="col">
      <div class="input-group input-group-lg">
        <div class="input-group-prepend">
          <span class="input-group-text" id="客户姓名">客户姓名</span>
        </div>
        <input type="text" v-model="filters.客户姓名" class="form-control" />
      </div>
    </div>
    <div class="col">
      <div class="input-group input-group-lg">
        <div class="input-group-prepend">
          <span class="input-group-text" id="證件號碼">證件號碼</span>
        </div>
        <input type="text" v-model="filters.證件號碼" class="form-control" />
      </div>
    </div>
    <div class="col">
      <div class="input-group input-group-lg">
        <div class="input-group-prepend">
          <span class="input-group-text" id="手機號碼">手機號碼</span>
        </div>
        <input type="text" v-model="filters.手機號碼" class="form-control" />
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  props: {
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