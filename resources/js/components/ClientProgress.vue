<template>
  <b-container fluid class="p-0">
    <b-row no-gutters>
      <b-col>
        <b-input-group prepend="客户姓名">
          <b-form-input
            type="search"
            v-model="filters['客户姓名']"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="證件號碼">
          <b-form-input
            type="search"
            v-model="filters['證件號碼']"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="手機號碼">
          <b-form-input
            type="search"
            v-model="filters['手機號碼']"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="郵箱">
          <b-form-input type="search" v-model="filters['郵箱']" />
        </b-input-group>
      </b-col>
    </b-row>
    <b-row no-gutters>
      <b-col cols="6">
        <DateRange :name="'更新時間'" v-model="filters['更新時間']" />
      </b-col>
      <b-col>
        <b-input-group prepend="AE">
          <b-form-select v-model="filters['AE']" :options="aes">
          </b-form-select>
        </b-input-group>
      </b-col>
      <b-col>
        <b-button @click="query" variant="success">查詢</b-button>
      </b-col>
    </b-row>
    <b-row v-if="loading">
      <b-col class="text-center">
        <b-spinner variant="warning"></b-spinner>
      </b-col>
    </b-row>
    <b-table
      hover
      bordered
      dark
      :items="data"
      :fields="columns"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filters"
      :filter-function="filter"
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
      @filtered="onFiltered"
    >
      <template #empty="scope">
        {{ scope.emptyText }}
      </template>
      <template #emptyfiltered="scope">
        {{ scope.emptyFilteredText }}
      </template>
      <template #table-busy>
        <div class="text-center text-warning">
          <b-spinner class="align-middle"></b-spinner>
        </div>
      </template>
    </b-table>
    <b-pagination
      v-if="totalRows > 0"
      v-model="currentPage"
      :total-rows="totalRows"
      :per-page="perPage"
      align="center"
    >
    </b-pagination>
  </b-container>
</template>
<script>
import DateRange from "./DateRange";
import axios from "axios";
import { DecryptionMixin } from "../mixins/DecryptionMixin";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      columns: [],
      filterMatchMode: {},
      loading: false,
      data: [],
      selectedClients: null,
      currentPage: 1,
      perPage: 20,
      FilterType: {},
      totalRows: 0,
      aes: [
        { value: null, text: "全部" },
        { value: "梧桐花開", text: "梧桐花開" },
        { value: "劉素惠", text: "劉素惠" },
      ],
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    p_columns: {
      type: String,
      required: true,
    },
    filter_type: {
      type: String,
      required: true,
    },
  },
  components: {
    DateRange,
  },
  created() {
    this.columns = JSON.parse(this.p_columns);
    this.FilterType = JSON.parse(this.filter_type);
    // this.loading = true;
    // this.loadData(1);
  },
  methods: {
    query() {
      const self = this;
      self.loading = true;
      axios
        .post("api/ClientProgress/query", {
          客户姓名: self.filters["客户姓名"],
          證件號碼: self.filters["證件號碼"],
          手機號碼: self.filters["手機號碼"],
          郵箱: self.filters["郵箱"],
          AE: self.filters["AE"],
        })
        .then((res) => {
          console.log(res);
          self.data = res.data.data;
          self.totalRows = self.data.length;
          self.loading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    loadData(pageNumber) {
      const self = this;
      axios
        .post("api/ClientProgress/all_data", {
          perPage: self.perPage,
          pageNumber: pageNumber,
        })
        .then((res) => {
          // const json = self.getDecryptedJsonObject(res.data);
          console.log(res);
          const data = res.data.data;
          self.data = self.data.concat(data);
          self.totalRows = self.data.length;
          if (data.length >= self.perPage) {
            self.loadData(pageNumber + 1);
          } else {
            self.loading = false;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    onFiltered(filteredItems) {
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
  computed: {
    filters: {
      get() {
        return this.$store.state.ClientProgress.filters;
      },
      set(value) {
        this.$store.commit("ClientProgress/filters", value);
      },
    },
  },
};
</script>