<template>
  <b-container fluid>
    <h1 class="text-warning text-center">
      核對入款記錄
    </h1>
    <b-row class="mb-3">
      <b-col>
        <b-form-file
          v-model="file"
          :state="Boolean(file)"
          placeholder="Choose a file or drop it here..."
          drop-placeholder="Drop file here..."
        ></b-form-file>
      </b-col>
    </b-row>
    <b-row class="mb-3">
      <b-col>
        <b-button variant="success"><i class="fas fa-file-upload"></i> 上載</b-button>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      busy: false,
      file: null,
    };
  },
  created() {},
  methods: {
    upload() {
      const self = this;
      axios
        .post("")
        .then((res) => {})
        .catch((error) => {
          console.log(error);
        });
    },
  },
  computed: {},
};
</script>