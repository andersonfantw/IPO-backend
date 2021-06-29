<template>
  <b-container fluid class="p-0">
    <b-row no-gutters>
      <b-col>
        <b-input-group prepend="帳戶號碼">
          <b-form-input
            type="search"
            v-model="filters['帳戶號碼']"
          ></b-form-input>
        </b-input-group>
      </b-col>
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
        <b-input-group prepend="電郵">
          <b-form-input type="search" v-model="filters['電郵']"></b-form-input>
        </b-input-group>
      </b-col>
    </b-row>
    <b-row no-gutters>
      <b-col cols="6">
        <DateRange :name="'投遞日期'" v-model="filters['投遞日期']" />
      </b-col>
      <b-col>
        <b-input-group prepend="狀態">
          <b-form-select v-model="filters['狀態']" :options="options">
          </b-form-select>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="電郵發送者">
          <b-form-input
            type="search"
            v-model="filters['電郵發送者']"
          ></b-form-input>
        </b-input-group>
      </b-col>
    </b-row>
    <b-row no-gutters>
      <b-col cols="6">
        <DateRange :name="'電郵發送時間'" v-model="filters['電郵發送時間']" />
      </b-col>
    </b-row>
    <b-button variant="success" @click="sendEmails"
      ><i class="far fa-envelope"></i> 一鍵發送</b-button
    >
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
      :busy="loading"
      @filtered="onFiltered"
    >
      <template #head(操作)>
        <b-form-checkbox v-model="checked" @change="selectAll" />
      </template>
      <template #cell(操作)="data">
        <b-form-checkbox v-model="selectedClients" :value="data.item" />
      </template>
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
      loading: false,
      data: null,
      selectedClients: [],
      filteredClients: [],
      User: null,
      currentPage: 1,
      perPage: 50,
      FilterType: {},
      totalRows: 0,
      options: [
        { value: null, text: "全部" },
        { value: "未發送", text: "未發送" },
        { value: "已發送", text: "已發送" },
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
    generate_ayers_account_url: String,
    user: String,
  },
  components: {
    DateRange,
  },
  created() {
    this.columns = JSON.parse(this.p_columns);
    this.FilterType = JSON.parse(this.filter_type);
    this.User = JSON.parse(this.user);
    this.loading = true;
    this.loadData();
  },
  methods: {
    selectAll(e) {
      if (e) {
        this.selectedClients = this.filteredClients;
      } else {
        this.selectedClients = [];
      }
    },
    sendEmails() {
      const self = this;
      if (self.selectedClients && self.selectedClients.length > 0) {
        self.loading = true;
        axios
          .post("api/OpenAccountEmail/send", {
            clients: self.selectedClients,
            User: self.User,
          })
          .then((response) => {
            console.log(response);
            self.loadData();
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        alert("請先選中客戶！");
      }
    },
    loadData() {
      const self = this;
      axios.post("api/SendingEmailList/all_data").then((res) => {
        const json = self.getDecryptedJsonObject(res.data);
        self.data = json.data;
        self.filteredClients = self.data;
        self.totalRows = self.data.length;
        self.loading = false;
      });
    },
    onFiltered(filteredItems) {
      this.selectedClients = [];
      this.filteredClients = filteredItems;
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
  computed: {
    filters: {
      get() {
        return this.$store.state.SendingEmailList.filters;
      },
      set(value) {
        this.$store.commit("SendingEmailList/filters", value);
      },
    },
    checked: {
      get() {
        return this.selectedClients.length == this.filteredClients.length;
      },
      set(value) {},
    },
  },
  watch: {},
};
</script>
<style>
</style>