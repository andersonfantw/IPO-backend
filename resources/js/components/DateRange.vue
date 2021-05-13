<template>
  <b-input-group :prepend="name">
    <b-form-input type="date" v-model="FromDate"></b-form-input>
    <b-form-input type="date" v-model="ToDate"></b-form-input>
    <b-input-group-append>
      <b-button variant="danger" @click="clear"
        ><i class="fas fa-times"></i
      ></b-button>
    </b-input-group-append>
  </b-input-group>
</template>
<script>
export default {
  data() {
    return {
      FromDate: null,
      ToDate: null,
    };
  },
  props: {
    name: {
      type: String,
      required: true,
    },
  },
  watch: {
    FromDate(new_val, old_val) {
      if (new_val && this.ToDate) {
        this.$emit("input", [new_val, this.ToDate]);
      } else {
        this.$emit("input", null);
      }
    },
    ToDate(new_val, old_val) {
      if (new_val && this.FromDate) {
        this.$emit("input", [this.FromDate, new_val]);
      } else {
        this.$emit("input", null);
      }
    },
  },
  computed: {},
  methods: {
    clear() {
      this.FromDate = null;
      this.ToDate = null;
    },
  },
};
</script>