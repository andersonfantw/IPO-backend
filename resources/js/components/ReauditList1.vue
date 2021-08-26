<template>
  <b-container fluid>
    <h1 class="text-warning text-center">
      一審資料再審核清單
      <b-spinner
        v-if="busy"
        variant="warning"
      ></b-spinner>
    </h1>
    <b-row class="mb-3">
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
          <b-form-input
            type="search"
            v-model="filters['郵箱']"
          />
        </b-input-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <!-- <DateRange :name="'提交時間'" v-model="filters['提交時間']" /> -->
        <date-picker
          name="'提交時間'"
          v-model="filters['提交時間']"
          range
          placeholder="提交時間"
        />
      </b-col>
      <b-col>
        <b-input-group prepend="AE">
          <b-form-select
            v-model="filters['AE']"
            :options="aes"
          >
          </b-form-select>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="已入金">
          <b-form-select
            v-model="filters['已入金']"
            :options="已入金"
          >
          </b-form-select>
        </b-input-group>
      </b-col>
      <b-col></b-col>
    </b-row>
    <b-row
      no-gutters
      class="mt-3"
    >
      <b-col class="text-center">
        <b-pagination
          v-if="totalRows > 0"
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="center"
        >
        </b-pagination>
      </b-col>
    </b-row>
    <b-table
      hover
      bordered
      dark
      :items="data"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filters"
      :filter-function="filter"
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
      @filtered="onFiltered"
    >
      <template #cell(操作)="data">
        <b-button
          variant="warning"
          type="button"
          @click="showClientDetails(data.item.uuid)"
        >
          <h5 class="mb-0">
            <i class="far fa-edit"></i> 審核
          </h5>
        </b-button>
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
    <ClientDetails
      ref="ClientDetails"
      :title="'客戶信息'"
      @audited="reload"
    />
  </b-container>
</template>
<script>
// import DateRange from "./DateRange";
import ClientDetails from "./ClientDetails";
import axios from "axios";
import { DecryptionMixin } from "../mixins/DecryptionMixin";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      fields: [],
      filterMatchMode: {},
      busy: false,
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
      已入金: [
        { value: null, text: "全部" },
        { value: "是", text: "是" },
        { value: "否", text: "否" },
      ],
      next_status: "audited1",
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    audit_client_url: String,
  },
  components: {
    // DateRange,
    ClientDetails,
  },
  created() {
    this.busy = true;
    this.load(1);
  },
  methods: {
    showClientDetails(uuid) {
      this.$refs.ClientDetails.showModal(uuid, this.next_status);
    },
    hideClientDetails() {
      this.$refs.ClientDetails.hideModal();
    },
    reload() {
      this.data = [];
      this.busy = true;
      this.load(1);
    },
    load(pageNumber) {
      const self = this;
      axios
        .get("ReauditList1", {
          params: {
            perPage: self.perPage,
            pageNumber: pageNumber,
          },
        })
        .then((res) => {
          console.log(res);
          const data = res.data.data;
          self.fields = res.data.fields;
          self.FilterType = res.data.filter_type;
          self.data = self.data.concat(data);
          self.totalRows = self.data.length;
          if (data.length >= self.perPage) {
            self.load(pageNumber + 1);
          } else {
            self.busy = false;
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
        return this.$store.state.ReauditList1.filters;
      },
      set(value) {
        this.$store.commit("ReauditList1/filters", value);
      },
    },
  },
  watch: {},
};
</script>
<style>
</style>