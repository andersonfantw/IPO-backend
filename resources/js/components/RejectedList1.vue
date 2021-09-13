<template>
  <b-container fluid>
    <h1 class="text-warning text-center">資料駁回清單</h1>
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
      <b-col>
        <b-input-group prepend="已退款">
          <b-form-select
            v-model="filters['已退款']"
            :options="已退款"
          >
          </b-form-select>
        </b-input-group>
      </b-col>
    </b-row>
    <b-row
      v-if="busy"
      class="mt-3"
    >
      <b-col>
        <b-progress
          :max="100"
          show-progress
          animated
          variant="success"
        >
          <b-progress-bar
            :value="progress"
            :label="`${progress.toFixed(2)}%`"
          ></b-progress-bar>
        </b-progress>
      </b-col>
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
        <b-button-group>
          <b-button
            variant="success"
            type="button"
            @click="showClientDetails(data.item.uuid, null)"
          >
            <i class="far fa-eye"></i> 查看
          </b-button>
          <b-button
            v-if="data.item.已退款 == '否'"
            type="button"
            variant="danger"
            @click="refund(data.item.uuid)"
          >
            <i class="fas fa-hand-holding-usd"></i> 退款
          </b-button>
        </b-button-group>
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
      已退款: [
        { value: null, text: "全部" },
        { value: "是", text: "是" },
        { value: "否", text: "否" },
      ],
      progress: 0,
      source: null,
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    view_client_url: String,
  },
  components: {
    // DateRange,
    ClientDetails,
  },
  created() {
    this.source = axios.CancelToken.source();
    this.busy = true;
    this.getCounts(axios);
    this.load(1);
  },
  beforeDestroy() {
    this.source.cancel("Operation canceled by the user.");
  },
  methods: {
    refund(uuid) {
      const self = this;
      axios
        .post("api/RejectedList1/refund", {
          uuid: uuid,
        })
        .then((res) => {
          console.log(res);
          self.data = [];
          self.progress = 0;
          self.busy = true;
          self.load(1);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    showClientDetails(uuid) {
      this.$refs.ClientDetails.showModal(uuid);
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
        .get("RejectedList1", {
          params: {
            perPage: self.perPage,
            pageNumber: pageNumber,
          },
          cancelToken: self.source.token,
        })
        .then((res) => {
          console.log(res);
          const data = res.data.data;
          const total = res.data.total;
          self.fields = res.data.fields;
          self.FilterType = res.data.filter_type;
          self.data = self.data.concat(data);
          self.totalRows = self.data.length;
          if (total <= self.perPage) {
            self.progress = 100;
          } else {
            self.progress += (self.perPage / total) * 100;
          }
          if (data.length >= self.perPage) {
            self.load(pageNumber + 1);
          } else {
            self.busy = false;
          }
        })
        .catch((error) => {
          if (axios.isCancel(error)) {
            console.log("Request canceled", error.message);
          } else {
            console.log(error);
          }
          self.checkLogin(error);
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
        return this.$store.state.RejectedList1.filters;
      },
      set(value) {
        this.$store.commit("RejectedList1/filters", value);
      },
    },
    counts: {
      get() {
        return this.$store.state.Menu.counts;
      },
      set(value) {
        this.$store.commit("Menu/counts", value);
      },
    },
  },
  watch: {},
};
</script>
<style>
</style>