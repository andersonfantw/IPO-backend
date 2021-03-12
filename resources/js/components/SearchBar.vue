<template>
  <div class="row no-gutters">
    <div class="col">
      <div class="input-group input-group-lg">
        <div class="input-group-prepend">
          <span class="input-group-text" id="客户名称">客户名称</span>
        </div>
        <input type="text" v-model="clientName" class="form-control" />
      </div>
    </div>
    <div class="col">
      <div class="input-group input-group-lg">
        <div class="input-group-prepend">
          <span class="input-group-text" id="证件号码">证件号码</span>
        </div>
        <input type="text" v-model="IDNumber" class="form-control" />
      </div>
    </div>
    <div class="col">
      <div class="input-group input-group-lg">
        <div class="input-group-prepend">
          <span class="input-group-text" id="手机号">手机号</span>
        </div>
        <input type="text" v-model="mobileNo" class="form-control" />
        <button type="button" @click="query" class="btn btn-primary">
          查询
        </button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      clientName: null,
      IDNumber: null,
      mobileNo: null,
    };
  },
  props: {
    storeNameSpaced: {
      type: String,
      required: true,
    },
  },
  methods: {
    query() {
      let clientInfo = {
        clientName: this.clientName,
        IDNumber: this.IDNumber,
        mobileNo: this.mobileNo,
      };
      this.$store.commit(this.storeNameSpaced + "/clientInfo", clientInfo);
    },
  },
};
</script>