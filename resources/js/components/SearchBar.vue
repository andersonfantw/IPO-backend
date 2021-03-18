<template>
  <div class="row no-gutters">
    <div class="col">
      <div class="input-group input-group-lg">
        <div class="input-group-prepend">
          <span class="input-group-text" id="客户名称">客户名称</span>
        </div>
        <input type="text" v-model="filters.客户姓名" class="form-control" />
      </div>
    </div>
    <div class="col">
      <div class="input-group input-group-lg">
        <div class="input-group-prepend">
          <span class="input-group-text" id="证件号码">证件号码</span>
        </div>
        <input type="text" v-model="filters.证件号码" class="form-control" />
      </div>
    </div>
    <div class="col">
      <div class="input-group input-group-lg">
        <div class="input-group-prepend">
          <span class="input-group-text" id="手机号码">手机号码</span>
        </div>
        <input type="text" v-model="filters.手机号码" class="form-control" />
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